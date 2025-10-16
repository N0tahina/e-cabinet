<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    use HasFactory;

    protected $table = 'rendez_vous';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'dentiste_id',
        'date_heure',
        'statut',
        'commentaire',
    ];
}
