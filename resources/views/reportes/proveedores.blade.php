@extends('layouts.print')

@section('content')

<table class="table-info w-100">
    <thead class="bg-grey-darker">
        <tr class="font-medium text-white text-sm">
            <td class="px-15 py text-center text-xxs ">
                Nro.
            </td>
            <td class="px-15 py text-center  text-xxs">
                Proveedor
            </td>
            <td class="px-15 py text-center text-xxs">
                Total
            </td>
            <td class="px-15 py text-center text-xxs">
                Puntos
            </td>
            <td class="px-15 py text-center text-xxs">
                Porcentaje
            </td>
        </tr>
    </thead>
    <tbody>

        @foreach ($evaluaciones as $index=>$item)
            @php
                $total_puntaje = $item->eval_costo_apro+$item->eval_fiabilidad+$item->eval_imagen+$item->eval_calidad+$item->eval_cumplimientos_plazos+$item->eval_condiciones_pago+$item->eval_capacidad_cooperacion+$item->eval_flexibilidad;
                $total_puntos = $total_puntaje/100;
                $total_porcentaje = ($total_puntos/5)*100;
            @endphp
            <tr class="text-sm">
                <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $index++ }}</td>
                <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{  Carbon\Carbon::parse($item->created_at, 'UTC')->format('d-m-Y') }}</td>
                <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $total_puntaje }}</td>
                <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $total_puntos }}</td>
                <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $total_porcentaje }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
{{-- <br>
<br>
<br>
<br> --}}
{{-- <table>
    <tr>
        <td class="text-right text-xxs">Revisado por firma</td>
        <td class="text-left text-xxs">  .......................................</td>
        <td class="text-right text-xxs">Verificado por firma</td>
        <td class="text-left text-xxs">  .......................................</td>
    </tr>

</table> --}}
{{-- <br>
<table>
    <tr>
        <td class="text-right text-xxs">Nombre</td>
        <td class="text-left text-xxs">  .......................................</td>
        <td class="text-right text-xxs">Nombre</td>
        <td class="text-left text-xxs">  .......................................</td>
    </tr>
</table> --}}
@endsection
