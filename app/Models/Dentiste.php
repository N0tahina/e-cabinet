<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Dentiste extends Authenticatable
{
    protected $table = 'dentiste';
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
    ];

    public function getAuthIdentifierName()
    {
        return 'nom';
    }

    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }
}