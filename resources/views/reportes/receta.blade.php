@extends('layouts.print')

@section('content')

<table class="table-info align-top no-padding no-margins border">
    <tr>
        <td class="text-center bg-grey-darker text-xs text-white ">Nombre del Producto:</td>
        <td colspan="3" class="text-xs uppercase">{{$receta->rece_nombre}}</td>
        <td class="text-center bg-grey-darker text-xs text-white ">Sublinea:</td>
        <td colspan="3" class="text-xs uppercase">{{$receta->sublin_nombre}}</td>
    </tr>
    <tr>
        <td  class="text-center bg-grey-darker text-xs text-white">Sabor:</td>
        <td colspan="3" class="text-xs uppercase">{{$receta->sab_nombre}}</td>
        <td  class="text-center bg-grey-darker text-xs text-white">Unidad de Medida:</td>
        <td colspan="3" class="text-xs uppercase">{{$receta->umed_nombre}}</td>
    </tr>
    <tr>
        <td  class="text-center bg-grey-darker text-xs text-white">Presentación:</td>
        <td class="text-xs uppercase">{{$receta->rece_presentacion}}</td>
        <td  class="text-center bg-grey-darker text-xs text-white">Peso Producto total </td>
        <td class="text-xs uppercase">{{$receta->rece_prod_total}}</td>
        <td  class="text-center bg-grey-darker text-xs text-white">Cantidad Base </td>
        <td class="text-xs uppercase">{{$receta->rece_rendimiento_base}}</td>
    </tr>

</table>
@if($receta->rece_lineaprod_id==1)
<table>
    <tr>
        <td colspan="3" class="text-xs text-center uppercase"> <strong> CARACTERISTICAS ENVASADO </strong> </td>
    </tr>
</table>
<table class="table-info align-top no-padding no-margins border">
    <tr>
        <td class="text-center bg-grey-darker text-xs text-white ">Densidad:</td>
        <td colspan="3" class="text-xs uppercase">{{$datos_json->densidad}}</td>
        <td class="text-center bg-grey-darker text-xs text-white ">Volumen Recipiente:</td>
        <td colspan="3" class="text-xs uppercase">{{$datos_json->vol_recipiente}}</td>
        <td class="text-center bg-grey-darker text-xs text-white ">Peso Mezcla:</td>
        <td colspan="3" class="text-xs uppercase">{{$datos_json->peso_mezcla}}</td>
    </tr>
    <tr>
        <td  class="text-center bg-grey-darker text-xs text-white">Peso Botella:</td>
        <td colspan="3" class="text-xs uppercase">{{$datos_json->peso_botella}}</td>
        <td  class="text-center bg-grey-darker text-xs text-white">Peso Tapa:</td>
        <td colspan="6" class="text-xs uppercase">{{$datos_json->peso_tapa}}</td>
    </tr>

</table>
@endif
@if($receta->rece_lineaprod_id==2 OR $receta->rece_lineaprod_id==3)
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
                    $insumo_insumo = siga\Modelo\insumo\insumo_recetas\DetalleReceta::join('insumo.insumo as ins','insumo.detalle_receta.detrece_ins_id','=','ins.ins_id')
                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                        ->where('ins_id_tip_ins',1)
                                                        ->where('detrece_rece_id',$receta->rece_id)->get();
                    $insumo_matprima = siga\Modelo\insumo\insumo_recetas\DetalleReceta::join('insumo.insumo as ins','insumo.detalle_receta.detrece_ins_id','=','ins.ins_id')
                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                        ->where('ins_id_tip_ins',3)
                                                        ->where('detrece_rece_id',$receta->rece_id)->get();
                    foreach ($insumo_insumo as $ins) {
                        $detalle_formulacion[] = array("ins_desc"=>$ins->ins_desc, "umed_nombre"=>$ins->umed_nombre, "detrece_cantidad"=>$ins->detrece_cantidad);
                    }
                    foreach ($insumo_matprima as $ins) {
                        $detalle_formulacion[] = array("ins_desc"=>$ins->ins_desc, "umed_nombre"=>$ins->umed_nombre, "detrece_cantidad"=>$ins->detrece_cantidad);
                    }
                    $nro = 1;
                @endphp
                @foreach($detalle_formulacion as $detform)
                <tr class="text-sm">
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $nro++ }}</td>
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform['ins_desc']}}</td>
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform['umed_nombre'] }}</td>
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform['detrece_cantidad'] }}</td>
                </tr>
                @endforeach
        </tbody>
    </table>
