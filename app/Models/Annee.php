<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annee extends Model

{

    use HasFactory;

    protected $fillable = [
        'annee',
        'prix_location',
    ];

    protected $cast = [
        'annee' => 'decimal',
    ];
}
