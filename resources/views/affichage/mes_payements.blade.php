@extends('base.base_parent')

@section('content')
@include('partials.alerts')
<style>
    #searche_group{
        width: 300px;
    }
</style>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0"><i class="fas fa-receipt me-2"></i> Gestion des Paiements</h2>
        </div>

        <div class="card-body">


            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i> Nouveau Paiement</h5>
                        </div>
                        <div class="card-body">
                            @csrf
                            <div class="row g-3">

                                <div class="col-md-4">
                                    <label for="frais_id" class="form-label"><b>FRAIS</b> <span class="text-danger">*</span></label>
                                    <hr>
                                    <div class="row">
                                        @forelse($frais ?? [] as $frais)
                                        <form action="{{route('form_payement', $frais->id )}}" method="get">
                                            <p class="col-md-12" value="{{ $frais->amount }}">
                                                {{ $frais->libelle }} ({{ number_format($frais->montant) }} FC)
                                                <button class="btn btn-success" type="submit"> Poursuivre le payement</button>
                                            </p>
                                        </form>

                                        @empty
                                        <p>Aucun frais disponible</p>
                                        @endforelse
                                        @error('frais_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i> Historique des Paiements</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="input-group text-primary" id="searche_group">
                                <input type="text" class="form-control" placeholder="Rechercher un paiement...">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <table class="table table-striped table-hover" id="paymentsTable">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID Transaction</th>
                                        <th>Élève</th>
                                        <th>frais</th>
                                        <th>Montant</th>
                                        <th>Statut</th>
                                        <th>Téléphone</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($les_payements as $payment)
                                    <tr>
                                        <td>{{ $payment->transaction_id }}</td>
                                        <td>{{ $payment->eleve->nom ?? 'N/A' }}</td>
                                        <td>{{ $payment->frais->libelle ?? 'N/A' }}</td>
                                        <td>{{ number_format($payment->amount, 2) }} {{ $payment->currency }}</td>
                                        <td>
                                            <span class="badge 
                                    @if($payment->status == 'completed') bg-success
                                    @elseif($payment->status == 'pending') bg-warning text-dark
                                    @elseif($payment->status == 'failed') bg-danger
                                    @else bg-secondary
                                    @endif">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                        <td>{{ ucfirst($payment->phone) }}</td>
                                        <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if($payment->payment_url && $payment->status == 'pending')
                                            <a href="{{ $payment->payment_url }}" class="btn btn-sm btn-primary" target="_blank">
                                                <i class="fas fa-external-link-alt"></i> Payer
                                            </a>
                                            @endif
                                            <div class="row" style="display: flex;">
                                                <div class="col">
                                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#paymentDetails{{ $payment->id }}">
                                                        <i class="fas fa-info-circle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal Détails -->
                                    <div class="modal fade" id="paymentDetails{{ $payment->id }}" tabindex="-1" aria-labelledby="paymentDetailsLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="paymentDetailsLabel">Détails du Paiement</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <strong>ID Transaction:</strong><br>
                                                            {{ $payment->transaction_id }}
                                                        </div>
                                                        <div class="col-md-6">
                                                            <strong>Date:</strong><br>
                                                            {{ $payment->created_at->format('d/m/Y H:i') }}
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <strong>Élève:</strong><br>
                                                            {{ $payment->eleve->nom ?? 'N/A' }}
                                                        </div>
                                                        <div class="col-md-6">
                                                            <strong>Frais:</strong><br>
                                                            {{ $payment->frais->libelle ?? 'N/A' }}
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <strong>amount:</strong><br>
                                                            {{ number_format($payment->amount, 2) }} {{ $payment->currency }}
                                                        </div>
                                                        <div class="col-md-6">
                                                            <strong>Statut:</strong><br>
                                                            <span class="badge 
                                                    @if($payment->status == 'completed') bg-success
                                                    @elseif($payment->status == 'pending') bg-warning text-dark
                                                    @elseif($payment->status == 'failed') bg-danger
                                                    @else bg-secondary
                                                    @endif">
                                                                {{ ucfirst($payment->status) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    @if($payment->error_message)
                                                    <div class="alert alert-danger">
                                                        <strong>Erreur:</strong><br>
                                                        {{ $payment->error_message }}
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Aucun paiement trouvé.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('scripts')
    <script>
        $(document).ready(function() {
            // Mise à jour automatique du amount lors du changement de frais
            $('select[name="frais_id"]').change(function() {
                const selectedOption = $(this).find('option:selected');
                const amount = selectedOption.data('amount');
                if (amount) {
                    $('input[name="amount"]').val(amount);
                }
            });

            // Confirmation avant suppression
            $('form[method="DELETE"]').submit(function(e) {
                if (!confirm('Êtes-vous sûr de vouloir supprimer ce paiement ?')) {
                    e.preventDefault();
                }
            });

            // Moteur de recherche pour le tableau des paiements
            const searchInput = document.querySelector('#searche_group input');
            const table = document.getElementById('paymentsTable');
            
            if (searchInput && table) {
                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    const rows = table.querySelectorAll('tbody tr');
                    
                    rows.forEach(row => {
                        const rowText = row.textContent.toLowerCase();
                        if (rowText.includes(searchTerm) || searchTerm === '') {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
    @endsection
