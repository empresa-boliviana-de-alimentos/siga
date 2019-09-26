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
                <a type="button" class="btn btn-danger fa fa-arrow-left"  href="{{ url('InsumoSolicitudesMenu') }}"></span><h7 style="color:#ffffff">&nbsp;&nbsp;VOLVER</h7></a>
            </div>
            <div class="col-md-7 text-center">
                <p class="panel-title">RECEPCIÓN ORDEN DE PRODUCCIÓN</p>
            </div>
            <div class="col-md-3 text-right">

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
                                        NRO ORP
                                    </th>
                                    <th class="text-center">
                                        FECHA ORP
                                    </th>
                                    <th>
                                        FECHA RECEPCIÓN
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
                                    <th class="text-center">
                                        OPCIONES
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $nro = 0; ?>
                            @foreach($orden_produccion as $orp)
                            <?php $nro = $nro + 1; ?>
                            <tr>
                                <td class="text-center">{{$nro}}</td>
                                <td class="text-center">{{$orp->orprod_nro_orden}}</td>
                                <td class="text-center">{{$orp->orprod_registrado}}</td>
                                <td class="text-center">{{$orp->orprod_modificado}}</td>
                                <td class="text-center">{{$orp->rece_nombre.' '.$orp->sab_nombre.' '.$orp->rece_presentacion}}</td>
                                <td class="text-center">{{$orp->umed_nombre}}</td>
                                <td class="text-center">
                                @if($orp->rece_lineaprod_id == 1) 
                                    LACTEOS
                                @elseif($orp->rece_lineaprod_id == 2)
                                    ALMENDRA
                                @elseif($orp->rece_lineaprod_id == 3)
                                    MIEL
                                @elseif($orp->rece_lineaprod_id == 4)
                                    FRUTOS
                                @elseif($orp->rece_lineaprod_id == 5)
                                    DERIVADOS
                                @endif
                                </td>
                                <td class="text-center">{{$orp->orprod_cantidad}}</td>
                                <td class="text-center">{{$orp->orprod_estado_recep}}</td>
                                <td class="text-center">
                                @if($orp->orprod_estado_orp == 'A')
                                    {{traeUser($orp->orprod_usr_id)}}
                                @elseif($orp->orprod_estado_orp == 'B')
                                    {{traeUser($orp->orprod_usr_vo)}}
                                @elseif($orp->orprod_estado_orp == 'C')
                                    {{traeUser($orp->orprod_usr_vodos)}}
                                @elseif($orp->orprod_estado_orp == 'D')
                                    {{traeUser($orp->orprod_usr_aprob)}}
                                @endif
                                </td>
                                <td class="text-center">
                                @if($orp->orprod_estado_orp == 'B')
                                    <div class="text-center"><a href="BoletaOrdenProduccionRorp/{{$orp->orprod_id}}" target="_blank"><img src="img/visualizar.jpg" width="50px"></a></div>
                                @elseif($orp->orprod_estado_orp == 'A')
                                    <div class="text-center"><a  onClick="CambiarEstado({{$orp->orprod_id}});" href="frmRecepORP/{{$orp->orprod_id}}" class="btncirculo btn-success btn-xs"><i class="fa fa-edit"></i> VER</a><div>
                                @elseif($orp->orprod_estado_orp == 'C')
                                    <div class="text-center"><a href="BoletaOrdenProduccionRorp/{{$orp->orprod_id}}" target="_blank"><img src="img/visualizar.jpg" width="50px"></a></div>
                                @elseif($orp->orprod_estado_orp == 'D')
                                    <div class="text-center"><a href="BoletaOrdenProduccionRorp/{{$orp->orprod_id}}" target="_blank"><img src="img/visualizar.jpg" width="50px"></a></div>
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
                                        NRO ORP
                                    </th>
                                    <th class="text-center">
                                        FECHA ORP
                                    </th>
                                    <th>
                                        FECHA RECEPCIÓN
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
                                    <th class="text-center">
                                        OPCIONES
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
            "ajax": "/CreateRecepcionOrp",
            "columns":[
                {data: 'orprod_id'},
                {data: 'orprod_nro_orden'},
                {data: 'orprod_registrado'},
                {data: 'orprod_modificado'},
                {data: 'nombreReceta'},
                {data: 'umed_nombre'},
                {data: 'lineaProduccion'},
                {data: 'orprod_cantidad'},
                {data: 'orprod_estado_recep'},
                {data: 'estadoAprobacion',orderable: false, searchable: false},
                {data: 'acciones'},
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
    function CambiarEstado(id)
    {
        //alert("CAMBIANDO EL ESTADO RECEPCION CON ID ORP: "+id);
        var route="CambioEstadoRecepOrp/"+id+"";
           $.ajax({
                url: route,
                type: 'GET',
                dataType: 'json',
                success: function(data){
                },
                error: function(result) {
                }
            });
    }
</script>
@endpush

