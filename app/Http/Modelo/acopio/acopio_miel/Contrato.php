<?php

namespace siga\Modelo\acopio\acopio_miel;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $table      = 'acopio.contrato';

    protected $fillable   = [
        'contrato_id',
        'contrato_id_prov',
        'contrato_nro',
        'contrato_precio',
        'contrato_deuda',
        'contrato_sindicato',
        'contrato_central',
	'contrato_saldo'        
    ];

    public $timestamps = false;

    protected $primaryKey = 'contrato_id';

    protected static function getListar($prov)
    {
        $contrato = Contrato::where('contrato_id_prov','=',$prov)->first();
           
        return $contrato;
    }
    //  protected static function getDestroy($id)
    // {
    //     $acopio = Acopio::where('id_acopio', $id)->update(['estado' => '0']);
    //     return $acopio;
    // }
}
