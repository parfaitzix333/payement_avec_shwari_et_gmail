<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classe extends Model
{
    use HasFactory;
    protected $fillable = [
        'niveau',
    ];

    /**
     * =========================
     * Relations Eloquent
     * =========================
     */

    // Élèves de la classe
    public function eleves()
    {
        return $this->hasMany(eleve::class);
    }
}
