@extends('base.base_parent')
@section('content')
<div>
    <div class="container alert alert-info">
        <h1><b>Mon Profil</b></h1>
        <p><strong>Nom:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
    </div>

    <div class="row">
        <h1>
            <b>Éleve(s)</b>
        </h1>
        @forelse ($mes_enfants as $enfant)
            <div class="card" style="width: 18rem; margin-bottom: 20px;">
                <p><strong>Nom:</strong> {{ $enfant->nom }}</p>
                <p><strong>classe:</strong> {{ $enfant->classe->niveau ?? "Non assignée" }}</p>
                <p class="form-control">Admition: 
                    <span class="badge 
                    @if ($enfant->etat == 'admis') bg-success
                    @else bg-danger
                    @endif">{{ ucfirst($enfant->etat) }}</span>
                </p>
            </div>
        @empty
            <p>Aucun enfant associé à ce profil.</p>
        @endforelse
    </div>
</div>
@endsection