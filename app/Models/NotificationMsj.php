<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationMsj extends Model
{
    protected $table = 'notification_msjs';

    protected $fillable = [
        'cotisation_id',
        'user_id',
        'content',
        'read',
    ];

    public function cotisation()
    {
        return $this->belongsTo(Cotisation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    use HasFactory;
}
