<?php

namespace siga\Modelo\acopio\acopio_miel;

use Illuminate\Database\Eloquent\Model;

class Propiedades_Miel extends Model
{
    protected $table      = 'acopio.propiedades_miel';

    protected $fillable   = [
        'prom_id',
        'prom_peso_bruto',
        'prom_peso_tara',
        'prom_peso_neto',
        'prom_cantidad_baldes',
        'prom_total',
        'prom_cod_colmenas',
        'prom_centrifugado',
        'prom_peso_bruto_centrif',
        'prom_peso_bruto_filt',
        'prom_peso_bruto_imp',
        'prom_humedad',
        'prom_cos_un',
        'prom_total_marcos',
        'prom_colmenas',
        'prom_baldesjson'      
    ];

    public $timestamps = false;

    protected $primaryKey = 'prom_id';

    protected static function getListar()
    {
        $propiedades_miel = Propiedades_Miel::all();
           
        return $propiedades_miel;
    }
}
