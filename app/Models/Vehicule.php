<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicule extends Model
{
    public const VOITURE = 'voiture';
    public const MOTO = 'moto';

    protected $primaryKey = 'id_vehicule';

    public $timestamps = false;

    protected $fillable = ['id_user', 'type', 'marque', 'modele', 'couleur', 'plaque', 'nb_places'];

    public static function normaliserPlaque(string $plaque): string
    {
        return strtoupper(preg_replace('/[\s\-]+/', '', $plaque));
    }

    protected function plaque(): Attribute
    {
        return Attribute::set(fn (string $valeur) => self::normaliserPlaque($valeur));
    }

    public function proprietaire(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function trajets(): HasMany
    {
        return $this->hasMany(Trajet::class, 'id_vehicule');
    }
}