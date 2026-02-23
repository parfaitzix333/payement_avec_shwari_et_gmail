<?php

namespace App\Http\Controllers;

use App\Models\frais;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FraisController extends Controller
{
    // 🟢 Store (ajout)
    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
            'montant' => 'required|integer|min:0',
        ]);

        frais::create($request->all());

        return redirect()->back()->with('success', 'Frais ajouté avec succès !');
    }

    // 🟡 Update (modification)
    public function update(Request $request, $id)
    {
        $frais = frais::findOrFail($id);

        $request->validate([
            'libelle' => 'required|string|max:255',
            'montant' => 'required|integer|min:0',
        ]);

        $frais->update($request->all());

        return redirect()->back()->with('success', 'Frais mis à jour avec succès !');
    }

    // 🔵 Show (affichage)
    public function show($id)
    {
        $frais = frais::findOrFail($id);
        return view('frais.show', compact('frais'));
    }

    // 🔴 Destroy (suppression)
    public function destroy($id)
    {
        $frais = frais::findOrFail($id);
        $frais->delete();

        return redirect()->back()->with('success', 'Frais supprimé avec succès !');
    }

    // 🟣 Index (liste des frais)
    public function index()
    {
        $user = Auth::user();
        $les_frais = frais::all();
        return view('affichage.les_frais', compact('les_frais', 'user'));
    }
}
