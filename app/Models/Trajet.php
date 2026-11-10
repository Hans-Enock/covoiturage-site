<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trajet extends Model
{
    public const OUVERT = 'Ouvert';
    public const TERMINE = 'Terminé';
    public const ANNULE = 'Annulé';

    protected $primaryKey = 'id_trajet';

    public $timestamps = false;

    protected $fillable = [
        'id_conducteur', 'id_vehicule', 'origine', 'destination', 'date_heure',
        'places_totales', 'prix', 'paiement_especes', 'paiement_momo', 'statut',
    ];

    protected function casts(): array
    {
        return [
            'date_heure'       => 'datetime',
            'paiement_especes' => 'boolean',
            'paiement_momo'    => 'boolean',
        ];
    }

    public function conducteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_conducteur');
    }

    public function vehicule(): BelongsTo
    {
        return $this->belongsTo(Vehicule::class, 'id_vehicule');
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'id_trajet');
    }

    public function avis(): HasMany
    {
        return $this->hasMany(Avis::class, 'id_trajet');
    }

    public function scopeAvecPlacesPrises(Builder $query): Builder
    {
        return $query->withCount([
            'reservations as places_prises' => fn (Builder $q) => $q->where('statut', Reservation::CONFIRMEE),
        ]);
    }

    public function scopeReservable(Builder $query): Builder
    {
        return $query
            ->where('statut', self::OUVERT)
            ->where('date_heure', '>', now())
            ->whereRaw(
                'places_totales > (select count(*) from reservations'
                . ' where reservations.id_trajet = trajets.id_trajet and reservations.statut = ?)',
                [Reservation::CONFIRMEE]
            );
    }

    public function placesPrises(): int
    {
        if (array_key_exists('places_prises', $this->attributes)) {
            return (int) $this->attributes['places_prises'];
        }

        return $this->reservations()->where('statut', Reservation::CONFIRMEE)->count();
    }

    public function placesRestantes(): int
    {
        return $this->places_totales - $this->placesPrises();
    }

    public function estComplet(): bool
    {
        return $this->placesRestantes() <= 0;
    }
}