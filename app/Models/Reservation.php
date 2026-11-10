<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    public const EN_ATTENTE = 'En attente';
    public const CONFIRMEE = 'Confirmée';
    public const REFUSEE = 'Refusée';
    public const ANNULEE = 'Annulée';

    protected $primaryKey = 'id_reservation';

    public $timestamps = false;

    protected $fillable = ['id_trajet', 'id_passager', 'prix', 'statut'];

    protected function casts(): array
    {
        return ['date_reservation' => 'datetime'];
    }

    public function trajet(): BelongsTo
    {
        return $this->belongsTo(Trajet::class, 'id_trajet');
    }

    public function passager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_passager');
    }
}