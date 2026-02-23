@extends('base.base_admin')

@section('content')
@include('partials.alerts')

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-success text-white">
        <h6 class="m-0 font-weight-bold">Gestion des Élèves</h6>
        <button class="btn btn-light" type="button" data-bs-toggle="modal" data-bs-target="#ajoutEleveModal">
            <i class="fas fa-user-plus me-1"></i> Ajouter Élève
        </button>
    </div>

    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" id="searchInput" placeholder="Rechercher un élève...">
                </div>
            </div>

            <div class="col-md-6">
                <form action="{{ route('rechercher_eleve') }}" method="GET" class="input-group">
                    <select name="id" class="form-select">
                        <option value="">Toutes les classes</option>
                        @foreach($classes as $cls)
                        <option value="{{ $cls->id }}" {{ isset($classe) && $classe->id == $cls->id ? 'selected' : '' }}>
                            {{ $cls->niveau }}
                        </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-1"></i> Filtrer
                    </button>
                </form>
            </div>
        </div>

        @if($les_eleves_->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-hover" id="elevesTable">
                <thead class="table-dark">
                    <tr>
                        <th width="80px">Photo</th>
                        <th>Matricule</th>
                        <th>Nom Complet</th>
                        <th>Naissance</th>
                        <th>Classe</th>
                        <th>Responsable</th>
                        <th>Accès</th>
                        <th width="120px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($les_eleves_ as $eleve)
                    <tr>
                        <td>
                            <div class="avatar-container">
                                @if($eleve->photo)
                                <img src="{{ Storage::url($eleve->photo) }}" class="avatar-img" alt="{{ $eleve->nom }}" width="60px">
                                @else
                                <div class="avatar-default">
                                    <i class="fas fa-user"></i>
                                </div>
                                @endif
                            </div>
                        </td>
                        <td>{{ $eleve->id }}</td>
                        <td>
                            <strong>{{ $eleve->nom_complet ?? $eleve->nom }}</strong><br>
                            <small class="text-muted">{{ $eleve->sexe == 'M' ? '♂ Masculin' : '♀ Féminin' }}</small>
                        </td>
                        <td>
                            {{ date("d-M-Y", strtotime($eleve->dateN)) }}<br>
                            <small class="text-muted">{{ $eleve->lieuN }}</small>
                        </td>
                        <td>
                            <span class="badge bg-info text-dark">
                                {{ $eleve->classe->niveau ?? 'N/C' }}
                            </span>
                        </td>
                        <td>
                            @if($eleve->user)
                            <span class="badge bg-light text-dark">
                                {{ $eleve->user->name }}
                            </span>
                            @else
                            <span class="badge bg-warning text-dark">Non associé</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $eleve->etat == 'admis' ? 'success' : 'danger' }} text-white">
                                {{ ucfirst($eleve->etat) }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <button class="btn btn-outline-primary edit-eleve-btn"
                                    data-eleve-id="{{ $eleve->id }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editEleveModal-{{ $eleve->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('eleves.destroy', $eleve->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cet élève ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger confirm-delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle me-2"></i> Aucun élève trouvé pour cette classe
        </div>
        @endif
    </div>
</div>

<!-- Modal Ajout -->
<div class="modal fade" id="ajoutEleveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><i class="fas fa-user-graduate me-2"></i>Ajouter un Élève</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('eleves.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nom" class="form-label">Nom de l'élève</label>
                            <input type="text" class="form-control" id="nom" name="nom" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="dateN" class="form-label">Date de naissance</label>
                            <input type="date" class="form-control" id="dateN" name="dateN" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="lieuN" class="form-label">Lieu de naissance</label>
                            <input type="text" class="form-control" id="lieuN" name="lieuN" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sexe" class="form-label">Sexe</label>
                            <select class="form-select" id="sexe" name="sexe" required>
                                <option value="">Choisir...</option>
                                <option value="M">Masculin</option>
                                <option value="F">Féminin</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="classe_id" class="form-label">Classe</label>
                            <select name="classe_id" id="classe_id" class="form-select" required>
                                @foreach ($classes as $cls)
                                <option value="{{ $cls->id }}">{{ $cls->niveau }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="user_id" class="form-label">Responsable</label>
                            <select name="user_id" id="user_id" class="form-select">
                                <option value="">-- Sélectionner Responsable --</option>
                                @foreach($les_users as $us)
                                <option value="{{$us->id}}">{{$us->name}} ({{$us->id}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="etat" class="form-label">État</label>
                            <select class="form-select" id="etat" name="etat">
                                <option value="admis">Admis</option>
                                <option value="non admis">Non admis</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="photo" name="photo">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Modification -->
@foreach ($les_eleves_ as $eleve)
<div class="modal fade" id="editEleveModal-{{ $eleve->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i> Modifier Élève: {{ $eleve->nom }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editEleveForm-{{ $eleve->id }}" action="{{ route('eleves.update', $eleve->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_nom_{{ $eleve->id }}" class="form-label">Nom de l'élève</label>
                            <input type="text" class="form-control" id="edit_nom_{{ $eleve->id }}" name="nom" value="{{ $eleve->nom }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_dateN_{{ $eleve->id }}" class="form-label">Date de naissance</label>
                            <input type="date" class="form-control" id="edit_dateN_{{ $eleve->id }}" name="dateN" value="{{ date('Y-m-d', strtotime($eleve->dateN)) }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_lieuN_{{ $eleve->id }}" class="form-label">Lieu de naissance</label>
                            <input type="text" class="form-control" id="edit_lieuN_{{ $eleve->id }}" name="lieuN" value="{{ $eleve->lieuN }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_sexe_{{ $eleve->id }}" class="form-label">Sexe</label>
                            <select class="form-select" id="edit_sexe_{{ $eleve->id }}" name="sexe" required>
                                <option value="">Choisir...</option>
                                <option value="M" {{ $eleve->sexe == 'M' ? 'selected' : '' }}>Masculin</option>
                                <option value="F" {{ $eleve->sexe == 'F' ? 'selected' : '' }}>Féminin</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_classe_id_{{ $eleve->id }}" class="form-label">Classe</label>
                            <select name="classe_id" id="edit_classe_id_{{ $eleve->id }}" class="form-select" required>
                                @foreach ($classes as $cls)
                                <option value="{{ $cls->id }}" {{ $cls->id == $eleve->classe_id ? 'selected' : '' }}>
                                    {{ $cls->niveau }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_user_id_{{ $eleve->id }}" class="form-label">Responsable</label>
                            <select name="user_id" id="edit_user_id_{{ $eleve->id }}" class="form-select">
                                <option value="">-- Sélectionner Responsable --</option>
                                @foreach ($les_users as $us)
                                <option value="{{ $us->id }}" {{ $us->id == $eleve->user_id ? 'selected' : '' }}>
                                    {{ $us->name }} ({{ $us->id }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_etat_{{ $eleve->id }}" class="form-label">État</label>
                            <select class="form-select" id="edit_etat_{{ $eleve->id }}" name="etat">
                                <option value="admis" {{ $eleve->etat == 'admis' ? 'selected' : '' }}>Admis</option>
                                <option value="non admis" {{ $eleve->etat == 'non admis' ? 'selected' : '' }}>Non admis</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_photo_{{ $eleve->id }}" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="edit_photo_{{ $eleve->id }}" name="photo">
                            @if($eleve->photo)
                            <div class="mt-2">
                                <img id="edit_photo_preview_{{ $eleve->id }}"
                                    src="{{ Storage::url($eleve->photo) }}"
                                    alt="Photo actuelle"
                                    style="max-width: 100px;">
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@section('styles')
<style>
    .avatar-container {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-default {
        font-size: 1.5rem;
        color: #6c757d;
    }

    .badge {
        font-weight: 500;
    }

    .btn-group {
        flex-wrap: nowrap;
    }

    .is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }
</style>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Gestion de la prévisualisation photo pour chaque modal
        $('input[id^="edit_photo_"]').change(function(e) {
            const inputId = $(this).attr('id');
            const eleveId = inputId.replace('edit_photo_', '');
            const reader = new FileReader();
            const previewId = '#edit_photo_preview_' + eleveId;

            reader.onload = function(e) {
                if ($(previewId).length) {
                    $(previewId).attr('src', e.target.result);
                } else {
                    // Créer un élément de prévisualisation s'il n'existe pas
                    $(this).closest('.mb-3').append(
                        '<div class="mt-2">' +
                        '<img id="edit_photo_preview_' + eleveId + '" src="' + e.target.result + '" alt="Nouvelle photo" style="max-width: 100px;">' +
                        '</div>'
                    );
                }
            }.bind(this);

            reader.readAsDataURL(this.files[0]);
        });

        // Confirmation suppression
        $('.confirm-delete').click(function(e) {
            if (!confirm('Voulez-vous vraiment supprimer cet élève ?')) {
                e.preventDefault();
            }
        });

        // Recherche
        $('#searchInput').keyup(function() {
            const value = $(this).val().toLowerCase();
            $('#elevesTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // Validation formulaire ajout
        $('#ajoutEleveModal form').submit(function(e) {
            let isValid = true;
            $(this).find('[required]').each(function() {
                if (!$(this).val()) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            const photoInput = $('#photo');
            if (photoInput[0].files.length > 0) {
                const file = photoInput[0].files[0];
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];

                if (!validTypes.includes(file.type)) {
                    photoInput.addClass('is-invalid');
                    photoInput.next('.invalid-feedback').remove();
                    photoInput.after('<div class="invalid-feedback">Format non supporté</div>');
                    isValid = false;
                } else if (file.size > 2048 * 1024) {
                    photoInput.addClass('is-invalid');
                    photoInput.next('.invalid-feedback').remove();
                    photoInput.after('<div class="invalid-feedback">Taille max: 2MB</div>');
                    isValid = false;
                } else {
                    photoInput.removeClass('is-invalid');
                }
            }

            if (!isValid) e.preventDefault();
        });
    });
</script>
@endsection
@endsection