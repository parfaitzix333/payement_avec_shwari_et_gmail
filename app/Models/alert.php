<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class alert extends Model
{
    use HasFactory;
    protected $fillable = [
        'message',
        'is_read',
        'user_id',
        'alert_date',
        'notification_channel',
        'notification_status',
        'notification_error',
        'notification_sent_at',
    ];

    /**
     * Casts automatiques
     */
    protected $casts = [
        'is_read' => 'boolean',
        'alert_date' => 'datetime',
        'notification_sent_at' => 'datetime',
    ];

    /**
     * =========================
     * Relations Eloquent
     * =========================
     */

    // L’alerte appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
