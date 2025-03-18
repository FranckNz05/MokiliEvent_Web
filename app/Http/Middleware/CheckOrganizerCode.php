<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckOrganizerCode
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->hasRole('organizer')) {
            if (!auth()->user()->organizer_code) {
                return redirect()->route('organizer.setup')
                    ->with('warning', 'Veuillez configurer votre code organisateur.');
            }
        }

        return $next($request);
    }
}
