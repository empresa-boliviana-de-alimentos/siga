<?php

namespace siga\Modelo\insumo\insumo_recetas;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    protected $table = 'insumo.receta';

    protected $fillable = [
        'rece_id',
        'rece_codigo',
        'rece_enumeracion',
        'rece_nombre',
        'rece_lineaprod_id',
        'rece_sublinea_id',
        'rece_sabor_id',
        'rece_presentacion',
        'rece_uni_id',
        'rece_prod_total',
        'rece_rendimiento_base',
        'rece_umed_repre',
        'rece_obs',
        'rece_datos_json',
        'rece_usr_id',
        'rece_registrado',
        'rece_modificado',
        'rece_estado'
    ];

    protected $primaryKey = 'rece_id';

    public $timestamps = false;

    protected static function getlistar()
    {
        $receta = Receta::join('public._bp_planta as planta','insumo.receta.rec_id_planta','=','planta.id_planta')
                    ->join('acopio.linea_trab as linea','insumo.receta.rec_id_lineatrab','=','linea.ltra_id')
                    ->join('insumo.mercado as mercado','insumo.receta.rec_id_mercado','=','mercado.merc_id')
                    ->where('rec_estado', 'A')
            ->get();
        return $receta;
    }

    protected static function getDestroy($id)
    {
        $receta = Receta::where('rec_id','=',$id)
        ->update(['rec_estado' => 'B']);
        return $receta;
    }
}
