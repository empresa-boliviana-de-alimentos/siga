<?php

namespace siga\Modelo;

use Illuminate\Database\Eloquent\Model;

class HistoStock extends Model
{
     protected $table = 'insumo.stock_historial';

    protected $fillable = [
        'hist_id',
        'hist_id_stock',
        'hist_id_ins',
        'hist_id_carring',
        'hist_id_aprobsol',
        'hist_id_planta',
        'hist_fecha',
        'hist_detale',
        'hist_cant_ent',
        'hist_cost_ent',
        'hist_tot_ent',
        'hist_cant_sal',
        'hist_cost_sal',
        'hist_tot_sal',
        'hist_cant_saldo',
        'hist_cost_saldo',
        'hist_tot_saldo',
        'hist_usr_id',
        'hist_registrado',
    ];

    protected $primaryKey = 'hist_id';

    public $timestamps = false;
}
