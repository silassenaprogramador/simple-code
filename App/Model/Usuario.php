<?php

namespace Ssp\App\Model;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{

    protected $table = 'usuario';
    protected $primaryKey = 'id';
    protected $fillable = ["nome","email","senha"];
    protected $timestamp = false;

    
}