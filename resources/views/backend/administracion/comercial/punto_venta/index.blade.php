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
    tfoot th {
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
                <p class="panel-title">PUNTOS DE VENTA / SUCURSALES</p>
            </div>
            <div class="col-md-3 text-right">
                <a href="{{url('NuevoPuntoVenta')}}" class="btn btn-default btn-xs" style="background: #616A6B;">
                        <h6 style="color: white;"><i class="fa fa-plus">
                    </i>&nbsp;CREAR NUEVO PUNTO DE VENTA</h6>
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
                                        COD. SUC
                                    </th>
                                    <th class="text-center">
                                        NOMBRE
                                    </th>
                                    <th class="text-center">
                                        DESCRIPCIÓN
                                    </th>
                                    <th class="text-center">
                                        DEPARTAMENTO
                                    </th>
                                    <th class="text-center">
                                        ACTIVIDAD ECONÓMICA
                                    </th>
                                    <th class="text-center">
                                        TIPO
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($puntos_ventas as $punto_venta)
                            	<tr>
                            		<td class="text-center">
                                        {{ $punto_venta->pv_id}}
                                    </td>
                                    <td class="text-center">
                                        {{ $punto_venta->pv_codigo}}
                                    </td>
                                    <td class="text-center">
                                        {{ $punto_venta->pv_nombre }}
                                    </td>
                                    <td class="text-center">
                                        {{ $punto_venta->pv_descripcion }}
                                    </td>
                                    <td class="text-center">
                                        {{ $punto_venta->depto_nombre }}
                                    </td>
                                    <td class="text-center">
                                        {{ $punto_venta->pv_actividad_economica }}
                                    </td>
                                    <td class="text-center">
                                        {{ $punto_venta->pv_tipopv_id }}
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
                                        COD. SUC
                                    </th>
                                    <th class="text-center">
                                        NOMBRE
                                    </th>
                                    <th class="text-center">
                                        DESCRIPCIÓN
                                    </th>
                                    <th class="text-center">
                                        DEPARTAMENTO
                                    </th>
                                    <th class="text-center">
                                        ACTIVIDAD ECONÓMICA
                                    </th>
                                    <th class="text-center">
                                        TIPO
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

