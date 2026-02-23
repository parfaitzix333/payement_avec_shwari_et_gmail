<style>
    .notification-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        width: 350px;
    }

    .notification {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        display: flex;
        align-items: center;
        opacity: 0;
        transform: translateX(100%);
        transition: all 0.4s ease;
        border-left: 4px solid;
        position: relative;
        overflow: hidden;
    }

    .notification.show {
        opacity: 1;
        transform: translateX(0);
    }

    .notification.hide {
        opacity: 0;
        transform: translateX(100%);
    }

    .notification.success {
        background-color: #f6ffed;
        border-color: #52c41a;
        color: #135200;
    }

    .notification.error {
        background-color: #fff2f0;
        border-color: #ff4d4f;
        color: #5c0011;
    }

    .notification i {
        margin-right: 12px;
        font-size: 22px;
    }

    .notification-content {
        flex: 1;
    }

    .notification-title {
        font-weight: 600;
        margin-bottom: 5px;
    }

    .notification-close {
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        font-size: 18px;
        opacity: 0.7;
        transition: opacity 0.2s;
        margin-left: 15px;
    }

    .notification-close:hover {
        opacity: 1;
    }

    /* Correct z-index for modal and backdrop */
    .modal {
        z-index: 1080 !important;
        /* Higher than backdrop */
    }

    .modal-backdrop {
        z-index: 1070 !important;
        /* Just below modal */
    }
</style>
<div class="notification-container">
    @if (session('success'))
    <div class="notification success">
        <i class="fas fa-check-circle"></i>
        <div class="notification-content">
            <div class="notification-title">Succès</div>
            <div>{{ session('success') }}</div>
        </div>
        <button class="notification-close" onclick="closeNotification(this)">&times;</button>
    </div>
    @endif
    @if ($errors->any())
    <div class="notification error">
        <i class="fas fa-exclamation-circle"></i>
        <div class="notification-content">
            <div class="notification-title">Erreur</div>
            <div>{{ $errors->first() }}</div>
        </div>
        <button class="notification-close" onclick="closeNotification(this)">&times;</button>
    </div>
    @endif
</div>

<script>
    // Gestion des notifications
    document.addEventListener('DOMContentLoaded', function() {
        // Afficher les notifications avec animation
        const notifications = document.querySelectorAll('.notification');
        notifications.forEach((notification, index) => {
            setTimeout(() => {
                notification.classList.add('show');

                // Masquer automatiquement après 5 secondes
                setTimeout(() => {
                    closeNotification(notification.querySelector('.notification-close'));
                }, 5000);
            }, 100 * index);
        });
    });

    function closeNotification(btn) {
        const notification = btn.closest('.notification');
        notification.classList.remove('show');
        notification.classList.add('hide');

        // Supprimer après l'animation
        setTimeout(() => {
            notification.remove();
        }, 400);
    }
</script>



<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 text-light">
            <i class="fas fa-user-circle me-2"></i>Profil ADMINISTRATEUR
        </h2>
        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modifierProfile-{{ $user->id }}">
            <i class="fas fa-edit me-2"></i> Modifier Profil
        </button>
    </div>

    <!-- Card d'informations utilisateur -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center mb-3 mb-md-0">
                    <div class="position-relative">
                        <img src="{{ Storage::url($user->photo) }}"
                            class="rounded-circle img-thumbnail"
                            width="150"
                            height="150"
                            alt="Photo de profil">
                    </div>
                </div>
                <div class="col-md-8">
                    <h4 class="mb-3">{{ $user->name }}</h4>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <p class="text-muted mb-1"><i class="fas fa-envelope me-2"></i> Email</p>
                            <p>{{ $user->email }}</p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <p class="text-muted mb-1"><i class="fas fa-phone me-2"></i> Téléphone</p>
                            <p>{{ $user->tel ?? 'Non renseigné' }}</p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <p class="text-muted mb-1"><i class="fas fa-birthday-cake me-2"></i> Date de naissance</p>
                            <p>{{ $user->dateN }}</p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <p class="text-muted mb-1"><i class="fas fa-map-marker-alt me-2"></i> Adresse</p>
                            <p>{{ $user->adresse ?? 'Non renseignée' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de modification -->


<div class="modal fade" id="modifierProfile-{{ $user->id }}" tabindex="-1" aria-labelledby="modifierProfileLabel-{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg text-dark">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Modifier Profil</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <form action="{{ route('modifier_utilisateur', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nom complet</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Nouveau mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="text-muted">Laissez vide pour ne pas changer</small>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="dateN" class="form-label">Date de naissance</label>
                            <input type="date" class="form-control" id="dateN" name="dateN"
                                value="{{$user->dateN }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lieuN" class="form-label">Lieu de naissance</label>
                            <input type="text" class="form-control" id="lieuN" name="lieuN"
                                value="{{ old('lieuN', $user->lieuN) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tel" class="form-label">Téléphone</label>
                            <input type="tel" class="form-control" id="tel" name="tel"
                                value="{{ old('tel', $user->tel) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="photo" class="form-label">Photo de profil</label>
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <textarea class="form-control" id="adresse" name="adresse" rows="2">{{ old('adresse', $user->adresse) }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Annuler
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .profile-card {
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .profile-card:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .img-thumbnail {
        border: 3px solid #dee2e6;
        transition: all 0.3s ease;
    }

    .img-thumbnail:hover {
        transform: scale(1.05);
        border-color: #0d6efd;
    }

    /* Correction définitive du problème de superposition */
    .modal {
        z-index: 1080 !important;
    }

    .modal-backdrop {
        z-index: 1070 !important;
        background-color: rgba(0, 0, 0, 0.5) !important;
    }
</style>

<script>
    // Solution de secours au cas où
    document.addEventListener('DOMContentLoaded', function() {
        var myModal = document.getElementById('modifierProfile-{{ $user->id }}');

        myModal.addEventListener('show.bs.modal', function() {
            document.querySelector('.modal-backdrop').style.zIndex = '1070';
            this.style.zIndex = '1080';
        });
    });
</script>