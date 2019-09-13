@extends('layouts.print')

@section('content')

<table class="table-info align-top no-padding no-margins border">
    <tr>
        <td class="text-center bg-grey-darker text-xs text-white ">Nombre del Producto:</td>
        <td colspan="6" class="text-xs uppercase">{{$devolucion->rece_nombre.' '.$devolucion->sab_nombre.' '.$devolucion->rece_presentacion.' '.$devolucion->umed_nombre}}</td>
        <td class="text-center bg-grey-darker text-xs text-white ">No. Orden Producción:</td>
        <td colspan="3" class="text-xs uppercase">{{$devolucion->orprod_nro_orden}}</td>
    </tr>
    <tr>
        <td  class="text-center bg-grey-darker text-xs text-white">Cantidad a Producir:</td>
        <td colspan="3" class="text-xs uppercase">{{$devolucion->orprod_cantidad}}</td>
        <td  class="text-center bg-grey-darker text-xs text-white">Planta:</td>
        <td colspan="3" class="text-xs uppercase">{{$devolucion->nombre_planta}}</td>
        <td  class="text-center bg-grey-darker text-xs text-white">Mercado:</td>
        <td colspan="3" class="text-xs uppercase">{{$devolucion->mer_nombre}}</td>
    </tr>

</table>

    <table>
        <tr>
            <td colspan="3" class="text-xs text-center uppercase"> <strong> MATERIA PRIMA</strong> </td>
        </tr>
    </table>
    <table class="table-info w-100">
        <thead class="bg-grey-darker">
            <tr class="font-medium text-white text-sm">
                <td class="px-15 py text-center text-xxs ">
                    Nro.
                </td>
                <td class="px-15 py text-center  text-xxs">
                    Insumo
                </td>
                <td class="px-15 py text-center text-xxs">
                    Unidad de Medida
                </td>
                <td class="px-15 py text-center text-xxs">
                    Cantidad
                </td>
            </tr>
        </thead>
        <tbody>


                @php
                    $detorp = siga\Modelo\insumo\insumo_devolucion\DetalleDevolucion::join('insumo.insumo as ins','insumo.detalle_devolucion.detdevo_ins_id','=','ins.ins_id')->join('insumo.unidad_medida as umed','ins.ins_id_uni','=','umed.umed_id')->where('detdevo_devo_id',$devolucion->devo_id)->get();
                    $nro = 1;
                @endphp
                @foreach($detorp as $detform)
                <tr class="text-sm">
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $nro++ }}</td>
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform->ins_desc}}</td>
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform->umed_nombre }}</td>
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform->detdevo_cantidad }}</td>
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
        <td class="text-center text-xxs">......................................</td>
        <td class="text-center text-xxs">.....................................................</td>
    </tr>
    <tr>
        <td class="text-center text-xxs">Jefe de Produccion</td>
        <td class="text-center text-xxs">Encargado de Produccion Planta</td>
    </tr>

</table> 
@endsection
