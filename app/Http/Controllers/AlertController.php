<?php

namespace App\Http\Controllers;

use App\Models\alert;
use App\Models\User;
use App\Notifications\AlertEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AlertController extends Controller
{
    //les alerts
    public function les_alerts()
    {
        $user=Auth::user();
        $alerts = alert::orderBy('alert_date', 'desc')->get();
        $les_parents = User::where('role', 'parent')->get();
        return view('affichage.les_alerts', compact('alerts', 'les_parents', 'user'));
    }

    public function ajouter_alert(Request $request)
    {
        // Validation des données reçues
        $alertData = $request->validate([
            'message' => 'required|string',
            'user_id' => 'required|integer',
            'alert_date' => 'nullable|date',
            'notification_channel' => 'nullable|string',
        ]);
        $utilisateur = $request->input('user_id');
        $parent = User::find($utilisateur);
        // Stocker l'adresse email du parent dans notification_channel
        if ($parent && $parent->email) {
            $alertData['notification_channel'] = $parent->email;
        }
        alert::create($alertData);

        return redirect()->back()->with('success', 'Alerte créée avec succès !');
    }

    //suppression alertes
    public function supprimer_alert($id)
    {
        $alert = alert::findOrFail($id);
        $alert->delete();
        return redirect()->back()->with('success', 'Alerte supprimée avec succès !');
    }

    //modifier alertes
    public function modifier_alert(Request $request, $id)
    {
        $alert = alert::findOrFail($id);

        $alertData = $request->validate([
            'message' => 'required|string',
            'user_id' => 'required|integer',
            'alert_date' => 'nullable|date',
            'notification_channel' => 'nullable|string',
        ]);

        $utilisateur = $request->input('user_id');
        $parent = User::find($utilisateur);
        if ($parent && $parent->email) {
            $alertData['notification_channel'] = $parent->email;
        }

        $alert->update($alertData);

        return redirect()->back()->with('success', 'Alerte modifiée avec succès !');
    }

    //envoyer_alertes personalisé
    public function sendSelected(Request $request)
    {
        $request->validate([
            'alerts' => 'required|array',
        ]);

        $alerts = Alert::with('user')
            ->whereIn('id', $request->alerts)
            ->get();

        foreach ($alerts as $alert) {
            try {
                // 📧 EMAIL - Envoyer à l'adresse dans notification_channel
                if ($alert->notification_channel && filter_var($alert->notification_channel, FILTER_VALIDATE_EMAIL)) {
                    Mail::raw($alert->message, function ($m) use ($alert) {
                        $m->to($alert->notification_channel)
                            ->subject('Alerte - ' . $alert->alert_date);
                    });
                }

                $alert->update([
                    'notification_status' => 'sent',
                    'notification_sent_at' => now(),
                    'is_read' => true,
                    'notification_error' => null,
                ]);
            } catch (\Exception $e) {
                $alert->update([
                    'notification_status' => 'failed',
                    'notification_error' => $e->getMessage(),
                ]);
            }
        }

        return back()->with('success', 'Alertes envoyées avec succès.');
    }

    // 📢 Diffusion en broadcast à tous les parents
    public function diffuser(Request $request)
    {
        $request->validate([
            'alerts' => 'required|string|min:5',
        ]);

        $message = $request->input('alerts');

        // Récupérer tous les parents
        $parents = User::where('role', 'parent')->get();

        if ($parents->isEmpty()) {
            return redirect()->back()->with('error', 'Aucun parent disponible pour la diffusion.');
        }

        $sentCount = 0;
        $failedCount = 0;

        foreach ($parents as $parent) {
            try {
                if ($parent->email && filter_var($parent->email, FILTER_VALIDATE_EMAIL)) {
                    Mail::raw($message, function ($m) use ($parent) {
                        $m->to($parent->email)
                            ->subject('Diffusion d\'alerte - ' . date('d/m/Y H:i'));
                    });
                    $sentCount++;
                }
            } catch (\Exception $e) {
                $failedCount++;
                Log::error('Erreur lors de l\'envoi à ' . $parent->email . ': ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', "Message diffusé à $sentCount parent(s). Erreurs: $failedCount.");
    }
}
