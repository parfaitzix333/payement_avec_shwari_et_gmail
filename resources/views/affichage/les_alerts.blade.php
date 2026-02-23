@extends('base.base_admin')

@section('content')
@include('partials.alerts')
<div class="container">
    <h2 class="mb-4">Gestion des Alertes</h2>

    <div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#alertModal">Ajouter une alerte personalisée</button>
        <button class="btn btn-success" data-bs-toggle="collapse" data-bs-target="#sendCommunModal">Diffusion</button>
    </div>

    <div class="collapse" id="sendCommunModal">
        <div class="card card-body">
            <form action="{{ route('diffuser') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="alerts" class="form-label">Message à Diffuser</label>
                    <textarea class="form-control" name="alerts" id="alerts" rows="5"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Diffuser</button>
            </form>
        </div>
    </div>
    <!-- Table des alertes existantes -->
    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Message</th>
                <th>Temps de l'alerte</th>
                <th>Utilisateur concerné</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alerts as $alert)
            <tr>
                <td>{{ $alert->id }}</td>
                <td>{{ $alert->message }}</td>
                <td>{{ $alert->alert_date }}</td>
                <td>{{ $alert->user ? $alert->user->name : 'N/A' }}</td>
                <td>{{ $alert->notification_channel }}</td>
                <td>
                    <button type="submit" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#sendAlertModal{{ $alert->id }}">Envoyer</button>

                    <div class="modal fade" id="sendAlertModal{{ $alert->id }}" tabindex="-1" aria-labelledby="sendAlertModalLabel{{ $alert->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="sendAlertModalLabel{{ $alert->id }}">Envoyer l'alerte</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Voulez-vous envoyer cette alerte ?
                                </div>
                                <div class="modal-footer">
                                    <p class="text-muted"><strong>Email destinataire :</strong> {{ $alert->user ? $alert->user->email : 'N/A' }}</p>
                                    <form action="{{ route('sendSelected') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="alerts[]" value="{{ $alert->id }}">
                                        <button type="submit" class="btn btn-success">Envoyer</button>
                                    </form>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#modalModification-{{ $alert->id }}" class="btn btn-sm btn-warning">Modifier</button>
                    <div class="modal fade" id="modalModification-{{ $alert->id }}" tabindex="-1" aria-labelledby="modalModificationLabel-{{ $alert->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalModificationLabel-{{ $alert->id }}">Modifier l'alerte</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('modifier_alert', $alert->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="message_modif_{{ $alert->id }}" class="form-label">Message de l'alerte</label>
                                            <textarea name="message" id="message_modif_{{ $alert->id }}" class="form-control">{{ old('message', $alert->message) }}</textarea>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="notification_channel_modif_{{ $alert->id }}" class="form-label">Email</label>
                                            <input type="text" name="notification_channel" id="notification_channel_modif_{{ $alert->id }}" value="{{ old('notification_channel', $alert->notification_channel) }}" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label for="user_id_modif_{{ $alert->id }}" class="form-label">Utilisateur concerné</label>
                                            <select name="user_id" id="user_id_modif_{{ $alert->id }}" class="form-select">
                                                @foreach($les_parents as $parent)
                                                    <option value="{{ $parent->id }}" {{ old('user_id', $alert->user_id) == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-success">Modifier</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('supprimer_alert', $alert->id) }}" method="post" onsubmit="return confirm('Supprimer ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i> Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        <!-- Modal d'ajout d'alerte -->
        <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('ajouter_alert') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="alertModalLabel">Ajouter une alerte</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="message" class="form-label">Message de l'alerte</label>
                                <textarea name="message" class="form-control" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="user_id" class="form-label">Utilisateur concerné (optionnel)</label>
                                <select name="user_id" class="form-select">
                                    <option value="">Sélectionner</option>
                                    @forelse($les_parents as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->name }} (ID: {{ $parent->id }})</option>
                                    @empty
                                    <option value="" disabled>Aucun parent disponible</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="alert_date" class="form-label">Date de l'alerte</label>
                                <input type="datetime-local" name="alert_date" class="form-control" required>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-success">Ajouter l'alerte</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection