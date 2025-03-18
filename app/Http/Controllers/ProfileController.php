<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'prenom' => ['required', 'string', 'max:255'],
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'bio' => ['nullable', 'string', 'max:500'],
            'profile_image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('profile_image')) {
            // Supprimer l'ancienne image si elle existe et n'est pas une URL
            if ($user->profil_image && !filter_var($user->profil_image, FILTER_VALIDATE_URL)) {
                Storage::delete($user->profil_image);
            }
            
            $path = $request->file('profile_image')->store('profile-photos', 'public');
            $validated['profil_image'] = Storage::url($path);
        }

        $user->update($validated);

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }

    public function updateProfileCompletion(Request $request)
    {
        $user = Auth::user();

        // Calculer le pourcentage de complétion basé sur les champs remplis
        $totalFields = 5; // Nombre total de champs requis
        $filledFields = 0;

        if ($user->name) $filledFields++;
        if ($user->email) $filledFields++;
        if ($user->phone) $filledFields++;
        if ($user->profil_image) $filledFields++;
        if ($user->bio) $filledFields++;

        $completionPercentage = ($filledFields / $totalFields) * 100;

        // Mettre à jour le champ is_profile_complete
        $user->is_profile_complete = ($completionPercentage === 100) ? 1 : 0;
        $user->save();

        return redirect()->route('profile.edit')->with('status', 'Profil mis à jour avec succès.');
    }
}
