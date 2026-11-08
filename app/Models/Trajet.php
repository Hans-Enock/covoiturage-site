<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trajet extends Model
{
    protected $table = 'trajets';

    public $timestamps = false;

    protected $fillable = [
        'origine',
        'destination',
        'date_heure',
        'places_totales',
        'places_restantes',
        'prix',
        'statut',
        'id_conducteur',
    ];

    protected function casts(): array
    {
        return ['date_heure' => 'datetime'];
    }

    public function conducteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_conducteur');
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'id_trajet');
    }

    public function avis(): HasMany
    {
        return $this->hasMany(Avis::class, 'id_trajet');
    }
}
