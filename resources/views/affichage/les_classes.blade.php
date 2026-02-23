@extends('base.base_admin')

@section('content')
@include('partials.alerts')
<div class="container">
    <h2 class="mb-4">Gestion des Classes</h2>

    <!-- ✅ Formulaire d'ajout -->
    <form action="{{ route('classes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="niveau" class="form-label">Niveau</label>
            <input type="text" name="niveau" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>

    <!-- 🧾 Table des classes existantes -->
    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Niveau</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($classes as $classe)
            <tr>
                <td>{{ $classe->id }}</td>
                <td>{{ $classe->niveau }}</td>
                <td>
                    
                    <!-- ❌ Formulaire de suppression -->
                    <form action="{{ route('classes.destroy', $classe->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Confirmer la suppression ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection