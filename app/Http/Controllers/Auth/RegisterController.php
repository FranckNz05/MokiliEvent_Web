<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\OTPVerification;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Générer OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $otp_expires_at = now()->addMinutes(10);

        // Créer l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'otp' => $otp,
            'otp_expires_at' => $otp_expires_at,
            'email_verified_at' => null,
        ]);

        // Envoyer l'email avec OTP
        Mail::to($user->email)->send(new OTPVerification($otp));

        // Rediriger vers la page de vérification
        return redirect()->route('verification.notice')->with([
            'message' => 'Un code de vérification a été envoyé à votre adresse email.',
            'email' => $user->email
        ]);
    }

    public function showVerificationForm()
    {
        if (!session('email')) {
            return redirect()->route('register');
        }

        return view('auth.verify-otp');
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)
                    ->where('otp', $request->otp)
                    ->where('otp_expires_at', '>', now())
                    ->first();

        if (!$user) {
            return back()->withErrors([
                'otp' => 'Le code de vérification est invalide ou a expiré.'
            ]);
        }

        // Marquer l'email comme vérifié
        $user->email_verified_at = now();
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        // Connecter l'utilisateur
        auth()->login($user);

        return redirect()->route('home')->with('success', 'Votre compte a été vérifié avec succès !');
    }

    public function resendOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        // Générer nouveau OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $otp_expires_at = now()->addMinutes(10);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => $otp_expires_at
        ]);

        // Envoyer le nouvel email
        Mail::to($user->email)->send(new OTPVerification($otp));

        return back()->with('message', 'Un nouveau code de vérification a été envoyé.');
    }
}
