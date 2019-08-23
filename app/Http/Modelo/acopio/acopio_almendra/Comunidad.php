<?php

namespace siga\Modelo\acopio\acopio_almendra;

use Illuminate\Database\Eloquent\Model;

class Comunidad extends Model
{
    protected $table = 'acopio.comunidad';

    protected $fillable = [
        'com_id',
        'com_nombre',
        'com_id_mun',
        'com_estado'
    ];
    protected $primaryKey = 'com_id';
    public $timestamps = false;

    protected static function combo()
    {
        $data = Comunidad::select('com_id', 'com_nombre')
            //->where('estado', 1)
            ->get();
            return $data;
    }
}
