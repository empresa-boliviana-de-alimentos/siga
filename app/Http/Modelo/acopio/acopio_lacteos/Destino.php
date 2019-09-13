<?php

namespace siga\Http\Modelo\acopio\acopio_lacteos;

use Illuminate\Database\Eloquent\Model;

class Destino extends Model {
	protected $table = 'producto_terminado.destino';
	protected $fillable = ['de_id', 'de_nombre', 'de_codigo', 'de_mercado', 'de_linea_trabajo', 'de_planta_id', 'de_departamento', 'de_registrado', 'de_modificado', 'de_usr_id', 'de_estado'];
	public $timestamps = false;
	protected $primaryKey = 'de_id';

	protected static function getListarDestinos() {
		$vehiculos = Destino::select('*')
			->where('de_estado', 'A')
			->orderBy('de_id', 'DESC')
			->get();
		return $vehiculos;
	}
	protected static function getId() {
		$id = Destino::select('de_id')
			->orderBy('de_id', 'DESC')
			->first();
		return $id;
	}

	protected static function getDestroy($id) {
		$vehiculos = Destino::where('de_id', $id)->update(['de_estado' => 'B']);
		return $vehiculos;
	}

	protected static function getDestinos($id) {
		$vehiculos = Destino::where('de_id', $id)
			->where('de_estado', 'A')
			->first();
		return $vehiculos;
	}

}
