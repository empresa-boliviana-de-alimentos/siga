@extends('layouts.print')

@section('content')

<table class="table-info align-top no-padding no-margins border">
    <tr>
        <td class="text-center bg-grey-darker text-xs text-white ">Articulo:</td>
        <td colspan="3" class="text-xs uppercase">{{$insumo->ins_desc}}</td>
    </tr>
    <tr>
        <td  class="text-center bg-grey-darker text-xs text-white">Unidad de Medida:</td>
        <td colspan="3" class="text-xs uppercase">{{$insumo->umed_nombre}}</td>
    </tr>

</table>
<br>
   

<table class="table-info w-100">
    <thead class="bg-grey-darker">
        <tr class="font-medium text-white text-sm">
            <td rowspan="1" class="px-15 py text-center text-xxs ">
                Nro.
            </td>
            <td rowspan="1" class="px-15 py text-center  text-xxs">
                Fecha
            </td>
            <td rowspan="1" class="px-15 py text-center text-xxs">
                Detalle
            </td>

            <td colspan="1" class="px-15 py text-center text-xxs">
                Entrada
            </td>
            <td colspan="1" class="px-15 py text-center text-xxs">
                Salida
            </td>
            <td colspan="1" class="px-15 py text-center text-xxs">
                Saldo
            </td>
        </tr>
       
    </thead>
    <tbody>
		 @php
			$count=1;
			$saldo=0;	 
		 @endphp
        @foreach ($tabkarde as $ig)
            <tr class="text-sm">
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ $count++ }}</td>
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{Carbon\Carbon::parse($ig->inshis_registrado, 'UTC')->format('d-m-Y')}}</td>
                @if($ig->inshis_tipo == 'Entrada')
                    <td class="text-center text-xxxs font-bold px-5 py-3">{{ 'Ingreso (NI-'.$ig->ing_enumeracion.')' }}</td>
                @else
                    <td class="text-center text-xxxs font-bold px-5 py-3">{{ 'Salida (NS-'.$ig->orprod_nro_salida.')' }}</td>
                @endif
                @if($ig->inshis_deting_id != null and $ig->inshis_tipo == 'Entrada')
                    <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ number_format($ig->inshis_cantidad, 2, '.', ',') }}</td>
                @else
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">-</td>
                @endif

                @if($ig->inshis_detorprod_id != null)
                    <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ number_format($ig->inshis_cantidad, 2, '.', ',')  }}</td>
                    
                @else
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">-</td>
          
				@endif
				
				@php
					if($ig->inshis_tipo == 'Entrada')
					{
						$saldo += $ig->inshis_cantidad; 
					}else{
						$saldo -= $ig->inshis_cantidad; 
					}
						
				@endphp
				<td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ number_format($saldo, 2, '.', ',')}}</td>

            </tr>
        @endforeach
       
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
