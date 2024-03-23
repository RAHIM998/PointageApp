<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id', 'horraires', 'qrcode', 'cjm',
    ];
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pointage() : HasMany
    {
        return $this->hasMany(Pointage::class);
    }

    public function bulletin() : HasMany
    {
        return $this->hasMany(Bulletin_de_paie::class);
    }
}
