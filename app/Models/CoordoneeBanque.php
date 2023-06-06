<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoordoneeBanque extends Model
{
    protected $table = 'coordonee_banques';

    protected $fillable = ['numero_compte', 'raison_sociale', 'ville', 'banque', 'status'];

    use HasFactory;
}