@endif

@if($receta->rece_lineaprod_id==1 OR $receta->rece_lineaprod_id == 4 OR $receta->rece_lineaprod_id == 5)
    <table>
        <tr>
            <td colspan="3" class="text-xs text-center uppercase"> <strong> Rendimiento Base </strong> </td>
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
                    $insumo_insumo = siga\Modelo\insumo\insumo_recetas\DetalleReceta::join('insumo.insumo as ins','insumo.detalle_receta.detrece_ins_id','=','ins.ins_id')
                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                        ->where('ins_id_tip_ins',1)
                                                        ->where('detrece_rece_id',$receta->rece_id)->get();
                    $insumo_matprima = siga\Modelo\insumo\insumo_recetas\DetalleReceta::join('insumo.insumo as ins','insumo.detalle_receta.detrece_ins_id','=','ins.ins_id')
                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                        ->where('ins_id_tip_ins',3)
                                                        ->where('detrece_rece_id',$receta->rece_id)->get();
                    foreach ($insumo_insumo as $ins) {
                        $detalle_formulacion[] = array("ins_desc"=>$ins->ins_desc, "umed_nombre"=>$ins->umed_nombre, "detrece_cantidad"=>$ins->detrece_cantidad);
                    }
                    foreach ($insumo_matprima as $ins) {
                        $detalle_formulacion[] = array("ins_desc"=>$ins->ins_desc, "umed_nombre"=>$ins->umed_nombre, "detrece_cantidad"=>$ins->detrece_cantidad);
                    }
                    //dd($detalle_formulacion);
                    $nro = 1;
                @endphp
                @foreach($detalle_formulacion as $detform)
                <tr class="text-sm">
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $nro++ }}</td>
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform['ins_desc']}}</td>
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform['umed_nombre'] }}</td>
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform['detrece_cantidad'] }}</td>
                </tr>
                @endforeach
        </tbody>
    </table>
@endif
@if($receta->rece_lineaprod_id==1 OR $receta->rece_lineaprod_id == 4 OR $receta->rece_lineaprod_id == 5)
    <table>
        <tr>
            <td colspan="3" class="text-xs text-center uppercase"> <strong> Rendimiento Base </strong> </td>
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
                    $insumo_insumo = siga\Modelo\insumo\insumo_recetas\DetalleReceta::join('insumo.insumo as ins','insumo.detalle_receta.detrece_ins_id','=','ins.ins_id')
                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                        ->where('ins_id_tip_ins',1)
                                                        ->where('detrece_rece_id',$receta->rece_id)->get();
                    $insumo_matprima = siga\Modelo\insumo\insumo_recetas\DetalleReceta::join('insumo.insumo as ins','insumo.detalle_receta.detrece_ins_id','=','ins.ins_id')
                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                        ->where('ins_id_tip_ins',3)
                                                        ->where('detrece_rece_id',$receta->rece_id)->get();
                    foreach ($insumo_insumo as $ins) {
                        $detalle_formulacion[] = array("ins_desc"=>$ins->ins_desc, "umed_nombre"=>$ins->umed_nombre, "detrece_cantidad"=>$ins->detrece_cantidad);
                    }
                    foreach ($insumo_matprima as $ins) {
                        $detalle_formulacion[] = array("ins_desc"=>$ins->ins_desc, "umed_nombre"=>$ins->umed_nombre, "detrece_cantidad"=>$ins->detrece_cantidad);
                    }
                    //dd($detalle_formulacion);
                    $nro = 1;
                @endphp
                @foreach($detalle_formulacion as $detform)
                <tr class="text-sm">
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $nro++ }}</td>
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform['ins_desc']}}</td>
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform['umed_nombre'] }}</td>
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform['detrece_cantidad'] }}</td>
                </tr>
                @endforeach
        </tbody>
    </table>
