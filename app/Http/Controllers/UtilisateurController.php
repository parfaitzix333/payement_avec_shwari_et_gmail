<?php

namespace App\Http\Controllers;

use App\Models\eleve;
use App\Models\payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UtilisateurController extends Controller
{
    //les users
    public function les_users()
    {
        $user = Auth::user();
        $les_users = User::all();
        return view('affichage.les_users', compact('user', 'les_users'));
    }
    //edit_profile_admin
    public function edit_profile_admin()
    {
        $user = Auth::user();
        return view('profile.edit_profile_admin', compact('user'));
    }

    //edit_profile_parent
    public function edit_profile_parent()
    {
        $user = Auth::user();
        return view('profile.edit_profile_parent', compact('user'));
    }

    //profile_parent
    public function profile_parent()
    {
        $user = Auth::user();
        $mes_enfants = eleve::where('user_id', $user->id)->get();
        $ids = $mes_enfants->pluck('id')->toArray();
        $payement = payment::whereIn('eleve_id', $ids)->get();
        return view('mes_profiles.profile_parent', compact('user', 'mes_enfants', 'payement'));
    }

    public function modifier_utilisateur(Request $request, $id)
    {
        $utilisateur = User::findOrFail($id);

        $userData = $request->validate([
            'name' => "required|string",
            'email' => "required|string",
            'password' => "nullable|string",
            'dateN' => "nullable|string",
            'lieuN' => "nullable|string",
            'adresse' => "nullable|string",
            'tel' => "nullable|string",
            'photo' => "nullable|file",
            'role' => "nullable|string"
        ]);

        // Gestion de la photo
        if ($request->hasFile('photo')) {
            if ($utilisateur->photo) {
                Storage::disk('public')->delete($utilisateur->photo);
            }
            $userData['photo'] = $request->file('photo')->store('Users/photo', 'public');
        }
        if(empty($userData['password'])) {
            unset($userData['password']);
        }

        // Mise à jour des données de l'utilisateur
        $utilisateur->update($userData);

        return redirect()->back()->with('success', "Profil mis à jour avec succès !");
    }
}
