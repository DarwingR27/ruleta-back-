<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Capital extends Model
{
    //
    protected $table = 'capital';

    protected $fillable = ['detalle','idDepartamento'];

    public $timestamps = false;
}
