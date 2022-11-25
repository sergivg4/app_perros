<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perro extends Model
{
    protected $fillable =[
        'raza','descripcion','imagen'
    ];
    public $timestamps = false;
}
