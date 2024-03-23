<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pointage extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'date',
        'heure_entree',
        'heure_sortie',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
