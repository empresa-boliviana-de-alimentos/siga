<?php

namespace siga\Modelo\acopio\acopio_frutos;

use Illuminate\Database\Eloquent\Model;

class Calibre extends Model
{
    protected $table      = 'acopio.calibre';

    protected $fillable   = [
        'calibre_id',
        'codigo',
        'corona',
        'peso_cor',
        'peso_scor',
        'sincorona'
    ];

    public $timestamps = false;

    protected $primaryKey = 'calibre_id';

     protected static function combo()
    {
        $data = Calibre::select('calibre_id', 'codigo')
           // ->where('prov_estado', 'A')
            ->get();
        return $data;
    }

     protected static function setBuscar($id)
    {
        $calibre=Calibre::where('calibre_id', $id)
        ->first();
        return $calibre;
    }

}
