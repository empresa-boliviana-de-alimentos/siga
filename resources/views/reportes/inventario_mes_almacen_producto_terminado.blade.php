@extends('layouts.print')

@section('content')
<table class="table-info align-top no-padding no-margins border">
    <tr>
        <td class="text-center bg-grey-darker text-xs text-white ">Emitida por:</td>
        <td colspan="5" class="text-xs uppercase">{{$per}}</td>
      
	</tr>
    <tr>
        <td  class="text-center bg-grey-darker text-xs text-white">Fecha Generada:</td>
        <td  class="text-xs uppercase">{{$fecha}}</td>
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
				Cantidad
			</td>
			<td class="px-15 py text-center text-xxs">
				Fecha venc.
			</td>
			<td class="px-15 py text-center text-xxs">
				Fecha Registro
			</td>
		</tr>
	</thead>
	<tbody>
			@php
				$nro = 1;
				$tot1 =0;
			@endphp
			@foreach($stockptMes as $d)
			<tr class="text-sm">
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $nro++ }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $d->rece_codigo}}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">
				@if($d->sab_id == 1)
					{{ $d->rece_nombre.' '.$d->rece_presentacion }}
				@else
					{{ $d->rece_nombre.' '.$d->sab_nombre.' '.$d->rece_presentacion }}
				@endif
				</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $d->spth_cantidad }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ date('d/m/Y',strtotime($d->spth_fecha_vencimiento)) }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ date('d/m/Y', strtotime($d->spth_registrado)) }}</td>
			</tr>
			@php
				$tot1=$tot1+$d->spth_cantidad;
			@endphp
			@endforeach
			<tr class="text-sm">
				<td colspan="3" class="text-center text-xxs bg-grey-darker text-white">TOTAL:</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ number_format($tot1,2,'.',',')}}</td>
				<td class="text-center text-xxs bg-grey-darker text-white">-</td>
				<td class="text-center text-xxs bg-grey-darker text-white">-</td>
			</tr>
	</tbody>
</table>
<br>
<br>
<br>
<br>
<table>
    <tr>
        <td class="text-center text-xxs">.............................................</td>
        <td class="text-center text-xxs">.............................................</td>
        <td class="text-center text-xxs">......................................</td>
    </tr>
    <tr>
        <td class="text-center text-xxs">Responsable de Almacén</td>
        <td class="text-center text-xxs">Responsable Administrativo</td>
        <td class="text-center text-xxs">Jefe de Planta</td>
    </tr>

</table>


@endsection
