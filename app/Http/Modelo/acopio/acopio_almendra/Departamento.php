<?php

namespace siga\Modelo\acopio\acopio_almendra;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'acopio.departamento';

    protected $fillable = [
        'dep_id',
        'dep_nombre',
        'dep_exp'
    ];
    protected $primaryKey = 'dep_id';
    public $timestamps = false;

    protected static function comboDep()
    {
        $data = Departamento::select('dep_id', 'dep_nombre')
        ->get();
        return $data;
    }
    protected static function comboExp()
    {
        $data = Departamento::select('dep_id', 'dep_exp')
        ->get();
        return $data;
    }
}
