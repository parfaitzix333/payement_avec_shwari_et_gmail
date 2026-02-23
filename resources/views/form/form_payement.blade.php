@extends('base.base_parent')

@section('content')

{{-- ===================== STYLES ===================== --}}
<style>
    .form-wrapper {
        max-width: 520px;
        margin: auto;
    }

    .notification-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1050;
        width: 340px;
    }

    .notification {
        display: flex;
        gap: 12px;
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 12px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, .15);
        opacity: 0;
        transform: translateX(120%);
        transition: all .4s ease;
        border-left: 5px solid;
    }

    .notification.show {
        opacity: 1;
        transform: translateX(0);
    }

    .notification.success {
        background: #f6ffed;
        border-color: #52c41a;
        color: #135200;
    }

    .notification.error {
        background: #fff2f0;
        border-color: #ff4d4f;
        color: #5c0011;
    }

    .notification-close {
        background: none;
        border: none;
        font-size: 18px;
        cursor: pointer;
        opacity: .7;
    }

    .notification-close:hover {
        opacity: 1;
    }

    @media(max-width: 768px) {
        .form-wrapper {
            max-width: 95%;
        }
    }
    #amount, #frais_a_payer{
        font-size: 25px;
    }
</style>

{{-- ===================== NOTIFICATIONS ===================== --}}
<div class="notification-container">
    @if (session('success'))
    <div class="notification success">
        <i class="fas fa-check-circle fa-lg"></i>
        <div class="flex-grow-1">
            <strong>Succès</strong><br>
            {{ session('success') }}
        </div>
        <button class="notification-close">&times;</button>
    </div>
    @endif

    @if ($errors->any())
    <div class="notification error">
        <i class="fas fa-exclamation-circle fa-lg"></i>
        <div class="flex-grow-1">
            <strong>Erreur</strong><br>
            {{ $errors->first() }}
        </div>
        <button class="notification-close">&times;</button>
    </div>
    @endif
</div>

{{-- ===================== FORMULAIRE ===================== --}}
<h2 class="text-center mb-4">Nouvelle transaction</h2>

<div class="form-wrapper">
    <form method="POST" action="{{ route('payer.shwary') }}">
        @csrf

        {{-- Champs cachés --}}
        <input type="hidden" name="frais_id" value="{{ $frais->id }}">
        <input type="hidden" name="country" value="DRC">
        <input type="hidden" name="status" value="attente">

        <div class="mb-3">
            <label class="form-label">Frais à payer :</label>
            <span class="badge bg-success w-100 py-2" id="frais_a_payer">
                {{ $frais->libelle }}
            </span>
        </div>

        <div class="mb-3 input-group">
            <label for="amount" class="input-group-text text-primary"><b>Montant</b></label>
            <input type="number" id="amount" class="form-control"
                value="{{ $frais->montant }}" readonly>
                <span class="input-group-text text-primary">CDF</span>
        </div>

        <div class="mb-3" hidden>
            <label class="form-label">Devise</label>
            <input type="text" class="form-control" value="CDF">
            <input type="text" value="+243" name="country_code" id="country_code" readonly>
        </div>
        

        <div class="mb-3">
            <label class="form-label text-primary"><b>Téléphone</b></label>
            <div class="input-group">
                <span class="input-group-text">+243</span>
                <input type="tel"
                    name="phone"
                    class="form-control"
                    placeholder="972345678"
                    pattern="[0-9]{9}"
                    required maxlength="9">
            </div>
        </div>

        <div class="mb-4">
            <label for="eleve_id" class="form-label text-primary"><b>Élèves</b></label>
            <select name="eleve_id" id="eleve_id" class="form-select" required>
                <option value="">Selectionnez un élève</option>
                @forelse ($eleves as $eleve)
                <option value="{{ $eleve->id }}">
                    {{ $eleve->nom }} [ {{ $eleve->id }} ]
                </option>
                @empty
                <option disabled>Aucun élève disponible</option>
                @endforelse
            </select>
        </div>

        <button type="submit" class="btn btn-info w-100">
            <i class="fas fa-paper-plane"></i> Envoyer le paiement
        </button>
    </form>
</div>

{{-- ===================== SCRIPTS ===================== --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.notification').forEach((notif) => {
            notif.classList.add('show');

            const closeBtn = notif.querySelector('.notification-close');
            closeBtn.addEventListener('click', () => hide(notif));

            setTimeout(() => hide(notif), 5000);
        });

        function hide(el) {
            el.classList.remove('show');
            setTimeout(() => el.remove(), 400);
        }
    });
</script>

@endsection