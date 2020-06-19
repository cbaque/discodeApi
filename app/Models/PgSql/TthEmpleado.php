<?php

namespace App\Model\PgSql;

use Illuminate\Database\Eloquent\Model;

class TthEmpleado extends Model
{
    protected $table = 'tth_empleados';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'apellido',
      ];
}
