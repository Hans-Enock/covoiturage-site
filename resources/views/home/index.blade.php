@extends('layouts.app')

@section('content')
    <h1>Covoiturage</h1>
    <p><a href="{{ route('trajets.index') }}">Voir les trajets disponibles</a></p>
@endsection
