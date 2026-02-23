@extends('base.base_admin')
@section('content')
<style>
    .table-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-top: 20px;
    }

    .search-box {
        margin-bottom: 20px;
        max-width: 300px;
    }

    .table th {
        background-color: #0a0342;
        color: white;
        cursor: pointer;
        position: relative;
    }

    .table th:hover {
        background-color: #1a0a6e;
    }

    .table th::after {
        content: "↕";
        position: absolute;
        right: 10px;
        opacity: 0.5;
    }

    .action-buttons {
        display: flex;
        gap: 5px;
    }

    .no-data {
        text-align: center;
        padding: 20px;
        color: #6c757d;
    }
</style>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0 text-light">LES UTILISATEUS</h3>
</div>
<div class="table-container">

    <div class="search-box">
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" id="searchInput" class="form-control" placeholder="Rechercher un utilisateur..." onkeyup="filterTable()">
        </div>
    </div>
    @include('partials.alerts')

    <div class="table-responsive">
        <table class="table table-hover align-middle" id="userTable">
            <thead>
                <tr>
                    <th onclick="sortTable(0)">ID</th>
                    <th onclick="sortTable(1)">NOM</th>
                    <th onclick="sortTable(2)">EMAIL</th>
                    <th onclick="sortTable(3)">ROLE</th>
                    <th onclick="sortTable(4)">DATE NAISS</th>
                    <th onclick="sortTable(5)">LIEU NAISS</th>
                    <th onclick="sortTable(6)">TEL</th>
                    <th>PHOTO</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($les_users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge 
                            @if($user->role == 'admin') bg-danger
                            @elseif($user->role == 'laboratoir') bg-warning text-dark
                            @elseif($user->role == 'reception') bg-primary
                            @else bg-secondary @endif">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>{{ date('d-M-Y', strtotime($user->dateN))}}</td>
                    <td>{{ $user->lieuN }}</td>
                    <td>{{ $user->tel }}</td>
                    <td>
                        <a href="{{ Storage::url($user->photo)}}">
                            <img src="{{ Storage::url($user->photo)}}" width="60px" alt="Photo">
                        </a>
                    </td>
                    <td class="action-buttons">
                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $user->id }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form action="#" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="no-data">Aucun utilisateur trouvé</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modals de modification -->
@foreach ($les_users as $user)
<div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel-{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Modifier l'utilisateur #{{ $user->id }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('modifier_utilisateur', $user->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom complet</label>
                        <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label bg-dark text-light">Mot de passe (laisser vide pour ne pas modifier)</label>
                        <input type="password" class="form-control bg-warning" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="dateN" class="form-label">Date de naissance</label>
                        <input type="date" class="form-control" name="dateN" value="{{ $user->dateN }}">
                    </div>
                    <div class="mb-3">
                        <label for="lieuN" class="form-label">Lieu de naissance</label>
                        <input type="text" class="form-control" name="lieuN" value="{{ $user->lieuN }}">
                    </div>
                    <div class="mb-3">
                        <label for="tel" class="form-label">Téléphone</label>
                        <input type="text" class="form-control" name="tel" value="{{ $user->tel }}">
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Type d'utilisateur</label>
                        <select class="form-select" name="role" required>
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Utilisateur standard</option>
                            <option value="parent" {{ $user->role == 'parent' ? 'selected' : '' }}>Parent</option>
                            <option value="suspendu" {{ $user->role == 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrateur</option>
                        </select>
                    </div>
                    <div>
                        <label for="photo">Photo de profile</label>
                        <input type="file" class="form-control" name="photo">
                    </div>
                    <img src="{{ Storage::url($user->photo)}}" class="mt-3" alt="Photo" width="50px" height="50px" style="border: 3px solid rgb(4, 134, 11); border-radius: 50px">
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

<script>
    function filterTable() {
        const input = document.getElementById("searchInput").value.toLowerCase();
        const table = document.getElementById("userTable");
        const rows = table.getElementsByTagName("tr");

        for (let i = 1; i < rows.length; i++) {
            const nameCell = rows[i].getElementsByTagName("td")[1];
            const emailCell = rows[i].getElementsByTagName("td")[2];
            let shouldShow = false;

            if (nameCell && emailCell) {
                const nameText = nameCell.textContent || nameCell.innerText;
                const emailText = emailCell.textContent || emailCell.innerText;
                shouldShow = nameText.toLowerCase().includes(input) || emailText.toLowerCase().includes(input);
            }

            rows[i].style.display = shouldShow ? "" : "none";
        }
    }

    function sortTable(columnIndex) {
        const table = document.getElementById("userTable");
        const tbody = table.querySelector("tbody");
        const rows = Array.from(tbody.getElementsByTagName("tr"));
        let isAscending = table.getAttribute("data-sort-dir") !== "asc";

        rows.sort((rowA, rowB) => {
            const cellA = rowA.cells[columnIndex].textContent.trim();
            const cellB = rowB.cells[columnIndex].textContent.trim();

            // Pour les colonnes numériques (ID)
            if (columnIndex === 0) {
                return isAscending ? cellA - cellB : cellB - cellA;
            }

            // Pour les autres colonnes (texte)
            return isAscending ?
                cellA.localeCompare(cellB) :
                cellB.localeCompare(cellA);
        });

        // Réinsérer les lignes triées
        rows.forEach(row => tbody.appendChild(row));

        // Mettre à jour l'indicateur de direction de tri
        table.setAttribute("data-sort-dir", isAscending ? "asc" : "desc");
    }
</script>
@endsection