<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $table = 'reservations';

    public $timestamps = false;

    protected $fillable = ['statut', 'date_reservation', 'id_trajet', 'id_passager'];

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
