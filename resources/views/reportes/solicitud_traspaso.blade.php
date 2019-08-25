@extends('layouts.print')

@section('content')

<table class="table-info align-top no-padding no-margins border">
    <tr>
        <td class="text-center bg-grey-darker text-xs text-white ">Solicitante:</td>
        <td colspan="3" class="text-xs uppercase">{{$reg['prs_nombres'].' '.$reg['prs_paterno'].' '.$reg['prs_materno']}}</td>
    </tr>
    <tr>
        <td  class="text-center bg-grey-darker text-xs text-white">Planta a Solcicitar:</td>
        <td colspan="3" class="text-xs uppercase">{{$reg['nombre_planta']}}</td>
    </tr>

</table>
<br>
   
<table class="table-info w-100">
	<thead class="bg-grey-darker">
		<tr class="font-medium text-white text-sm">
			<td class="px-15 py text-center text-xxs ">
				Nro.
			</td>
			<td class="px-15 py text-center  text-xxs">
				Insumo
			</td>
			<td class="px-15 py text-center text-xxs">
				Unidad de Medida
			</td>
			<td class="px-15 py text-center text-xxs">
				Cantidad
			</td>
		</tr>
	</thead>
	<tbody>


			@php
				$detorp = siga\Modelo\insumo\insumo_solicitud\ DetalleOrdenProduccion::join('insumo.insumo as ins','insumo.detalle_orden_produccion.detorprod_ins_id','=','ins.ins_id')->join('insumo.unidad_medida as umed','ins.ins_id_uni','=','umed.umed_id')->where('detorprod_orprod_id',$id_orp)->get();
				$nro = 1;
			@endphp
			@foreach($detorp as $det)
			<tr class="text-sm">
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $nro++ }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $det['ins_desc']}}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $det['umed_nombre'] }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $det['detorprod_cantidad'] }}</td>
			</tr>
			@endforeach
	</tbody>
</table>
<br>
<table class="table-info align-top no-padding no-margins border">
	<tr>
		<td class="text-center bg-grey-darker text-xs text-white ">Observaciones:</td>
		<td colspan="3" class="text-xs uppercase">{{$reg['orprod_obs_usr']}}</td>
	</tr>
	

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

@endsection
