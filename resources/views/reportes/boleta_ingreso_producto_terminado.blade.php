@extends('layouts.print')

@section('content')

<table class="table-info align-top no-padding no-margins border">
    <tr>
        <td class="text-center bg-grey-darker text-xs text-white ">Responsable de Almacén:</td>
        <td colspan="5" class="text-xs uppercase">{{$per}}</td>
      
	</tr>
	<tr>
		<td class="text-center bg-grey-darker text-xs text-white ">Lote:</td>
        <td class="text-xs uppercase">{{$detingresopv->ipt_lote}}</td>
        <td class="text-center bg-grey-darker text-xs text-white ">Fecha Vencimiento:</td>
        <td class="text-xs uppercase">{{$detingresopv->ipt_fecha_vencimiento}}</td>
        <td class="text-center bg-grey-darker text-xs text-white ">No. Orden:</td>
        <td class="text-xs uppercase">{{$detingresopv->orprod_nro_orden}}</td>
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
				Codigo
			</td>
			<td class="px-15 py text-center text-xxs">
				Producto
			</td>
			<td class="px-15 py text-center text-xxs">
				Lote
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
				$tot = $detingresopv->ipt_cantidad * $detingresopv->itp_costo_unitario;	
			@endphp
			<tr class="text-sm">
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $nro++ }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detingresopv->rece_codigo}}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">
				@if($detingresopv->sab_id == 1)
					{{ $detingresopv->rece_nombre.' '.$detingresopv->rece_presentacion }}
				@else
					{{ $detingresopv->rece_nombre.' '.$detingresopv->sab_nombre.' '.$detingresopv->rece_presentacion }}
				@endif
				</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detingresopv->ipt_lote }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detingresopv->ipt_fecha_vencimiento }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ number_format($detingresopv->ipt_cantidad,2,'.',',') }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ number_format($detingresopv->ipt_costo_unitario,2,'.',',') }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ number_format($tot,2,'.',',') }}</td>
			</tr>
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
