<?php

namespace siga\Modelo\admin;

use Illuminate\Database\Eloquent\Model;

class LogSeguimiento extends Model
{
    protected $table      = '_bp_log_seguimiento';
    protected $fillable   = ['log_id', 'log_usr_id', 'log_metodo', 'log_accion', 'log_detalle','log_consulta','log_modulo', 'log_registrado', 'log_modificado'];
    public $timestamps    = false;
    protected $primaryKey = 'log_id';
    
}
