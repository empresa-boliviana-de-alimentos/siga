@extends('backend.template.app')
<style type="text/css" media="screen">
        table {
    border-collapse: separate;
    border-spacing: 0 5px;
    }
    thead th {
      background-color:#428bca;
      color: white;
    }
    tbody td {
      background-color: #EEEEEE;
    }
</style>
@section('main-content')
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-2">
                
            </div>
            <div class="col-md-7 text-center">
                <p class="panel-title">SOLICITUD PEDIDO PUNTO VENTA</p>
            </div>
            <div class="col-md-3 text-right">
                <a href="{{url('NuevaSolicitudPedidoPv')}}" class="btn btn-default btn-xs" style="background: #616A6B;">
                        <h6 style="color: white;"><i class="fa fa-plus">
                    </i>&nbsp;REALIZAR NUEVA SOLICITUD</h6>
                </a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border"></div>
                    <div class="box-body">
                        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-solPediPv">
                            <thead class="cf">
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th class="text-center">
                                        NRO SOLICITUD
                                    </th>
                                    <th class="text-center">
                                        REPORTE SOLICITUD
                                    </th>
                                    <th class="text-center">
                                        FECHA SOLICITUD
                                    </th>
                                    <th class="text-center">
                                        CANTIDAD PRODUCTO
                                    </th>
                                    <th class="text-center">
                                        OBSERVACIONES
                                    </th>
                                    <th class="text-center">
                                        ESTADO
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $nro=0; ?>
                            @foreach($solproductos as $solproducto)
                                <?php $nro=$nro+1; ?>
                            	<tr>
                            		<td class="text-center">
                                        {{$nro}}
                                    </td>
                                    <td class="text-center">
                                        {{$solproducto->solpv_nro_solicitud}}
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-primary" target="_blank" href="ImprimirSolpv/{{$solproducto->solpv_id}}"><i class="fa fa-file"></i></a>
                                    </td>
                                    <td class="text-center">
                                        {{date('d-m-Y',strtotime($solproducto->solpv_registrado))}}
                                    </td>
                                    <td class="text-center">
                                        {{cantidadProductos($solproducto->solpv_id)}}
                                    </td>
                                    <td class="text-center">
                                        {{$solproducto->solpv_obs}}
                                    </td>
                                    <td class="text-center">
                                        {{$solproducto->solpv_descripestado_recep}}
                                    </td>
                            	</tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th class="text-center">
                                        NRO SOLICITUD
                                    </th>
                                    <th class="text-center">
                                        REPORTE SOLICITUD
                                    </th>
                                    <th class="text-center">
                                        FECHA SOLICITUD
                                    </th>
                                    <th class="text-center">
                                        CANTIDAD PRODUCTO
                                    </th>
                                    <th class="text-center">
                                        OBSERVACIONES
                                    </th>
                                    <th class="text-center">
                                        ESTADO
                                    </th>
                                </tr>
                            </tfoot>
                            <tr>
                            </tr>
                    </table>
                </div>
            </div>
    </div>
</div>
    </div>
</div>
<?php 
function cantidadProductos($id)
{
    $cantidadProductos = \DB::table('comercial.detalle_solicitud_pv_comercial')->where('detsolpv_solpv_id',$id)->get();
    //dd($cantidadProductos);
    $cantidad = 0;
    foreach ($cantidadProductos as $cp) {
        $cantidad = $cantidad + $cp->detsolpv_cantidad;
    }
    return $cantidad;
}
 ?>
@endsection
@push('scripts')
<script>
var t = $('#lts-orprod').DataTable( {

         "processing": true,
            "serverSide": true,
            "ajax": "/OrdenProduccion/create/",
            "columns":[
                {data: 'orprod_id'},
                {data: 'acciones',orderable: false, searchable: false},
                {data: 'orprod_registrado'},
                {data: 'nombre_planta'},
                {data: 'nombreReceta'},
                {data: 'umed_nombre'},
                {data: 'lineaProduccion'},
                {data: 'orprod_cantidad'},
                {data: 'orprod_estado_recep'},
                {data: 'estadoAprobacion'},
                // {data: 'sol_id'},
        ],
        "order": [[ 0, "desc" ]],
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

    });

    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
</script>
@endpush

