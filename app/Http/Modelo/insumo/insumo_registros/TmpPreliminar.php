<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;

class TmpPreliminar extends Model
{
    protected $table = 'insumo.tmp_preliminar';

    protected $fillable = [
        'tmpp_id',
       // 'tmpp_id_prov',
        'tmpp_rem',
        'tmpp_tiping',
        'tmpp_fech',
        'tmpp_usr_id',
        'tmpp_registrado',
        'tmpp_estado',
        'tmpp_lote',
        'tmpp_num',
        'tmpp_gestion',
        'tmpp_nrocontrato'
    ];
    protected $primaryKey = 'tmpp_id';

    public $timestamps = false;

}
