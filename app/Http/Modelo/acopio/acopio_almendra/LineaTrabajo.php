<?php

namespace siga\Modelo\acopio\acopio_almendra;

use Illuminate\Database\Eloquent\Model;

class LineaTrabajo extends Model
{
    protected $table = 'acopio.linea_trab';

    protected $fillable = [
        'ltra_id',
        'ltra_nombre',
        'ltra_estado',
        'ltra_fecha_reg'
    ];
    protected $primaryKey = 'ltra_id';
    public $timestamps = false;

    protected static function combo()
    {
        $data = LineaTrabajo::select('ltra_id', 'ltra_nombre')
            ->where('ltra_estado', 'A')
            ->get();
            return $data;
    }
}
