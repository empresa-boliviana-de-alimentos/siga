@extends('layouts.print')

@section('content')

<table class="table-info align-top no-padding no-margins border">
    <tr>
        <td class="text-center bg-grey-darker text-xs text-white ">Responsable de Almacén:</td>
        <td colspan="5" class="text-xs uppercase">{{$per['prs_nombres'].' '.$per['prs_paterno'].' '.$per['prs_materno']}}</td>
      
	</tr>
	<tr>
		<td class="text-center bg-grey-darker text-xs text-white ">Dependencia:</td>
        <td class="text-xs uppercase">{{$reg['nombre_planta']}}</td>
        <td class="text-center bg-grey-darker text-xs text-white ">Tipo Ingreso:</td>
        <td class="text-xs uppercase">{{$reg['ting_nombre']}}</td>
        <td class="text-center bg-grey-darker text-xs text-white ">No. Contrato:</td>
        <td class="text-xs uppercase">{{$reg['ingpre_nrocontrato']}}</td>
	</tr>
    <tr>
        <td  class="text-center bg-grey-darker text-xs text-white">Fecha Nota Rem:</td>
        <td  class="text-xs uppercase">{{$reg['ingpre_fecha_remision']}}</td>
        <td  class="text-center bg-grey-darker text-xs text-white">Nota Remision:</td>
        <td  class="text-xs uppercase">{{$reg['ingpre_remision']}}</td>
        <td  class="text-center bg-grey-darker text-xs text-white">Nro. Factura:</td>
        <td  class="text-xs uppercase">{{$reg['ingpre_nrofactura']}}</td>
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
				Proveedor
			</td>
			<td class="px-15 py text-center text-xxs">
				Fecha venc.
			</td>
			<td class="px-15 py text-center text-xxs">
				Cantidad
			</td>
			<td class="px-15 py text-center text-xxs">
				Costo U.
			</td>
			<td class="px-15 py text-center text-xxs">
				Costo Tot.
			</td>
		</tr>
	</thead>
	<tbody>
			@php
				$nro = 1;
				$tot1 =0;
			@endphp
			@foreach($deta_ingreso as $d)
			@php
				$tot = $d->detingpre_cantidad * $d->detingpre_costo;	
			@endphp
			<tr class="text-sm">
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $nro++ }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $d->umed_nombre}}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $d->ins_desc }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $d->prov_nom }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $d->detingpre_fecha_venc }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ number_format($d->detingpre_cantidad,2,'.',',') }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ number_format($d->detingpre_costo,2,'.',',') }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ number_format($tot,2,'.',',') }}</td>
			</tr>
			@php
				$tot1=$tot1+$tot;
			@endphp
			@endforeach
			<tr class="text-sm">
				<td colspan="7" class="text-center text-xxs bg-grey-darker text-white">TOTAL:</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ number_format($tot1,2,'.',',')}}</td>
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
    </tr>
    <tr>
        <td class="text-center text-xxs">Responsable de Almacen</td>
        <td class="text-center text-xxs">Responsable Administrativo</td>
        <td class="text-center text-xxs">Jefe de Planta</td>
    </tr>

</table> 

@endsection
