<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotisation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'montant',
        'date',
        'recu_paiement',
        'status',
        'statuValidation',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
