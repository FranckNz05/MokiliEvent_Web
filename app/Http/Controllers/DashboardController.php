<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Blog;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return $this->adminDashboard();
        } elseif ($user->hasRole('organizer')) {
            return $this->organizerDashboard();
        }

        // Récupérer les réservations avec pagination
        $reservations = $user->reservations()
            ->with(['ticket.event'])
            ->latest()
            ->paginate(10, ['*'], 'reservations_page');

        // Récupérer les paiements avec pagination
        $payments = $user->payments()
            ->with(['event', 'ticket'])
            ->latest()
            ->paginate(10, ['*'], 'payments_page');

        // Récupérer les événements favoris avec pagination
        $favorites = $user->favorites()
            ->with(['event.category'])
            ->latest()
            ->paginate(12, ['*'], 'favorites_page');

        // Statistiques
        $stats = [
            'total_reservations' => $user->reservations()->count(),
            'reservations_payees' => $user->reservations()->where('status', 'payé')->count(),
            'total_depense' => $user->payments()->where('statut', 'payé')->sum('montant'),
            'events_favoris' => $user->favorites()->count(),
            'orders_count' => $user->orders()->count(),
            'upcoming_events' => Event::whereHas('tickets.orders', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('date_debut', '>', now())->count(),
            'recent_orders' => $user->orders()->with('tickets.event')->latest()->take(5)->get(),
            'recommended_events' => Event::whereHas('categories', function($query) use ($user) {
                $query->whereIn('categories.id', $user->categories->pluck('id'));
            })->where('date_debut', '>', now())
              ->where('status', 'active')
              ->take(5)->get(),
        ];

        return view('dashboard.user', compact('reservations', 'payments', 'favorites', 'stats'));
    }

    protected function adminDashboard()
    {
        $stats = [
            'users_count' => User::count(),
            'events_count' => Event::count(),
            'orders_count' => Order::count(),
            'blogs_count' => Blog::count(),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_events' => Event::latest()->take(5)->get(),
            'recent_orders' => Order::with('user')->latest()->take(5)->get(),
        ];

        return view('dashboard.admin', compact('stats'));
    }

    protected function organizerDashboard()
    {
        $user = auth()->user();
        $stats = [
            'events_count' => $user->events()->count(),
            'active_events' => $user->events()->where('status', 'active')->count(),
            'total_orders' => Order::whereHas('tickets', function($query) use ($user) {
                $query->whereHas('event', function($q) use ($user) {
                    $q->where('organisateur_id', $user->id);
                });
            })->count(),
            'recent_events' => $user->events()->latest()->take(5)->get(),
            'recent_orders' => Order::whereHas('tickets', function($query) use ($user) {
                $query->whereHas('event', function($q) use ($user) {
                    $q->where('organisateur_id', $user->id);
                });
            })->with('user')->latest()->take(5)->get(),
        ];

        return view('dashboard.organizer', compact('stats'));
    }
}
