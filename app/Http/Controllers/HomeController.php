<?php

namespace App\Http\Controllers;

use App\Models\Trajet;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home.index', ['titre' => 'Accueil']);
    }

    public function trajets(): View
    {
        return view('home.trajets', [
            'titre'   => 'Trajets',
            'trajets' => Trajet::all(),
        ]);
    }

    public function trajet(Trajet $trajet): View
    {
        $trajet->load('conducteur');

        return view('home.trajet', [
            'titre'  => 'Trajet',
            'trajet' => $trajet,
        ]);
    }
}
