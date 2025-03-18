<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Event;
use App\Models\Ticket;

class UserController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        
        return response()->json([
            'status' => true,
            'data' => $user
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            
            // Upload new image
            $imagePath = $request->file('profile_image')->store('profiles', 'public');
            $user->profile_image = $imagePath;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully',
            'data' => $user
        ]);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Current password is incorrect'
            ], 401);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Password changed successfully'
        ]);
    }

    public function dashboardStats()
    {
        $user = auth()->user();

        // Statistiques pour les organisateurs
        $eventStats = [
            'total_events' => Event::where('user_id', $user->id)->count(),
            'active_events' => Event::where('user_id', $user->id)
                ->where('status', 'active')
                ->where('end_date', '>=', now())
                ->count(),
            'past_events' => Event::where('user_id', $user->id)
                ->where('end_date', '<', now())
                ->count(),
        ];

        // Statistiques pour les utilisateurs
        $ticketStats = [
            'total_tickets' => Ticket::where('user_id', $user->id)->count(),
            'upcoming_tickets' => Ticket::where('user_id', $user->id)
                ->whereHas('event', function ($query) {
                    $query->where('start_date', '>', now());
                })
                ->count(),
            'used_tickets' => Ticket::where('user_id', $user->id)
                ->where('status', 'used')
                ->count(),
        ];

        // Événements à venir
        $upcomingEvents = Event::where('user_id', $user->id)
            ->where('status', 'active')
            ->where('start_date', '>', now())
            ->orderBy('start_date', 'asc')
            ->take(5)
            ->get();

        return response()->json([
            'status' => true,
            'data' => [
                'event_stats' => $eventStats,
                'ticket_stats' => $ticketStats,
                'upcoming_events' => $upcomingEvents,
            ]
        ]);
    }
}
