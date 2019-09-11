@extends('layouts.print')

@section('content')
<table class="table-info align-top no-padding no-margins border">
    <tr>
        <td class="text-center bg-grey-darker text-xs text-white ">Solicitante:</td>
        <td colspan="6" class="text-xs uppercase">{{$solpv->prs_nombres.' '.$solpv->prs_paterno.' '.$solpv->prs_materno}}</td>
        <td class="text-center bg-grey-darker text-xs text-white ">No. Solicitud:</td>
        <td colspan="3" class="text-xs uppercase">{{$solpv->solpv_nro_solicitud}}</td>
    </tr>
</table>

    <table>
        <tr>
            <td colspan="3" class="text-xs text-center uppercase"> <strong> PRODUCTOS A SOLICITAR</strong> </td>
        </tr>
    </table>
    <table class="table-info w-100">
        <thead class="bg-grey-darker">
            <tr class="font-medium text-white text-sm">
                <td class="px-15 py text-center text-xxs ">
                    Nro.
                </td>
                <td class="px-15 py text-center text-xxs ">
                    Codigo
                </td>
                <td class="px-15 py text-center  text-xxs">
                    Producto
                </td>
                <td class="px-15 py text-center text-xxs">
                    Cantidad Solicitada
                </td>
            </tr>
        </thead>
        <tbody>
            @php
                    $detsol = siga\Http\Modelo\comercial\DetalleSolicitudPv::join('comercial.producto_comercial as prod','comercial.detalle_solicitud_pv_comercial.detsolpv_prod_id','=','prod.prod_id')
                    ->join('insumo.receta as rece','prod.prod_rece_id','=','rece.rece_id')
                    ->join('insumo.sabor as sab','rece.rece_sabor_id','=','sab.sab_id')
                    ->where('detsolpv_solpv_id',$solpv->solpv_id)->get();
                    $nro = 1;
            @endphp
                @foreach($detsol as $det)
                <tr class="text-sm">
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $nro++ }}</td>
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $det->prod_codigo}}</td>
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">
                    @if($det->sab_id == 1)
                        {{ $det->rece_nombre}} {{$det->rece_presentacion}}
                    @else
                        {{ $det->rece_nombre }} {{$det->sab_nombre}} {{$det->rece_presentacion}}
                    @endif
                    </td>
                    <td class="text-center text-xxs uppercase font-bold px-1 py-1">{{ $det->detsolpv_cantidad }}</td>
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
        <td class="text-center text-xxs">Solicitante</td>
        <td class="text-center text-xxs">Encargado Mercado Abierto</td>
    </tr>

</table> 
@endsection
