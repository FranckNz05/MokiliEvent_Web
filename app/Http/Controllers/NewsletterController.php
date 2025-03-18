<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:newsletters,email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cet email est déjà inscrit à notre newsletter.'
            ]);
        }

        try {
            Newsletter::create([
                'email' => $request->email
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Merci de votre inscription à notre newsletter !'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur est survenue. Veuillez réessayer.'
            ]);
        }
    }
}
