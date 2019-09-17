@extends('layouts.print')

@section('content')

<table class="table-info align-top no-padding no-margins border">
    <tr>
        <td class="text-center bg-grey-darker text-xs text-white ">Responsable de Almacén:</td>
        <td colspan="5" class="text-xs uppercase">{{$per}}</td>
      
	</tr>
	<tr>
		<td class="text-center bg-grey-darker text-xs text-white ">Conductor:</td>
        <td class="text-xs uppercase">{{$detingresocanaspv->conductor}}</td>
        <td class="text-center bg-grey-darker text-xs text-white ">Fecha Ingreso:</td>
        <td class="text-xs uppercase">{{$detingresocanaspv->iac_fecha_ingreso}}</td>
        <td class="text-center bg-grey-darker text-xs text-white ">No. Ingreso:</td>
        <td class="text-xs uppercase">{{$detingresocanaspv->iac_nro_ingreso}}</td>
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
				Imagen
			</td>
			<td class="px-15 py text-center text-xxs">
				Canastillo
			</td>
			<td class="px-15 py text-center text-xxs">
				Producto
			</td>
			<td class="px-15 py text-center text-xxs">
				Cantidad
			</td>
		</tr>
	</thead>
	<tbody>
			<tr class="text-sm">
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ 1 }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1"><img src="{{ public_path('archivo/canastillo/'.$detingresocanaspv->ctl_foto_canastillo) }}" style=" width: 148px;"></td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detingresocanaspv->ctl_descripcion }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detingresocanaspv->producto }}</td>
				<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ number_format($detingresocanaspv->iac_cantidad,2,'.',',') }}</td>
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
