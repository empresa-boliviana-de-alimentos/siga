@extends('backend.template.app')
<style type="text/css" media="screen">
        table {
    border-collapse: separate;
    border-spacing: 0 5px;
    }
    thead th {
      background-color:#202040;
      color: white;
      font-size: 12px;
    }
    tbody td {
      background-color: #EEEEEE;
      font-size: 10px;
    }
    tfoot th {
      background-color:#202040;
      color: white;
      font-size: 12px;
    }
</style>
@section('main-content')
<div class="panel panel-primary">
    <div class="panel-heading" style="background-color: #202040">
        <div class="row">
            <div class="col-md-2">
                <a type="button" class="btn btn-danger fa fa-arrow-left" href="{{ url('InsumoSolicitudesMenu') }}"></span><h7 style="color:#ffffff">&nbsp;&nbsp;VOLVER</h7></a>
            </div>
            <div class="col-md-7 text-center">
                <p class="panel-title">ORDEN DE PRODUCCIÓN</p>
            </div>
            <div class="col-md-3 text-right">
                <a href="{{url('RegistroOrdenProd')}}" class="btn btn-default btn-xs" style="background: #616A6B;">
                        <h6 style="color: white;"><i class="fa fa-plus">
                    </i>&nbsp;REALIZAR NUEVO PEDIDO</h6>
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
                        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-orprod" style="width: 100%">
                            <thead class="cf">
                                <tr>
                                    <th class="text-center">
                                        #
                                    </th>
                                    <th class="text-center">
                                        VER
                                    </th>
                                    <th class="text-center">
                                        CODIGO ORP
                                    </th>
                                    <th class="text-center">
                                        FECHA SOLICITUD
                                    </th>
                                    <th class="text-center">
                                        PLANTA A PRODUCIR
                                    </th>
                                    <th class="text-center">
                                        PRODUCTO A PRODUCIR
                                    </th>
                                    <th class="text-center">
                                        UNIDAD MEDIDA
                                    </th>
                                    <th class="text-center">
                                        LINEA PRODUCCIÓN
                                    </th>
                                    <th class="text-center">
                                        CANTIDAD PRODUCIR
                                    </th>
                                    <th class="text-center">
                                        ESTADO RECEPCIÓN
                                    </th>
                                    <th class="text-center">
                                        RECEPCIONADO
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $nro = 0; ?>
                            @foreach($orden_produccion as $orp)
                            <?php $nro = $nro + 1; ?>
                                <tr>
                                    <td class="text-center">{{$nro}}</td>
                                    <td class="text-center">
                                        <div class="text-center"><a href="BoletaOrdenProduccion/{{$orp->orprod_id}}" target="_blank"><img src="img/visualizar.jpg" width="50px"></a></div>
                                    </td>
                                    <td class="text-center">{{$orp->orprod_nro_orden}}</td>
                                    <td class="text-center">{{$orp->orprod_registrado}}</td>
                                    <td class="text-center">{{$orp->nombre_planta}}</td>
                                    <td class="text-center">{{$orp->rece_nombre.' '.$orp->sab_nombre.' '.$orp->rece_presentacion}}</td>
                                    <td class="text-center">{{$orp->umed_nombre}}</td>
                                    <td class="text-center">{{linea($orp->rece_lineaprod_id)}}</td>
                                    <td class="text-center">{{$orp->orprod_cantidad}}</td>
                                    <td class="text-center">{{$orp->orprod_estado_recep}}</td>
                                    <td class="text-center">
                                        @if ($orp->orprod_estado_orp == 'A') 
                                            {{traeUser($orp->orprod_usr_id)}}
                                        @elseif($orp->orprod_estado_orp == 'B')
                                            {{traeUser($orp->orprod_usr_vo)}}
                                        @elseif($orp->orprod_estado_orp == 'C') 
                                            {{traeUser($orp->orprod_usr_vodos)}}
                                        @elseif($orp->orprod_estado_orp == 'D')
                                            {{traeUser($orp->orprod_usr_aprob)}}
                                        @endif
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
                                        VER
                                    </th>
                                    <th class="text-center">
                                        CODIGO ORP
                                    </th>
                                    <th class="text-center">
                                        FECHA SOLICITUD
                                    </th>
                                    <th class="text-center">
                                        PLANTA A PRODUCIR
                                    </th>
                                    <th class="text-center">
                                        PRODUCTO A PRODUCIR
                                    </th>
                                    <th class="text-center">
                                        UNIDAD MEDIDA
                                    </th>
                                    <th class="text-center">
                                        LINEA PRODUCCIÓN
                                    </th>
                                    <th class="text-center">
                                        CANTIDAD PRODUCIR
                                    </th>
                                    <th class="text-center">
                                        ESTADO RECEPCIÓN
                                    </th>
                                    <th class="text-center">
                                        RECEPCIONADO
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
function linea($id)
{
    if($id == 1){
        return "LACTEOS";
    }elseif($id == 2){
        return "ALAMENDRA";
    }elseif($id == 3){
        return "MIEL";
    }elseif($id == 4){
        return "FRUTOS";
    }elseif($id == 5){
        return "DERIVADOS";
    }
}
function traeUser($id_user)
{
    $user_datos = \DB::table('public._bp_usuarios')->join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                             ->where('usr_id',$id_user)
                             ->first();
    return $user_datos->prs_nombres.' '.$user_datos->prs_paterno.' '.$user_datos->prs_materno;
}
?>
@endsection
@push('scripts')
<script>
/*var t = $('#lts-orprod').DataTable( {

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
    } ).draw();*/
$('#lts-orprod').DataTable( {
    "responsive": true,
    "order": [[ 0, "asc" ]],
    "language": {
        "url": "/lenguaje"
    },
    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
});
</script>
@endpush

