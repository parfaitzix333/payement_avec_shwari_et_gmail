<?php

namespace App\Http\Controllers;

use App\Models\eleve;
use App\Models\frais;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\payment as ModelsPayment;
use Illuminate\Support\Facades\Auth;
use Shwary\ShwaryClient;
use Shwary\Shwary;
use Shwary\Enums\Country;
use Shwary\Exceptions\ShwaryException;

class PaymentController extends Controller
{
    public function __construct(
        private ShwaryClient $shwary
    ) {}

    //form_payement
    public function form_payement($id)
    {
        $user = Auth::user();
        $eleves = eleve::where('user_id', $user->id)->get();
        $frais = frais::findOrFail($id);
        return view('form.form_payement', compact('user', 'eleves', 'frais'));
    }

    public function pay(Request $request)
    {
        $data = $request->validate([
            'amount' => 'required|integer|min:2901',
            'phone' => 'required|string',
            'country_code' => 'nullable|string',
        ]);
        Shwary::initFromArray([
            'merchant_id' => config('services.shwary.merchant_id'),
            'merchant_key' => config('services.shwary.merchant_key'),
            'sandbox' => config('services.shwary.sandbox'),
        ]);

        try {
            $transaction = $this->shwary->payDRC(
                amount: $data['amount'],
                phone: $data['country_code'] . $data['phone'],
                callbackUrl: config('services.shwary.callback_url'),
            );


            // Enregistrer en base
            $payment = Payment::create([
                'transaction_id' => $transaction->id,
                'amount' => $transaction->amount,
                'currency' => $transaction->currency,
                'country' => 'CD',
                'callbackUrl' => config('services.shwary.callback_url'),
                'status' => $transaction->status->value,
                'phone' => $request->input('country_code') . $request->input('phone'),
                'eleve_id' => $request->input('eleve_id'),
                'user_id' => Auth::id(),
                'frais_id' => $request->input('frais_id'),
            ]);

            return response()->json([
                'success' => true,
                'payment' => $payment,
            ]);
        } catch (ShwaryException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 422);
        }
    }

    //affichage chez le parent
    public function mes_payements()
    {
        $user = Auth::user();
        $eleves = eleve::where('user_id', $user->id)->get();
        $ids = $eleves->pluck('id')->toArray();

        // Vérifier si l'élève existe
        if (!$eleves) {
            return redirect()->back()->with('error', 'Aucun élève associé à votre compte.');
        }

        $les_payements = payment::whereIn('eleve_id', $ids)->get();
        $frais = frais::all();
        return view('affichage.mes_payements', compact('les_payements', 'eleves', 'user', 'frais'));
    }

    //les_payements (admin)
    public function les_payements()
    {
        $user=Auth::user();
        $les_payements = payment::all();
        $eleves = eleve::all();
        $les_frais = frais::all();
        return view('affichage.les_payements', compact('les_payements', 'eleves', 'les_frais','user'));
    }

    //supprimer un paiement
    public function supprimer_payement($id)
    {
        $payment = payment::findOrFail($id);
        $payment->delete();
        return redirect()->back()->with('success', 'Paiement supprimé avec succès.');
    }
}
