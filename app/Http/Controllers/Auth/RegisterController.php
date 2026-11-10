<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register', ['titre' => 'Inscription']);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->normaliserPlaque($request);

        $donnees = $request->validate($this->regles($request));

        $user = DB::transaction(function () use ($donnees) {
            $user = User::create([
                'nom'      => $donnees['nom'],
                'email'    => $donnees['email'],
                'password' => $donnees['password'],
                'role'     => $donnees['role'],
            ]);

            if ($user->estConducteur()) {
                $user->vehicule()->create($donnees['vehicule']);
            }

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('trajets.index');
    }

    private function regles(Request $request): array
    {
        $regles = [
            'nom'      => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', Rule::in([User::PASSAGER, User::CONDUCTEUR])],
        ];

        if ($request->input('role') === User::CONDUCTEUR) {
            $regles += $this->reglesVehicule($request);
        }

        return $regles;
    }

    private function reglesVehicule(Request $request): array
    {
        $places = $request->input('vehicule.type') === Vehicule::MOTO ? 'in:1' : 'between:1,6';

        return [
            'vehicule'           => ['required', 'array'],
            'vehicule.type'      => ['required', Rule::in([Vehicule::VOITURE, Vehicule::MOTO])],
            'vehicule.marque'    => ['required', 'string', 'max:50'],
            'vehicule.modele'    => ['required', 'string', 'max:50'],
            'vehicule.couleur'   => ['required', 'string', 'max:30'],
            'vehicule.plaque'    => ['required', 'string', 'max:20', 'unique:vehicules,plaque'],
            'vehicule.nb_places' => ['required', 'integer', $places],
        ];
    }

    private function normaliserPlaque(Request $request): void
    {
        $vehicule = $request->input('vehicule');

        if (is_array($vehicule) && is_string($vehicule['plaque'] ?? null)) {
            $vehicule['plaque'] = Vehicule::normaliserPlaque($vehicule['plaque']);
            $request->merge(['vehicule' => $vehicule]);
        }
    }
}