@endif
@if($receta->rece_lineaprod_id==1 OR $receta->rece_lineaprod_id == 4 OR $receta->rece_lineaprod_id == 5)
    <table>
        <tr>
            <td colspan="3" class="text-xs text-center uppercase"> <strong> SABORIZACIÓN </strong> </td>
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
                    $detalle_formulacion = siga\Modelo\insumo\insumo_recetas\DetalleReceta::join('insumo.insumo as ins','insumo.detalle_receta.detrece_ins_id','=','ins.ins_id')
                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                        ->where('detrece_rece_id',$receta->rece_id)
                                                        ->where('ins_id_tip_ins',4)->get();
                    $nro = 1;
                @endphp
                @foreach($detalle_formulacion as $detform)
                <tr class="text-sm">
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $nro++ }}</td>
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform->ins_desc}}</td>
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform->umed_nombre }}</td>
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform->detrece_cantidad }}</td>
                </tr>
                @endforeach
        </tbody>
    </table>
@endif

<table>
    <tr>
        <td colspan="3" class="text-xs text-center uppercase"> <strong> MATERIAL ENVASADO </strong> </td>
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
                $detalle_formulacion = siga\Modelo\insumo\insumo_recetas\DetalleReceta::join('insumo.insumo as ins','insumo.detalle_receta.detrece_ins_id','=','ins.ins_id')
                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                        ->where('detrece_rece_id',$receta->rece_id)
                                                        ->where('ins_id_tip_ins',2)->get();
                $nro = 1;
            @endphp
            @foreach($detalle_formulacion as $detform)
            <tr class="text-sm">
                <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $nro++ }}</td>
                <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform->ins_desc}}</td>
                <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform->umed_nombre }}</td>
                <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform->detrece_cantidad }}</td>
            </tr>
            @endforeach
    </tbody>
</table>
@if($receta->rece_lineaprod_id == 1)
    <table>
        <tr>
            <td colspan="3" class="text-xs text-center uppercase"> <strong> PARAMETRO FISICO QUIMICO </strong> </td>
        </tr>
    </table>
    <table class="table-info align-top no-padding no-margins border">
        <tr>
            <td class="text-center bg-grey-darker text-xs text-white "></td>
            <td class="text-center bg-grey-darker text-xs text-white ">Lie</td>
            <td class="text-center bg-grey-darker text-xs text-white ">Lse</td>
        </tr>
        <tr>
            <td  class="text-center bg-grey-darker text-xs text-white">Solidez:</td>
            <td  class="text-xs uppercase">{{$datos_json->solides_lie}}</td>
            <td  class="text-xs uppercase">{{$datos_json->solides_lse}}</td>
        </tr>
        <tr>
            <td  class="text-center bg-grey-darker text-xs text-white">Acidez (%AI.):</td>
            <td  class="text-xs uppercase">{{$datos_json->acidez_lie}}</td>
            <td  class="text-xs uppercase">{{$datos_json->acidez_lse}}</td>
        </tr>
        <tr>
            <td  class="text-center bg-grey-darker text-xs text-white">Ph (-):</td>
            <td  class="text-xs uppercase">{{$datos_json->ph_lie}}</td>
            <td  class="text-xs uppercase">{{$datos_json->ph_lse}}</td>
        </tr>
        <tr>
            <td  class="text-center bg-grey-darker text-xs text-white">Viscosidad (seg) a 10°C:</td>
            <td  class="text-xs uppercase">{{$datos_json->viscosidad_lie}}</td>
            <td  class="text-xs uppercase">{{$datos_json->viscosidad_lse}}</td>
        </tr>
        <tr>
            <td  class="text-center bg-grey-darker text-xs text-white">Densidad:</td>
            <td  class="text-xs uppercase">{{$datos_json->densidad_lie}}</td>
            <td  class="text-xs uppercase">{{$datos_json->densidad_lse}}</td>
        </tr>

    </table>
@endif
<br>
<br>
<br>
<br>
<table>
    <tr>
        <td class="text-center text-xxs">......................................</td>
    </tr>
    <tr>
        <td class="text-center text-xxs">Jefe de Produccion</td>
    </tr>

</table>

@endsection
