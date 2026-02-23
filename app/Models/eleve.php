<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class eleve extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'dateN',
        'lieuN',
        'sexe',
        'classe_id',
        'user_id',
        'etat',
    ];

    /**
     * =========================
     * Relations Eloquent
     * =========================
     */

    // Responsable légal (parent / tuteur)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Classe de l’élève
    public function classe()
    {
        return $this->belongsTo(classe::class);
    }

    // Paiements effectués par l’élève
    public function payments()
    {
        return $this->hasMany(payment::class);
    }
}
