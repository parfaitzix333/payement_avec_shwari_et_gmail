<?php

namespace App\Http\Controllers;

use App\Models\classe;
use App\Models\eleve;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EleveController extends Controller
{
    // 🟢 1. Créer un élève
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'dateN' => 'required|date',
            'lieuN' => 'required|string|max:255',
            'sexe' => 'required|in:M,F',
            'classe_id' => 'required|exists:classes,id',
            'user_id' => 'nullable|exists:users,id',
            'etat' => 'nullable|in:admis,non admis',
        ]);

        eleve::create($validated);

        return redirect()->back()->with('success', 'Élève ajouté avec succès !');
    }

    // 🟡 2. Mettre à jour un élève
    public function update(Request $request, $id)
    {
        $eleve = eleve::findOrFail($id);

        $eleveData=$request->validate([
            'nom' => 'nullable|string|max:255',
            'dateN' => 'nullable|string',
            'lieuN' => 'nullable|string',
            'sexe' => 'nullable|string',
            'classe_id' => 'nullable|numeric',
            'user_id' => 'nullable|exists:users,id',
            'etat' => 'nullable|string',
        ]);
        if(empty($eleveData['user_id'])){
            unset($eleveData['user_id']);
        }

        $eleve->update($eleveData);

        return redirect()->back()->with('success', 'Élève mis à jour avec succès !');
    }

    // 🔵 3. Afficher les infos d’un élève
    public function index()
    {
        // Récupération de l'utilisateur connecté
        $user = Auth::user();

        // Récupération des élèves avec eager loading pour optimisation
        $les_eleves = eleve::with('classe')->get();

        // Récupération des classes
        $classes = classe::all(); // Note: Classe avec majuscule suivant les conventions Laravel

        // Récupération de la session ou collection vide
        $les_eleves_session = session('les_eleves_', collect());

        $les_users = User::where('id', '!=', $user->id)
            ->whereNotIn('role', ['eleve', 'admin'])
            ->get();

        return view('affichage.les_eleves', [
            'les_eleves' => $les_eleves,
            'user' => $user,
            'classes' => $classes,
            'les_eleves_' => $les_eleves_session,
            'les_users' => $les_users
        ]);
    }
    //rechercher
    public function rechercher_eleve(Request $request, $id = null)
    {
        $user = Auth::user();

        // Si aucun ID n'est fourni, on prend le premier par défaut
        if (!$id && $request->has('id')) {
            $id = $request->input('id');
        }

        $query = eleve::with(['classe', 'user']);

        if ($id) {
            $classe = classe::findOrFail($id);
            $query->where('classe_id', $classe->id);
        } else {
            $classe = null;
        }

        $les_eleves_ = $query->get();
        $classes = classe::all();
        $les_eleves = session('les_eleves', collect());

        $les_users = User::whereDoesntHave('eleve')
            ->whereNotIn('role', ['eleve', 'admin'])
            ->get();

        return view('affichage.les_eleves', compact(
            'les_eleves_',
            'les_eleves',
            'user',
            'classes',
            'les_users',
            'classe'
        ));
    }

    // 🔴 4. Supprimer un élève
    public function destroy($id)
    {
        $eleve = eleve::findOrFail($id);
        $eleve->delete();

        return redirect()->back()->with('success', 'Élève supprimé avec succès !');
    }
}
