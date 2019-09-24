@extends('layouts.print')

@section('content')

<table class="table-info align-top no-padding no-margins border">
    <tr>
        <td class="text-center bg-grey-darker text-xs text-white ">Articulo:</td>
        <td colspan="3" class="text-xs uppercase">YOGURT</td>
    </tr>
    <tr>
        <td  class="text-center bg-grey-darker text-xs text-white">Unidad de Medida:</td>
        <td colspan="3" class="text-xs uppercase">KILOGRAMOS</td>
    </tr>

</table>
<br>  


<br>
<table class="table-info w-100">
    <thead class="bg-grey-darker">
     
        <tr class="font-medium text-white text-sm">
            <td rowspan="1" class="px-15 py text-center text-xxs ">
                Nro.
            </td>
            <td rowspan="1" class="px-15 py text-center  text-xxs">
                Fecha Ingreso/Movimiento
            </td>


            <td colspan="3" class="px-15 py text-center text-xxs">
                Resumen de Saldos
            </td>

        </tr>
        <tr class="font-medium text-white text-sm">
            <td class="px-15 py text-center  text-xxs"></td>
            <td class="px-15 py text-center  text-xxs"></td>
            <td class="px-15 py text-center  text-xxs">Cant.</td>
            <td class="px-15 py text-center  text-xxs">C.U.</td>
            <td class="px-15 py text-center  text-xxs">Total </td>

        </tr>
    </thead>
    <tbody>
        
        <tr class="text-sm">
            <td class="text-center text-xxs uppercase font-bold px-5 py-3" >{{ 1 }}</td>
            <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ date('d/m/Y')}}</td>
            <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ number_format(0, 2, '.', '.') }}</td>
            <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ number_format(0, 2, '.', '.') }}</td>
            <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ number_format(0, 2, '.', '.') }}</td>
        </tr>
        
        <tr class="text-sm">
            <td colspan="2" class="text-center text-xxs uppercase font-bold px-5 py-3 bg-grey-darker text-white" >TOTAL:</td>
            <td class="text-center text-xxs uppercase font-bold px-5 py-3" >{{ number_format(0, 2, '.', ',') }}</td>
            <td class="text-center text-xxs uppercase font-bold px-5 py-3" >-</td>
            <td class="text-center text-xxs uppercase font-bold px-5 py-3" >{{ number_format(0, 2, '.', ',') }}</td>
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
        <td class="text-center text-xxs">Revisado por firma: ............................................</td>
        <td class="text-center text-xxs">Verificado por firma: ............................................</td>
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
