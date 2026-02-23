<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            // Le message de la notification (contenu envoyé)
            $table->text('message');

            // Marqueur de lecture côté application (pas WhatsApp)
            $table->boolean('is_read')->default(false)->nullable();

            // Référence à l'utilisateur destinataire
            $table->foreignId('user_id')
                ->constrained()           // équivaut à ->references('id')->on('users')
                ->cascadeOnDelete()
                ->index();

            // Date/heure prévue d'envoi ou d'alerte
            $table->dateTime('alert_date')->nullable();

            // Canal utilisé : ex. 'email', 'whatsapp', 'sms'
            $table->string('notification_channel', 50)->index();

            // Statut d’envoi : pending | sent | failed
            $table->enum('notification_status', ['pending', 'sent', 'failed'])
                ->default('pending')
                ->index();

            // Erreur renvoyée par le fournisseur s'il y en a
            $table->text('notification_error')->nullable();

            // Date/heure réelle d’envoi
            $table->dateTime('notification_sent_at')->nullable()->index();

            $table->timestamps();

            // Index composite utile pour les tâches planifiées
            $table->index(['notification_status', 'alert_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};
