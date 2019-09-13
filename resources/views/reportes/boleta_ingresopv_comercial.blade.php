@extends('layouts.print')

@section('content')
<table class="table-info align-top no-padding no-margins border">
    <tr>
        <td class="text-center bg-grey-darker text-xs text-white ">Responsable de Punto Venta:</td>
        <td colspan="5" class="text-xs uppercase">{{$per}}</td>
      
	</tr>
    <tr>
        <td  class="text-center bg-grey-darker text-xs text-white">Fecha Ingreso:</td>
        <td  class="text-xs uppercase">{{$date}}</td>
        <td  class="text-center bg-grey-darker text-xs text-white">Nro. Ingreso:</td>
        <td  class="text-xs uppercase">{{$code}}</td>
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
			@endphp
			@foreach($detingresopv as $d)
			@php
				$tot = $d->detingpv_cantidad * $d->detingpv_costo;	
			@endphp
			<tr class="text-sm">
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $nro++ }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $d->prod_codigo}}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">
				@if($d->sab_id == 1)
					{{ $d->rece_nombre.' '.$d->rece_presentacion }}
				@else
					{{ $d->rece_nombre.' '.$d->sab_nombre.' '.$d->rece_presentacion }}
				@endif
				</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $d->detingpv_lote }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $d->detingpv_fecha_venc }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ number_format($d->detingpv_cantidad,2,'.',',') }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ number_format($d->detingpv_costo,2,'.',',') }}</td>
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
    </tr>
    <tr>
        <td class="text-center text-xxs">Responsable de Punto de Venta</td>
    </tr>

</table> 
@endsection