<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Shwary\ShwaryClient;

class ShwaryWebhookController extends Controller
{
    public function __construct(
        private ShwaryClient $shwary
    ) {}

    public function handle(Request $request)
    {
        $transaction = $this->shwary->parseWebhook(
            $request->getContent()
        );

        $payment = Payment::where(
            'transaction_id',
            $transaction->id
        )->first();

        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        if ($transaction->isCompleted()) {
            $payment->update(['status' => 'SUCCESS']);
        }

        if ($transaction->isFailed()) {
            $payment->update([
                'status' => 'FAILED',
            ]);
        }

        return response()->json(['success' => true]);
    }
}
