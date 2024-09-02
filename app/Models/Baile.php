<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Baile extends Model
{
    //
    protected $table = 'baile';

    protected $fillable = ['detalle','idDepartamento'];

    public $timestamps = false;
}
