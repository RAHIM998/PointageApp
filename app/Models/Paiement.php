<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paiement extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable=[
        'user_id',
        'montant',
        'mois',
        'annee',
        'nbheure_travaille'
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
