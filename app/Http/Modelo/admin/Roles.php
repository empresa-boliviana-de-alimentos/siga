<?php

namespace siga\Modelo\admin;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table      = '_bp_roles';
    protected $fillable   = ['rls_id', 'rls_rol', 'rls_registrado', 'rls_modificado', 'rls_usr_id', 'rls_estado'];
    protected $primaryKey = 'rls_id';
    public $timestamps    = false;
    protected static function getListar()
    {
    	$sql=Roles::select('rls_id','rls_rol')->where('rls_id',1)->first();
    	return $sql;
    	//$sql=Roles::where('rls_id',$id)->fisrt();
    }
}
