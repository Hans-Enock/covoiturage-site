<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Avis extends Model
{
    protected $table = 'avis';

    public $timestamps = false;

    protected $fillable = ['note', 'commentaire', 'date', 'id_trajet', 'id_auteur', 'id_cible'];

    protected function casts(): array
    {
        return ['date' => 'datetime'];
    }

    public function trajet(): BelongsTo
    {
        return $this->belongsTo(Trajet::class, 'id_trajet');
    }

    public function auteur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_auteur');
    }

    public function cible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_cible');
    }
}
