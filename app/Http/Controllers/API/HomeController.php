<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        try {
            // Récupérer les événements à venir
            $events = Event::with(['category', 'user'])
                ->where('status', 'upcoming')
                ->where('is_approved', true)
                ->where('end_date', '>=', now())
                ->orderBy('start_date', 'asc')
                ->take(10)
                ->get()
                ->map(function ($event) {
                    return [
                        'id' => $event->id,
                        'title' => $event->title,
                        'description' => $event->description,
                        'start_date' => optional($event->start_date)->format('Y-m-d H:i:s'),
                        'end_date' => optional($event->end_date)->format('Y-m-d H:i:s'),
                        'location' => $event->location,
                        'venue' => $event->venue ?? $event->location,
                        'image' => $event->image,
                        'price' => $event->price,
                        'formatted_price' => $event->formatted_price ?? number_format($event->price, 0, ',', ' ') . ' FCFA',
                        'available_tickets' => $event->available_tickets ?? 0,
                        'category' => $event->category ? [
                            'id' => $event->category->id,
                            'name' => $event->category->name
                        ] : null,
                        'organizer' => $event->user ? [
                            'id' => $event->user->id,
                            'name' => $event->user->name ?? $event->user->email
                        ] : null
                    ];
                });

            // Récupérer les organisateurs
            $organizers = User::role('organizer')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
                ->map(function ($organizer) {
                    return [
                        'id' => $organizer->id,
                        'name' => $organizer->name ?? $organizer->email,
                        'email' => $organizer->email,
                        'profile_image' => $organizer->profile_image ?? 'img/users/default.jpg'
                    ];
                });

            return response()->json([
                'status' => true,
                'promoted_events' => $events,
                'followed_events' => [],  // À implémenter plus tard si nécessaire
                'organizers' => $organizers,
                'message' => 'Données récupérées avec succès'
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur dans HomeController@index: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Une erreur est survenue lors du chargement des données',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
