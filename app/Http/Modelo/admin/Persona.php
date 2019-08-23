<?php

namespace siga\Modelo\admin;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = '_bp_personas';

    protected $fillable = [
        'prs_id',
        'prs_nombres',
        'prs_paterno',
        'prs_materno',
        'prs_ci',
        'prs_id_estado_civil',
        'prs_id_archivo_cv',
        'prs_direccion',
        'prs_direccion2',
        'prs_telefono',
        'prs_telefono2',
        'prs_celular',
        'prs_empresa_telefonica',
        'prs_correo',
        'prs_sexo',
        'prs_fec_nacimiento',
        'prs_estado',
        'prs_usr_id',
	'prs_linea_trabajo',
        'prs_id_garantia',
        'prs_id_relacion',
        'prs_id_tipopersona',
        'prs_id_zona',
        'prs_nomparentesco',
        'prs_ciparentesco',
        'prs_exparentesco',
        'prs_numbien',
        'prs_valorbien'
    ];
    protected $primaryKey = 'prs_id';

    public $timestamps = false;

    public function Usuario()
    {
        return HasMany('gamlp\Persona');
    }
    protected static function getListar()
    {
        $persona = Persona::join('_bp_usuarios', '_bp_personas.prs_usr_id', '=', '_bp_usuarios.usr_id')
            ->join('_bp_estados_civiles', '_bp_personas.prs_id_estado_civil', '=', '_bp_estados_civiles.estcivil_id')
            ->select(
                '_bp_personas.prs_id',
                '_bp_personas.prs_nombres',
                '_bp_personas.prs_paterno',
                '_bp_personas.prs_materno',
                '_bp_personas.prs_ci',
                '_bp_personas.prs_direccion',
                '_bp_personas.prs_telefono',
                '_bp_personas.prs_celular',
                '_bp_personas.prs_empresa_telefonica',
                '_bp_personas.prs_correo',
                '_bp_personas.prs_fec_nacimiento',
                '_bp_personas.prs_estado',
                '_bp_estados_civiles.estcivil',
                '_bp_usuarios.usr_usuario',
		'_bp_personas.prs_linea_trabajo'
            )
            ->where('_bp_personas.prs_estado', 'A')
            ->get();
        return $persona;
    }
    protected static function getDestroy($id)
    {
        $persona = Persona::where('prs_id', $id)->update(['prs_estado' => 'B']);
        return $persona;
    }
}
