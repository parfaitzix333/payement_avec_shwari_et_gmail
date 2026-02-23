<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe;
use Illuminate\Support\Facades\Auth;

class ClasseController extends Controller
{
    // 🟢 Store (création)
    public function store(Request $request)
    {
        $request->validate([
            'niveau' => 'required|string|max:255',
        ]);

        Classe::create($request->all());

        return redirect()->back()->with('success', 'Classe ajoutée avec succès !');
    }

    // 🟡 Update (modification)
    public function update(Request $request, $id)
    {
        $classe = Classe::findOrFail($id);

        $request->validate([
            'niveau' => 'required|string|max:255',
        ]);

        $classe->update($request->all());

        return redirect()->back()->with('success', 'Classe mise à jour avec succès !');
    }


    // 🔴 Destroy (suppression)
    public function destroy($id)
    {
        $classe = Classe::findOrFail($id);
        $classe->delete();

        return redirect()->back()->with('success', 'Classe supprimée avec succès !');
    }
    // 🟣 Index (liste des classes)
    public function index()
    {
        $user = Auth::user();
        $classes = Classe::all();
        return view('affichage.les_classes', compact('classes', 'user'));
    }
}
