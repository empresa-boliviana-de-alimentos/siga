<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;

class CarroIngreso extends Model
{
    protected $table       = 'insumo.carro_ingreso';
    protected $fillable    = ['carr_ing_id','carr_ing_prov', 'carr_ing_rem', 'carr_ing_tiping', 'carr_ing_fech', 'carr_ing_fact', 'carr_ing_usr_id', 'carr_ing_data', 'carr_ing_registrado', 'carr_ing_estado', 'carr_ing_lote','carr_ing_id_planta','carr_ing_num', 'carr_ing_gestion','carr_ing_nrocontrato'];
    protected $jsonColumns = ['carr_ing_data'];
    public $timestamps     = false;
    protected $primaryKey  = 'carr_ing_id';
}
