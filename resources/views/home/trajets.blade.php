@extends('layouts.app')

@section('content')
    <h1>Liste des trajets</h1>

    <ul>
        @forelse ($trajets as $trajet)
            <li>
                <a href="{{ route('trajets.show', $trajet) }}">
                    {{ $trajet->origine }} → {{ $trajet->destination }}
                </a>
            </li>
        @empty
            <li>Aucun trajet pour le moment.</li>
        @endforelse
    </ul>
@endsection
