<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('about.index');
    }

    public function contact()
    {
        return view('contact.index');
    }

    public function submitContact(Request $request)
    {
        // Logique pour traiter le formulaire de contact
    }


    public function terms()
    {
        return view('legal.terms');
    }

    public function privacy()
    {
        return view('legal.privacy');
    }

    public function faq()
    {
        return view('faq.index');
    }

    public function newsletterSubscribe(Request $request)
    {
        // Logique pour gérer l'abonnement à la newsletter
    }
}
