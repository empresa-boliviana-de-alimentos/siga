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
			<td rowspan="2" class="px-15 py text-center text-xxs ">
				Nro.
			</td>
			<td rowspan="2" class="px-15 py text-center  text-xxs">
				Código
			</td>
			<td rowspan="2" class="px-15 py text-center text-xxs">
				Detalle Articulo
			</td>
			<td rowspan="2" class="px-15 py text-center text-xxs">
				Precio U.
			</td>
			<td rowspan="2" class="px-15 py text-center text-xxs ">
				Total
			</td>
			<td rowspan="2" class="px-15 py text-center  text-xxs">
				Unidad
			</td>
			<td colspan="3" class="px-15 py text-center text-xxs">
				Cantidad
			</td>
			<td colspan="3" class="px-15 py text-center text-xxs">
				Costo
			</td>
			
		</tr>
		<tr class="font-medium text-white text-sm">
			<td class="px-15 py text-center text-xxs">
				Entrada
			</td>
			<td class="px-15 py text-center text-xxs">
				Salida
			</td>
			<td class="px-15 py text-center text-xxs ">
				Saldo
			</td>
			<td class="px-15 py text-center  text-xxs">
				Entrada
			</td>
			<td class="px-15 py text-center text-xxs">
				Salida
			</td>
			<td class="px-15 py text-center text-xxs">
				Saldo
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
        $salidas = traeSalidas($ig->deting_ins_id,$planta->id_planta);
        $saldo_cantidad = $ig->deting_cantidad - $salidas;
        $costo_entrada = $ig->deting_cantidad * $ig->deting_costo;
        $costo_salida = $ig->deting_costo * $salidas;
        $saldo_costos = $costo_entrada - $costo_salida;

        $totaCost = $totaCost + $costo_entrada;
        $totaSalida = $totaSalida +$costo_salida;
        $totaSaldo = $totaSaldo + $saldo_costos;
      ?>
      <tr>      
        <td class="px-15 py text-center text-xxs">{{$nro}}</td>
        <td class="px-15 py text-center text-xxs">{{traeCodigo($ig->deting_ins_id)}}</td>
        <td class="px-15 py text-center text-xxs">{{traeDetalle($ig->deting_ins_id)}}</td> 
        <td class="px-15 py text-center text-xxs">{{$ig->deting_costo}}</td>
        <td class="px-15 py text-center text-xxs">{{$ig->deting_cantidad}}</td>
        <td class="px-15 py text-center text-xxs">{{traeUnidad($ig->deting_ins_id)}}</td>
        <td class="px-15 py text-center text-xxs">{{number_format($ig->deting_cantidad,2,'.',',')}}</td>
        <td class="px-15 py text-center text-xxs">{{number_format($salidas,2,'.',',')}}</td>
        <td class="px-15 py text-center text-xxs">{{number_format($saldo_cantidad,2,'.',',')}}</td> 
        <td class="px-15 py text-center text-xxs">{{number_format($costo_entrada,2,'.',',')}}</td>
        <td class="px-15 py text-center text-xxs">{{number_format($costo_salida,2,'.',',')}}</td>
        <td class="px-15 py text-center text-xxs">{{number_format($saldo_costos,2,'.',',')}}</td>
      </tr> 
    @endforeach
	  <tr>
      	<td class="px-15 py bg-grey-darker text-center text-xxs text-white" colspan="9"><strong>TOTALES</strong></td>
      	<td class="px-15 py text-center text-xxs"><strong>{{number_format($totaCost, 2, '.', ',')}}</strong></td>
      	<td class="px-15 py text-center text-xxs"><strong>{{number_format($totaSalida, 2, '.', ',')}}</strong></td>
      	<td class="px-15 py text-center text-xxs"><strong>{{number_format($totaSaldo, 2, '.', ',')}}</strong></td>
      </tr>	
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
 ?>
@endsection
