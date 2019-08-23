<?php

namespace siga\Modelo\acopio\acopio_miel;

use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
    protected $table      = 'acopio.pagos';

    protected $fillable   = [
        'pago_id',
        'pago_amortizacion',
        'pago_amortizacionbs',
        'pago_t_men_amort',
        'pago_rau_iue',
        'pago_rau_it',
        'pago_liquido_pag',
        'pago_saldo_deuda',
        'pago_id_contrato',
	'pago_id_aco',
        'pago_cuota',
        'pago_cuota_pago',
        'pago_cuota_saldo'     
    ];

    public $timestamps = false;

    protected $primaryKey = 'pago_id';

    protected static function getListar()
    {
        $pagos = Pagos::all();
           
        return $pagos;
    }
    //  protected static function getDestroy($id)
    // {
    //     $acopio = Acopio::where('id_acopio', $id)->update(['estado' => '0']);
    //     return $acopio;
    // }
}
