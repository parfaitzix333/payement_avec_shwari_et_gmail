<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_id',
        'amount',
        'currency',
        'callbackUrl',
        'phone',
        'status',
        'eleve_id',
        'user_id',
        'frais_id',
    ];

    /**
     * =========================
     * Relations Eloquent
     * =========================
     */

    // Un paiement appartient à un élève
    public function eleve()
    {
        return $this->belongsTo(eleve::class);
    }

    // Un paiement appartient à un utilisateur (agent / admin)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un paiement concerne un frais scolaire
    public function frais()
    {
        return $this->belongsTo(frais::class);
    }
}
