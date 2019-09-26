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
                <p class="panel-title">RECEPCIÓN ORDEN DE PRODUCCIÓN RECETA</p>
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
                                        FECHA SOLICITUD
                                    </th>
                                    <th class="text-center">
                                        FECHA ENVIO ALMACEN
                                    </th>
                                    <th class="text-center">
                                        PRODUCTO PRODUCIR
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
                                        ESTADO
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
                                <td class="text-center">
                                @if($orp->sab_id == 1)
                                    {{$orp->rece_nombre.' '.$orp->rece_presentacion}}
                                @else
                                    {{$orp->rece_nombre.' '.$orp->sab_nombre.' '.$orp->rece_presentacion}}
                                @endif
                                </td>
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
                                @if($orp->orprod_estado_orp=='C')
                                    <div class="text-center"><a href="BoletaOrdenProduccionSolalorp/{{$orp->orprod_id}}" target="_blank"><img src="img/visualizar.jpg" width="50px"></a></div>
                                @elseif($orp->orprod_estado_orp=='B')
                                    <div class="text-center"><a href="frmSoliORP/{{$orp->orprod_id}}" class="btncirculo btn-success"><i class="fa fa-edit"></i> VER</a><div>
                                @elseif($orp->orprod_estado_orp == 'D')
                                    <div class="text-center"><a href="BoletaOrdenProduccionSolalorp/{{$orp->orprod_id}}" target="_blank"><img src="img/visualizar.jpg" width="50px"></a></div>
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
                                        FECHA SOLICITUD
                                    </th>
                                    <th class="text-center">
                                        FECHA ENVIO ALMACEN
                                    </th>
                                    <th class="text-center">
                                        PRODUCTO PRODUCIR
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

@endsection
@push('scripts')
<script>
/*var t = $('#lts-orprod').DataTable( {

         "processing": true,
            "serverSide": true,
            "ajax": "/CreateSolicitudOrp",
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
                {data: 'acciones',orderable: false, searchable: false},
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

