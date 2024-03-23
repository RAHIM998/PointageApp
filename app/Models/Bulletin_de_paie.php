<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bulletin_de_paie extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id', 'mois_annee', 'total_ht', 'cout_total',
    ];

    public function employee():BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
