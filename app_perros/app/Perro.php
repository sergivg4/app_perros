<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perro extends Model
{
    protected $fillable =[
        'id','raza','size','descripcion','imagen'
    ];
    public $timestamps = false;
}
