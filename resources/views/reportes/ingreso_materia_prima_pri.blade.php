@extends('layouts.print')

@section('content')

<table class="table-info align-top no-padding no-margins border">
	<tr>
		<td class="text-center bg-grey-darker text-xs text-white ">Responsable Almacén:</td>
		<td colspan="3" class="text-xs uppercase">{{$per['prs_nombres'].' '.$per['prs_paterno'].' '.$per['prs_materno']}}</td>
		<td class="text-center bg-grey-darker text-xs text-white ">Dependencia:</td>
		<td colspan="3" class="text-xs uppercase">{{$planta['nombre_planta']}}</td>
		
	</tr>
	<tr>
		<td class="text-center bg-grey-darker text-xs text-white ">Insumo:</td>
		<td colspan="3" class="text-xs uppercase">{{$detalle_ingreso->ins_desc}}</td>
		<td  class="text-center bg-grey-darker text-xs text-white">Cantidad Enviado:</td>
		<td colspan="3" class="text-xs uppercase">{{$reg['enval_cant_total']}}</td>
	
	</tr>
	<tr>
		<td  class="text-center bg-grey-darker text-xs text-white">Cantidad Recibido:</td>
		<td colspan="3" class="text-xs uppercase">{{$detalle_ingreso['deting_cantidad']}}</td>
		<td  class="text-center bg-grey-darker text-xs text-white">Costo U.:</td>
		<td colspan="3" class="text-xs uppercase">{{$detalle_ingreso['deting_costo']}}</td>
	</tr>
	
</table>
<br>
<table class="table-info align-top no-padding no-margins border">
	<tr>
		<td colspan="3"class="text-center bg-grey-darker text-xs text-white ">Observaciones (Justificantes):</td>
		<td class="text-xs uppercase">{{$reg['ing_obs']}}</td>
	</tr>
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
