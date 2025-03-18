<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Organizer;
use App\Models\Event;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Carbon\Carbon;

class OrganizerController extends Controller
{
    public function register()
    {
        return view('organizer.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'string', 'max:20'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'company_address' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'status' => 'active',
        ]);

        $user->assignRole('organizer');

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Votre compte organisateur a été créé avec succès !');
    }

    public function index()
    {
        $organizers = Organizer::withCount(['events', 'followers'])
            ->with('user')
            ->orderBy('events_count', 'desc')
            ->paginate(12);

        return view('organizers.index', compact('organizers'));
    }

    public function show(Organizer $organizer)
    {
        // Charger les relations nécessaires
        $organizer->load(['user', 'events' => function ($query) {
            $query->where('start_date', '>', Carbon::now())
                  ->orderBy('start_date', 'asc');
        }]);

        // Récupérer le nombre d'abonnés
        $organizer->loadCount('followers');

        // Récupérer les événements
        $events = $organizer->events()
            ->with(['category'])
            ->orderBy('start_date', 'desc')
            ->paginate(6);

        // Récupérer les articles de blog
        $blogPosts = Blog::where('user_id', $organizer->user_id)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return view('organizers.show', compact('organizer', 'events', 'blogPosts'));
    }

    public function follow(Organizer $organizer)
    {
        $user = auth()->user();

        // Vérifier que l'utilisateur ne s'abonne pas à lui-même
        if ($user->id === $organizer->user_id) {
            return back()->with('error', 'Vous ne pouvez pas vous abonner à vous-même.');
        }

        // Ajouter ou retirer l'abonnement
        if ($user->isFollowing($organizer)) {
            return back()->with('error', 'Vous suivez déjà cet organisateur.');
        }

        $user->following()->attach($organizer->id);

        return back()->with('success', 'Vous suivez maintenant ' . $organizer->company_name);
    }

    public function unfollow(Organizer $organizer)
    {
        $user = auth()->user();

        if (!$user->isFollowing($organizer)) {
            return back()->with('error', 'Vous ne suivez pas cet organisateur.');
        }

        $user->following()->detach($organizer->id);

        return back()->with('success', 'Vous ne suivez plus ' . $organizer->company_name);
    }

    public function requestOrganizer(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_primary' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        // Créer une nouvelle demande d'organisateur
        $requestOrganizer = new OrganizerRequest();
        $requestOrganizer->user_id = auth()->id();
        $requestOrganizer->company_name = $validated['company_name'];
        $requestOrganizer->email = $validated['email'];
        $requestOrganizer->phone_primary = $validated['phone_primary'];
        $requestOrganizer->address = $validated['address'];
        $requestOrganizer->status = 'en attente';
        $requestOrganizer->save();

        return redirect()->route('organizer.request.form')->with('success', 'Demande soumise avec succès.');
    }

    public function handleOrganizerRequest(Request $request, OrganizerRequest $organizerRequest)
    {
        // Code pour traiter les demandes d'organisateur
    }
}
