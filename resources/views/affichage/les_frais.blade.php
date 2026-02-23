@extends('base.base_admin')

@section('content')
@include('partials.alerts')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="text-primary"><i class="fas fa-receipt me-2"></i> Les Frais</h4>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#ajoutfraisModal">
            <i class="fas fa-plus-circle me-1"></i> Ajouter Frais
        </button>
    </div>

    <table class="table table-hover table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Libellé</th>
                <th>Montant</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($les_frais as $frais)
            <tr>
                <td>{{ $frais->id }}</td>
                <td>{{ $frais->libelle }}</td>
                <td>{{ number_format($frais->montant, 0, ',', ' ') }} CDF</td>
                <td class="d-flex gap-2">
                    <!-- Bouton Modifier -->
                    <button type="button" class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#editfraisModal{{ $frais->id }}"
                        data-frais-id="{{ $frais->id }}"
                        data-frais-name="{{ $frais->libelle }}"
                        data-frais-amount="{{ $frais->montant }}">
                        <i class="fa fa-edit"></i>
                    </button>

                    <!-- Bouton Supprimer -->
                    <form action="{{ route('les_frais.destroy', $frais->id) }}" method="POST" onsubmit="return confirm('Supprimer ce frais ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal d'ajout -->
<div class="modal fade" id="ajoutfraisModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('les_frais.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i> Nouveau Frais</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="libelle" class="form-label">Libellé</label>
                    <input type="text" name="libelle" id="libelle" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="montant" class="form-label">Montant (CDF)</label>
                    <input type="number" name="montant" id="montant" class="form-control" min="0" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> Enregistrer</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de modification (unique) -->
@foreach ($les_frais as $frais)
<div class="modal fade" id="editfraisModal{{ $frais->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editfraisForm{{ $frais->id }}" action="{{ route('les_frais.update', $frais->id)}}" method="POST" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i> Modifier Frais</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="edit_frais_{{ $frais->id }}" class="form-label">libellé</label>
                    <input type="text" name="libelle" id="edit_frais_{{ $frais->id }}" value="{{ $frais->libelle }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="edit_montant_{{ $frais->id }}" class="form-label">Montant (CDF)</label>
                    <input type="number" name="montant" id="edit_montant_{{ $frais->id }}" value="{{ $frais->montant }}" min=0 class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> Enregistrer</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            </div>
        </form>
    </div>
</div>
@endforeach

@section('scripts')
<script>
    // Gestion du modal d'édition
    document.addEventListener('DOMContentLoaded', function() {
        const editModal = document.getElementById('editfraisModal');

        editModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const fraisId = button.getAttribute('data-frais-id');
            const fraisName = button.getAttribute('data-frais-name');
            const fraisAmount = button.getAttribute('data-frais-amount');

            // Mise à jour du formulaire
            const form = editModal.querySelector('#editfraisForm');
            form.action = `/les_frais/${fraisId}`;

            document.getElementById('edit_frais').value = fraisName;
            document.getElementById('edit_montant').value = fraisAmount;
        });
    });
</script>
@endsection
@endsection