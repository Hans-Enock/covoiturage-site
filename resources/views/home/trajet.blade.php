@extends('layouts.app')

@section('content')
    <h1>{{ $trajet->origine }} → {{ $trajet->destination }}</h1>

    <ul>
        <li>Départ : {{ $trajet->date_heure->format('d/m/Y à H:i') }}</li>
        <li>Places restantes : {{ $trajet->places_restantes }} / {{ $trajet->places_totales }}</li>
        <li>Prix : {{ $trajet->prix > 0 ? $trajet->prix . ' FCFA' : 'Gratuit' }}</li>
        <li>Statut : {{ $trajet->statut }}</li>
        <li>Conducteur : {{ $trajet->conducteur->nom }}</li>
    </ul>

    <p><a href="{{ route('trajets.index') }}">← Retour aux trajets</a></p>
@endsection
