<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Services\ImageService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        ($request->all());
        $request->validate([
            'prenom' => ['required', 'string', 'max:255'],
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'profile_photo' => ['nullable', 'image', 'max:2048'], // 2MB max
        ]);

        // Gérer la photo de profil
        $profileImageUrl = null;
        if ($request->hasFile('profile_photo')) {
            $profileImageUrl = $this->imageService->handleProfilePhoto($request->file('profile_photo'));
        } else {
            // Générer un avatar par défaut avec les initiales
            $initials = strtoupper(substr($request->prenom, 0, 1) . substr($request->nom, 0, 1));
            $profileImageUrl = 'https://ui-avatars.com/api/?name=' . urlencode($initials) . '&background=random&size=' . ImageService::PROFILE_WIDTH;
        }

        try {
            Log::info('Tentative de création de l\'utilisateur');
            $user = User::create([
                'prenom' => $request->prenom,
                'nom' => $request->nom,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'profil_image' => $profileImageUrl,
            ]);

            $user->assignRole(1);
            event(new Registered($user));
            Auth::login($user);
            return redirect()->route('verification.notice');
        } catch (Exception $e) {
            dd('Erreur lors de l\'inscription : ' . $e->getMessage());
        }
    }
}