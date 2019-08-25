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

            <td colspan="3" class="px-15 py text-center text-xxs">
                Entrada
            </td>
            <td colspan="3" class="px-15 py text-center text-xxs">
                Salida
            </td>
            <td colspan="3" class="px-15 py text-center text-xxs">
                Saldo
            </td>
        </tr>
        <tr class="font-medium text-white text-sm">
            <td class="px-15 py text-center  text-xxs"></td>
            <td class="px-15 py text-center  text-xxs"></td>
            <td class="px-15 py text-center  text-xxs"></td>
            <td class="px-15 py text-center  text-xxs">Cant.</td>
            <td class="px-15 py text-center  text-xxs">C.U.</td>
            <td class="px-15 py text-center  text-xxs">Total </td>
            <td class="px-15 py text-center  text-xxs">Cant.</td>
            <td class="px-15 py text-center  text-xxs">C.U.</td>
            <td class="px-15 py text-center  text-xxs">Total </td>
            <td class="px-15 py text-center  text-xxs">Cant.</td>
            <td class="px-15 py text-center  text-xxs">C.U.</td>
            <td class="px-15 py text-center  text-xxs">Total </td>

        </tr>
    </thead>
    <tbody>
		 @php
			$count=1;	 
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
                    <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ $ig->inshis_cantidad  }}</td>
                    <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ $ig->deting_costo }}</td>
                    <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ number_format($ig->inshis_cantidad * $ig->deting_costo, 2, '.', ',')}}</td>
                @else
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">-</td>
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">-</td>
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">-</td>
                @endif

                @if($ig->inshis_detorprod_id != null)
                    <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ $ig->inshis_cantidad  }}</td>
                    <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ $ig->deting_costo }}</td>
                    <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ number_format($ig->inshis_cantidad * $ig->deting_costo, 2, '.', ',')}}</td>
                @else
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">-</td>
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">-</td>
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">-</td>
                @endif

                @if($ig->inshis_tipo == 'Entrada')
                    <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ $ig->inshis_cantidad }}</td>
                    <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ $ig->deting_costo }}</td>
                    <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ number_format($ig->inshis_cantidad * $ig->deting_costo, 2, '.', ',')}}</td>
                @else
					@php
						$detalle_ingreso = $detallesIngresos->where('deting_id',$ig->inshis_deting_id)->first();
						$detalle_orp = DB::table('insumo.detalle_orden_produccion')->where('detorprod_id', $ig->inshis_detorprod_id)->first();
						
						if ($detalle_orp->detorprod_cantidad > $detalle_ingreso->deting_cantidad) 
						{
							$det_nro = 0;
						} else {
							$detalle_ingreso->deting_cantidad = $detalle_ingreso->deting_cantidad - $ig->inshis_cantidad;
							$det_nro = $detalle_ingreso->deting_cantidad;
						}
					@endphp
                    <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ number_format($det_nro, 2, '.', ',')}}</td>
                    <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ $ig->deting_costo }}</td>
                    <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ number_format($det_nro * $ig->deting_costo, 2, '.', ',') }}</td>
                    {{-- @if($item->quantity_desc >= $item->article_request_item->quantity_apro )
                        <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ 0}}</td>
                        <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ $item->article_income_item->cost }}</td>
                        <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ 0* $item->article_income_item->cost }}</td>
                    @else

                        <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ $item->article_request_item->quantity_apro-= $item->quantity_desc }}</td>
                        <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ $item->article_income_item->cost }}</td>
                        <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ $item->article_request_item->quantity_apro * $item->article_income_item->cost }}</td>
                    @endif --}}
                @endif

            </tr>
        @endforeach
        {{-- @foreach ($stocks as $stock)
        <tr class="text-sm bg-grey-darker  text-white">
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ $count++ }}</td>
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{Carbon\Carbon::parse($stock->created_at, 'UTC')->format('d-m-Y')}}</td>
                <td class="text-center text-xxxs font-bold px-5 py-3">{{ 'Entrada (NIº'.$stock->article_income_item->article_income->correlative.')' }}</td>
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ $stock->quantity }}</td>
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ $stock->cost }}</td>
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ $stock->quantity * $stock->cost}}</td>
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">-</td>
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">-</td>
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">-</td>
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ $stock->quantity }}</td>
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ $stock->cost }}</td>
                <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ $stock->quantity * $stock->cost}}</td>
        </tr>

        @endforeach --}}
    </tbody>
</table>
{{-- <br>
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
        @php
         $total_quantity=0;
         $total_cost=0;
         $total_amount=0;
         $count = 1;
        @endphp
        @foreach ($stocks as $index => $stock)
        <tr class="text-sm">
            <td class="text-center text-xxs uppercase font-bold px-5 py-3" >{{ $count++ }}</td>
            <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{Carbon\Carbon::parse($stock->updated_at, 'UTC')->format('d-m-Y')}}</td>
            <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ $stock->quantity }}</td>
            <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ $stock->cost }}</td>
            <td class="text-center text-xxs uppercase font-bold px-5 py-3">{{ $stock->quantity * $stock->cost}}</td>
            @php
              $total_quantity += $stock->quantity;
              $total_cost += $stock->cost;
              $total_amount +=  $stock->quantity * $stock->cost;
            @endphp
        </tr>
        @endforeach
        <tr class="text-sm">
            <td colspan="2" class="text-center text-xxs uppercase font-bold px-5 py-3 bg-grey-darker text-white" >TOTAL:</td>
            <td class="text-center text-xxs uppercase font-bold px-5 py-3" >{{ $total_quantity }}</td>
            <td class="text-center text-xxs uppercase font-bold px-5 py-3" >-</td>
            <td class="text-center text-xxs uppercase font-bold px-5 py-3" >{{ $total_amount }}</td>
        </tr>
    </tbody>
</table> --}}


<br>
<br>
<br>
<br>
<br>
<table>
    <tr>
        <td class="text-center text-xxs">Solicitado por firma: ............................................</td>
        <td class="text-center text-xxs">Autorizado por firma: ............................................</td>
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
