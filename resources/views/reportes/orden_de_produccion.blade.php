@extends('layouts.print')

@section('content')

<table class="table-info align-top no-padding no-margins border">
    <tr>
        <td class="text-center bg-grey-darker text-xs text-white ">Nombre del Producto:</td>
        <td colspan="6" class="text-xs uppercase">{{$receta->rece_nombre.' '.$receta->sab_nombre.' '.$receta->rece_presentacion.' '.$receta->umed_nombre}}</td>
        <td class="text-center bg-grey-darker text-xs text-white ">No. Orden Producción:</td>
        <td colspan="3" class="text-xs uppercase">{{$receta->orprod_nro_orden}}</td>
    </tr>
    <tr>
        <td  class="text-center bg-grey-darker text-xs text-white">Cantidad a Producir:</td>
        <td colspan="3" class="text-xs uppercase">{{$receta->orprod_cantidad}}</td>
        <td  class="text-center bg-grey-darker text-xs text-white">Planta:</td>
        <td colspan="3" class="text-xs uppercase">{{$receta->nombre_planta}}</td>
        <td  class="text-center bg-grey-darker text-xs text-white">Mercado:</td>
        <td colspan="3" class="text-xs uppercase">{{$receta->mer_nombre}}</td>
    </tr>

</table>

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
                    $detalle_formulacion = siga\Modelo\insumo\insumo_solicitud\DetalleOrdenProduccion::join('insumo.insumo as ins','insumo.detalle_orden_produccion.detorprod_ins_id','=','ins.ins_id')
                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                        ->where('ins_id_tip_ins',3)
                                                        ->where('detorprod_orprod_id',$receta->orprod_id)->get();
                    $nro = 1;
                @endphp
                @foreach($detalle_formulacion as $detform)
                <tr class="text-sm">
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $nro++ }}</td>
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform->ins_desc}}</td>
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform->umed_nombre }}</td>
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform->detorprod_cantidad }}</td>
                </tr>
                @endforeach
        </tbody>
    </table>
@endif
@if($receta->rece_lineaprod_id==1 OR $receta->rece_lineaprod_id == 4 OR $receta->rece_lineaprod_id == 5)
	<table>
		<tr>
			<td colspan="3" class="text-xs text-center uppercase"> <strong>FORMULACIÓN DE LA BASE </strong> </td>
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
					$insumo_insumo = siga\Modelo\insumo\insumo_solicitud\DetalleOrdenProduccion::join('insumo.insumo as ins','insumo.detalle_orden_produccion.detorprod_ins_id','=','ins.ins_id')
                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                        ->where('ins_id_tip_ins',1)
                                                        ->where('detorprod_orprod_id',$receta->orprod_id)->get();
                    $insumo_matprima = siga\Modelo\insumo\insumo_solicitud\DetalleOrdenProduccion::join('insumo.insumo as ins','insumo.detalle_orden_produccion.detorprod_ins_id','=','ins.ins_id')
                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                        ->where('ins_id_tip_ins',3)
                                                        ->where('detorprod_orprod_id',$receta->orprod_id)->get();
                    foreach ($insumo_insumo as $ins) {
                        $detalle_formulacion[] = array("ins_desc"=>$ins->ins_desc, "umed_nombre"=>$ins->umed_nombre, "detorprod_cantidad"=>$ins->detorprod_cantidad);
                    }
                    foreach ($insumo_matprima as $ins) {
                        $detalle_formulacion[] = array("ins_desc"=>$ins->ins_desc, "umed_nombre"=>$ins->umed_nombre, "detorprod_cantidad"=>$ins->detorprod_cantidad);
                    }

					$nro = 1;
				@endphp
				@foreach($detalle_formulacion as $detform)
				<tr class="text-sm">
					<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $nro++ }}</td>
					<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform['ins_desc']}}</td>
					<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform['umed_nombre'] }}</td>
					<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform['detorprod_cantidad'] }}</td>
				</tr>
				@endforeach
		</tbody>
	</table>
@endif
@if( $receta->rece_lineaprod_id == 1 OR $receta->rece_lineaprod_id == 4 OR $receta->rece_lineaprod_id == 5)
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
					$detalle_formulacion = siga\Modelo\insumo\insumo_solicitud\DetalleOrdenProduccion::join('insumo.insumo as ins','insumo.detalle_orden_produccion.detorprod_ins_id','=','ins.ins_id')
                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                        ->where('detorprod_orprod_id',$receta->orprod_id)
                                                        ->where('ins_id_tip_ins',4)->get();

                    $nro = 1;

				@endphp
				@foreach($detalle_formulacion as $detform)
				<tr class="text-sm">
					<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $nro++ }}</td>
					<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform->ins_desc}}</td>
					<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform->umed_nombre }}</td>
					<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform->detorprod_cantidad}}</td>
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
					$detalle_formulacion = siga\Modelo\insumo\insumo_solicitud\DetalleOrdenProduccion::join('insumo.insumo as ins','insumo.detalle_orden_produccion.detorprod_ins_id','=','ins.ins_id')
                                                        ->join('insumo.unidad_medida as uni','ins.ins_id_uni','=','uni.umed_id')
                                                        ->where('detorprod_orprod_id',$receta->orprod_id)
                                                        ->where('ins_id_tip_ins',2)->get();
					$nro = 1;
				@endphp
				@foreach($detalle_formulacion as $detform)
				<tr class="text-sm">
					<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $nro++ }}</td>
					<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform->ins_desc}}</td>
					<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform->umed_nombre }}</td>
					<td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $detform->detorprod_cantidad }}</td>
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
