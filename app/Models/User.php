<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    public const PASSAGER = 'passager';
    public const CONDUCTEUR = 'conducteur';
    public const ADMIN = 'admin';

    protected $primaryKey = 'id_user';

    public $timestamps = false;

    protected $fillable = ['nom', 'email', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return ['password' => 'hashed'];
    }

    public static function inscrire(array $donnees): self
    {
        return DB::transaction(function () use ($donnees) {
            $user = self::create([
                'nom'      => $donnees['nom'],
                'email'    => $donnees['email'],
                'password' => $donnees['password'],
                'role'     => $donnees['role'],
            ]);

            if ($user->estConducteur()) {
                $user->vehicule()->create($donnees['vehicule']);
            }

            return $user;
        });
    }

    public function estPassager(): bool
    {
        return $this->role === self::PASSAGER;
    }

    public function estConducteur(): bool
    {
        return $this->role === self::CONDUCTEUR;
    }

    public function estAdmin(): bool
    {
        return $this->role === self::ADMIN;
    }

    public function vehicule(): HasOne
    {
        return $this->hasOne(Vehicule::class, 'id_user');
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