<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nom',
        'email',
        'mot_de_passe',
        'telephone',
    ];

    protected $hidden = [
        'mot_de_passe',
        'remember_token', // garder caché
    ];

    public function getAuthIdentifierName()
    {
        return 'nom';
    }

    // Pour que Laravel utilise ta colonne mot_de_passe
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }
}
