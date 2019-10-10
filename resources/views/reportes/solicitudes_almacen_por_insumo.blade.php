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
				Nro. ORP
			</td>
			<td class="px-15 py text-center text-xxs">
				Codigo
			</td>
			<td class="px-15 py text-center text-xxs">
				Insumo
			</td>
			<td class="px-15 py text-center text-xxs">
				Cantidad
			</td>
			<td class="px-15 py text-center text-xxs">
				Fecha Solicitud
			</td>
			<td class="px-15 py text-center text-xxs">
				Estado
			</td>
		</tr>
	</thead>
	<tbody>
			@php
				$nro = 1;
				$tot1 =0;
			@endphp
			@foreach($reg as $d)
			<tr class="text-sm">
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $nro++ }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $d->orprod_nro_orden}}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $d->ins_codigo}}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $d->ins_desc }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $d->detorprod_cantidad }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $d->orprod_registrado}}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">
					@if($d->orprod_nro_salida)
						APROBADO
					@else
						SIN APROBACIÓN
					@endif
				</td>
			</tr>
			@endforeach
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
