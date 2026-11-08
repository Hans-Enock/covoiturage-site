<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public $timestamps = false;

    protected $fillable = ['nom', 'email', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return ['password' => 'hashed'];
    }

    public function trajets(): HasMany
    {
        return $this->hasMany(Trajet::class, 'id_conducteur');
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'id_passager');
    }

    public function avisRediges(): HasMany
    {
        return $this->hasMany(Avis::class, 'id_auteur');
    }

    public function avisRecus(): HasMany
    {
        return $this->hasMany(Avis::class, 'id_cible');
    }
}