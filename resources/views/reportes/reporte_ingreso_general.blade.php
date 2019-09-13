@extends('layouts.print')

@section('content')
<table class="table-info align-top no-padding no-margins border">
    <tr>
        <td class="text-center bg-grey-darker text-xs text-white ">Planta:</td>
        <td colspan="3" class="text-xs uppercase"> {{$storage}}</td>
    </tr>
    <tr>
        <td  class="text-center bg-grey-darker text-xs text-white">Fecha Emisión:</td>
        <td colspan="3" class="text-xs uppercase"> {{date('d/m/Y')}}</td>
    </tr>

</table>
<br>
   
<table class="table-info w-100">
	<thead class="bg-grey-darker">
		<tr class="font-medium text-white text-sm">
			<td class="px-15 py text-center text-xxs ">
				Nro.
			</td>
      <td class="px-15 py text-center text-xxs">
        Número
      </td>
			<td class="px-15 py text-center  text-xxs">
				Código
			</td>
			<td class="px-15 py text-center text-xxs">
				Detalle Articulo
			</td>
			<td class="px-15 py text-center text-xxs">
				Cantidad.
      </td>
			<td class="px-15 py text-center text-xxs ">
				Costo U.
			</td>
			<td class="px-15 py text-center  text-xxs">
				Fecha Ingreso
			</td>
			<td class="px-15 py text-center text-xxs">
				Fecha Vencimiento
			</td>
			<td class="px-15 py text-center text-xxs">
				Tipo Ingreso
			</td>
      <td class="px-15 py text-center text-xxs">
        Nro. Remisión
      </td>			
		</tr>
	</thead>
	<tbody>
	<?php 
    	$nro = 0;
    	$totalCantidad = 0;
	    $totaCost = 0;
    	$totaSalida = 0;
    	$totaSaldo = 0;
  	?>
  	@foreach($insumo_ingreso as $key => $ig)
      <?php 
        $nro = $nro + 1;
      ?>
      <tr>      
        <td class="px-15 py text-center text-xxs">{{$nro}}</td>
        <td class="px-15 py text-center text-xxs">{{$ig->ing_enumeracion}}</td>
        <td class="px-15 py text-center text-xxs">{{traeCodigo($ig->deting_ins_id)}}</td>
        <td class="px-15 py text-center text-xxs">{{traeDetalle($ig->deting_ins_id)}}</td> 
        <td class="px-15 py text-center text-xxs">{{$ig->deting_cantidad}}</td>
        <td class="px-15 py text-center text-xxs">{{$ig->deting_costo}}</td>
        <td class="px-15 py text-center text-xxs">{{date('d/m/Y',strtotime($ig->ing_registrado))}}</td>
        <td class="px-15 py text-center text-xxs">{{$ig->deting_fecha_venc}}</td>
        <td class="px-15 py text-center text-xxs">{{traeTipoIngreso($ig->ing_id_tiping)}}</td>
        <td class="px-15 py text-center text-xxs">{{$ig->ing_remision}}</td> 
      </tr> 
    @endforeach
	</tbody>
</table>
<br>
<br>
<br>
<br>
<br>
<table>
    <tr>
        <td class="text-center text-xxs">Solicitado por firma: ............................................</td>
        <td class="text-center text-xxs">Autorizado por firma: ............................................</td>
	</tr>
	{{-- <tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr> --}}
    <tr>
        <td class="text-center text-xxs">Nombre: ......................................................</td>
        <td class="text-center text-xxs">Nombre: ......................................................</td>
    </tr>

</table> 
<?php
  function traeCodigo($id_insumo) {
    $insumo = siga\Modelo\insumo\insumo_registros\Insumo::where('ins_id', $id_insumo)->first();
    return $insumo->ins_codigo;
  }
  function traeDetalle($id_insumo) {
    $insumo = siga\Modelo\insumo\insumo_registros\Insumo::where('ins_id', $id_insumo)
              ->leftjoin('insumo.sabor as sab','insumo.insumo.ins_id_sabor','=','sab.sab_id')->first();
              //dd($insumo);
    return $insumo->ins_desc.' '.$insumo->sab_nombre.' '.$insumo->ins_peso_presen;
  }
  function traeUnidad($id_insumo) {
    $insumo = siga\Modelo\insumo\insumo_registros\Insumo::join('insumo.unidad_medida as umed', 'insumo.insumo.ins_id_uni', '=', 'umed.umed_id')
      ->where('ins_id', $id_insumo)->first();
    return $insumo->umed_nombre;
  }
  function traeSalidas($id_insumo,$id_planta)
  {
    //dd("INS ID: ".$id_insumo.", ID DETING: ".$id_deting);
    $insumo = siga\Modelo\insumo\InsumoHistorial::select(DB::raw('SUM(inshis_cantidad) as cantidad'))->where('inshis_ins_id',$id_insumo)->where('inshis_detorprod_id','<>',null)->where('inshis_planta_id',$id_planta)->first();
    //dd($insumo);
    if ($insumo->cantidad) {
      return $insumo->cantidad;
    }else{
      return 0.00;
    }
  }
  function traeTipoIngreso($id)
  {
    $tipo = \DB::table('insumo.tipo_ingreso')->where('ting_id',$id)->first();
    return $tipo->ting_nombre;
  }
 ?>
@endsection
