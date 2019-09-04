@extends('layouts.print')

@section('content')

<table class="table-info align-top no-padding no-margins border">
    <tr>
        <td class="text-center bg-grey-darker text-xs text-white ">Solicitante:</td>
        <td colspan="3" class="text-xs uppercase">{{$usuario->prs_nombres.' '.$usuario->prs_paterno.' '.$usuario->prs_materno}}</td>
        <td class="text-center bg-grey-darker text-xs text-white ">Dependencia:</td>
        <td colspan="3" class="text-xs uppercase">{{$reg['nombre_planta']}}</td>
        <td class="text-center bg-grey-darker text-xs text-white ">Fecha Solicitud:</td>
        <td colspan="3" class="text-xs uppercase">{{date('d/m/Y',strtotime($reg['orprod_registrado']))}}</td>
    </tr>
    <tr>
        <td  class="text-center bg-grey-darker text-xs text-white">No. Orden Produccion:</td>
        <td colspan="3" class="text-xs uppercase">{{$reg['orprod_nro_orden']}}</td>
        <td  class="text-center bg-grey-darker text-xs text-white">Mercado:</td>
        <td colspan="3" class="text-xs uppercase">{{$reg['mer_nombre']}}</td>
        <td  class="text-center bg-grey-darker text-xs text-white">Fecha Entrega:</td>
        <td colspan="3" class="text-xs uppercase">{{date('d/m/Y',strtotime($reg['orprod_modificado']))}}</td>
    </tr>
    <tr>
        <td  class="text-center bg-grey-darker text-xs text-white">Producto:</td>
        <td colspan="9" class="text-xs uppercase">{{$reg['rece_nombre']}} {{$reg['sab_nombre']}} {{$reg['rece_presentacion']}}</td>
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
				Unidad
			</td>
			<td class="px-15 py text-center text-xxs">
				Descripcion
			</td>
			<td class="px-15 py text-center text-xxs">
				Cantidad
			</td>
			<td class="px-15 py text-center text-xxs">
				Mercado
			</td>
		</tr>
	</thead>
	<tbody>
			@php
				$nro = 1;
			@endphp
			@foreach($detroprod as $d)
			<tr class="text-sm">
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $nro++ }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $d->umed_nombre}}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $d->ins_desc }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $d->detorprod_cantidad }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $reg['mer_nombre'] }}</td>
			</tr>
			@endforeach
			<tr class="text-sm">
				<td colspan="4" class="text-center text-xxs bg-grey-darker text-white">TOTAL TIPOS DE INSUMOS SOLICITADOS</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{$nro-1}}</td>
			</tr>
	</tbody>
</table>


<br>
<br>
<br>
<br>
<table>
    <tr>
        <td class="text-center text-xxs">.....................................................</td>
        <td class="text-center text-xxs">.....................................................</td>
        <td class="text-center text-xxs">.....................................................</td>
        <td class="text-center text-xxs">.....................................................</td>
    </tr>
    <tr>
        <td class="text-center text-xxs">Responsable de Almacen</td>
        <td class="text-center text-xxs">Recepcion</td>
        <td class="text-center text-xxs">Encargado de Produccion</td>
        <td class="text-center text-xxs">Jefe de Planta</td>
    </tr>

</table> 

@endsection
