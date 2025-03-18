<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::query()
            ->with(['category', 'organizer', 'tickets'])
            ->where('is_approved', true)
            ->where('is_published', true)
            ->where('etat', 'En cours')
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('category', function ($q) use ($request) {
                    $q->where('slug', $request->category);
                });
            })
            ->when($request->filled('ville'), function ($query) use ($request) {
                $query->where('ville', $request->ville);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%')
                      ->orWhere('keywords', 'like', '%' . $request->search . '%');
                });
            })
            ->orderBy('start_date', 'asc')
            ->paginate(12);

        $categories = Category::all();
        $villes = Event::select('ville')->distinct()->get()->pluck('ville');

        return view('events.index', compact('events', 'categories', 'villes'));
    }

    public function featured()
    {
        $events = Event::where('is_featured', true)
            ->where('status', 'published')
            ->orderBy('start_date', 'asc')
            ->paginate(12);

        return view('events.featured', compact('events'));
    }

    public function upcoming()
    {
        $events = Event::where('start_date', '>', now())
            ->where('status', 'published')
            ->orderBy('start_date', 'asc')
            ->paginate(12);

        return view('events.upcoming', compact('events'));
    }

    public function past()
    {
        $events = Event::where('end_date', '<', now())
            ->where('status', 'published')
            ->orderBy('start_date', 'desc')
            ->paginate(12);

        return view('events.past', compact('events'));
    }

    public function byCategory(Category $category)
    {
        $events = Event::whereHas('category', function ($query) use ($category) {
            $query->where('id', $category->id);
        })
        ->where('status', 'published')
        ->orderBy('start_date', 'asc')
        ->paginate(12);

        return view('events.category', compact('events', 'category'));
    }

    public function byLocation(Location $location)
    {
        $events = Event::where('location_id', $location->id)
            ->where('status', 'published')
            ->orderBy('start_date', 'asc')
            ->paginate(12);

        return view('events.location', compact('events', 'location'));
    }

    public function show(Event $event)
    {
        // Ajouter une vue si l'utilisateur est connecté
        if (auth()->check()) {
            $event->views()->create([
                'user_id' => auth()->id(),
                'viewable_id' => $event->id,
                'viewed_type' => 'Event'
            ]);
        }

        // Charger les relations nécessaires
        $event->load(['category', 'organizer', 'tickets']);

        // Récupérer les événements similaires
        $similarEvents = Event::where('id', '!=', $event->id)
            ->where('category_id', $event->category_id)
            ->where('start_date', '>=', now())
            ->where('is_published', true)
            ->where('is_approved', true)
            ->orderBy('start_date')
            ->limit(3)
            ->get();

        // Vérifier si l'utilisateur est connecté
        $isLiked = false;
        $isFavorite = false;
        if (auth()->check()) {
            $isLiked = $event->likes()->where('user_id', auth()->id())->exists();
            $isFavorite = $event->favorites()->where('user_id', auth()->id())->exists();
        }

        return view('events.show', compact('event', 'similarEvents', 'isLiked', 'isFavorite'));
    }

    public function create()
    {
        $categories = Category::all();
        $locations = Location::all();

        return view('events.create', compact('categories', 'locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'adresse' => 'required|string',
            'ville' => 'required|string',
            'pays' => 'required|string',
            'adresse_map' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'event_type' => 'required|string',
            'keywords' => 'nullable|string',
            'etat' => 'required|string'
        ]);

        // Générer le slug à partir du titre
        $validated['slug'] = Str::slug($validated['title']);

        // Traitement de l'image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $validated['slug'] . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('events'), $imageName);
            $validated['image'] = 'events/' . $imageName;
        }

        $validated['organizer_id'] = auth()->user()->organizer->id;
        $validated['is_approved'] = false;
        $validated['is_published'] = false;
        $validated['status'] = 'draft';

        $event = Event::create($validated);

        return redirect()->route('events.show', $event->slug)
            ->with('success', 'Événement créé avec succès.');
    }

    public function edit(Event $event)
    {
        $this->authorize('update', $event);

        $categories = Category::all();
        $locations = Location::all();

        return view('events.edit', compact('event', 'categories', 'locations'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorize('update', $event);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'image' => 'nullable|image|max:2048',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
        ]);

        $event->update($validated);

        if ($request->hasFile('image')) {
            $event->addMediaFromRequest('image')
                ->toMediaCollection('events');
        }

        return redirect()->route('events.show', $event)
            ->with('success', 'Événement mis à jour avec succès.');
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        $event->delete();

        return redirect()->route('events.browse')
            ->with('success', 'Événement supprimé avec succès.');
    }

    public function publish(Event $event)
    {
        $this->authorize('update', $event);

        $event->update(['status' => 'published']);

        return back()->with('success', 'Événement publié avec succès.');
    }

    public function unpublish(Event $event)
    {
        $this->authorize('update', $event);

        $event->update(['status' => 'draft']);

        return back()->with('success', 'Événement dépublié avec succès.');
    }

    public function tickets(Event $event)
    {
        return view('events.tickets', compact('event'));
    }

    public function purchaseTickets(Request $request, Event $event)
    {
        DB::beginTransaction();

        try {
            // Valider les données du panier
            $validated = $request->validate([
                'tickets' => 'required|array',
                'tickets.*.ticket_id' => 'required|exists:tickets,id',
                'tickets.*.quantity' => 'required|integer|min:0'
            ]);

            // Filtrer les tickets avec une quantité > 0
            $ticketsData = collect($validated['tickets'])->filter(function ($item) {
                return $item['quantity'] > 0;
            })->values();

            // Vérifier qu'au moins un ticket a été sélectionné
            if ($ticketsData->isEmpty()) {
                throw new \Exception('Veuillez sélectionner au moins un billet.');
            }

            $montantTotal = 0;
            $processedTickets = [];

            // Vérifier la disponibilité et calculer le montant total
            foreach ($ticketsData as $ticketData) {
                $ticket = $event->tickets()->findOrFail($ticketData['ticket_id']);
                $remainingTickets = $ticket->quantite - $ticket->quantite_vendue;

                if ($remainingTickets < $ticketData['quantity']) {
                    throw new \Exception("Désolé, il ne reste que {$remainingTickets} billets disponibles pour {$ticket->nom}.");
                }

                $montant = $ticket->montant_promotionnel && now()->between($ticket->promotion_start, $ticket->promotion_end)
                    ? $ticket->montant_promotionnel * $ticketData['quantity']
                    : $ticket->prix * $ticketData['quantity'];

                $montantTotal += $montant;
                $processedTickets[] = [
                    'ticket' => $ticket,
                    'quantity' => $ticketData['quantity'],
                    'montant' => $montant
                ];
            }

            // Créer la commande principale
            $order = Order::create([
                'matricule' => 'CMD-' . strtoupper(Str::random(8)),
                'user_id' => auth()->id(),
                'ticket_id' => $processedTickets[0]['ticket']->id, // Ticket principal
                'evenement_id' => $event->id,
                'quantity' => collect($processedTickets)->sum('quantity'),
                'montant_total' => $montantTotal,
                'statut' => 'en_attente'
            ]);

            // Mettre à jour les quantités vendues
            foreach ($processedTickets as $data) {
                $data['ticket']->increment('quantite_vendue', $data['quantity']);
            }

            DB::commit();

            // Rediriger vers la page de paiement
            return redirect()->route('payments.process', ['order' => $order->id])
                ->with('success', 'Votre commande a été créée avec succès. Procédez au paiement.');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Erreur lors de l\'achat des billets: ' . $e->getMessage());
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function ticketCheckout(Event $event)
    {
        return view('events.checkout', compact('event'));
    }

    public function byVille($ville)
    {
        $events = Event::where('ville', $ville)
            ->where('is_approved', true)
            ->where('etat', 'En cours')
            ->where('is_published', true)
            ->with(['category', 'organizer'])
            ->orderBy('start_date', 'asc')
            ->paginate(9);

        $categories = Category::all();
        $villes = Event::where('is_approved', true)
            ->where('etat', 'En cours')
            ->where('is_published', true)
            ->select('ville')
            ->distinct()
            ->orderBy('ville')
            ->pluck('ville');

        return view('events.index', compact('events', 'categories', 'villes', 'ville'));
    }
}
