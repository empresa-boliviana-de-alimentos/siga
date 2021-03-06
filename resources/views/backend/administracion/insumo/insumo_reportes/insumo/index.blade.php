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
</style>
@section('main-content')
@include('backend.administracion.insumo.insumo_registro..proveedores.partials.modalCreate')
@include('backend.administracion.insumo.insumo_registro..proveedores.partials.modalUpdate')
<div class="panel panel-primary" >
    
    <div class="panel-heading" style="background-color: #202040">
        <div class="row">
            <div class="col-md-2">
                
            </div>
            <div class="col-md-7 text-center">
                <p class="panel-title">INSUMOS KARDEX</p>
            </div>
            <div class="col-md-3 text-right">
                <a href="RpMensual" class="btn btn-success" target="_blank"><h6 style="color: white"><span class="fa fa-file-o"></span> EXPORTAR INVENTARIO</h6></a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-inskardex" style="width: 100%">
            <thead>
                <tr>
                    <th class="text-center">
                        #
                    </th>
                    <th class="text-center">
                        KARDEX VALORADO
                    </th>
                    <th class="text-center">
                        KARDEX FÍSICO
                    </th>
                    <th class="text-center">
                        CÓDIDO
                    </th>
                    <th class="text-center" style="width: 200px">
                        INSUMO
                    </th>
                    <th class="text-center">
                        U. MEDIDA
                    </th>
                    <th class="text-center">
                        STOCK ACTUAL
                    </th>
                    <th class="text-center">
                        PARTIDA
                    </th>
                </tr>
            </thead>
            <tbody>
            <?php $nro = 0; ?>
            @foreach($ins as $in)
            <?php $nro = $nro + 1; ?>
                <tr>
                    <td class="text-center">{{$nro}}</td>
                    <td class="text-center"><div class="text-center"><a style="background-color: #d4b729;border: none;color: white;padding: 5px;text-align: center;text-decoration: none;display: inline-block;font-size: 10px;margin: 4px 2px;border-radius: 50%;" href="RpKardexValoradoInsumo/{{$in->ins_id}}" type="button" target="_blank"><span class="glyphicon glyphicon-usd fa-2x"></span></a></div></td>
                    <td class="text-center"><div class="text-center"><a style="background-color:#999;border: none;color: white;padding: 5px;text-align: center;text-decoration: none;display: inline-block;font-size: 10px;margin: 4px 2px;border-radius: 50%;" href="/RpKardexFisicoInsumo/{{$in->ins_id}}" type="button" target="_blank"><span class="fa fa-file-o fa-2x"></span></a></div></td>
                    <td class="text-center">{{$in->ins_codigo}}</td>
                    <td class="text-center">{{$in->ins_desc.' '.$in->sab_nombre.' '.$in->ins_peso_presen}}</td>
                    <td class="text-center">{{$in->umed_nombre}}</td>
                    <td class="text-center">{{$in->stocks_cantidad}}</td>
                    <td class="text-center">{{$in->part_nombre}}</td>
                </tr>
            @endforeach
            </tbody>
            <tr>
            </tr>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script>
    /*var t = $('#lts-inskardex').DataTable( {

         "processing": true,
            "serverSide": true,
            "ajax": "/ListKardex/create/",
            "columns":[
                {data: 'ins_id'},
                {data: 'kardexValorado',orderable: false, searchable: false},
                {data: 'kardexFisico',orderable: false, searchable: false},
                {data: 'ins_codigo'},
                {data: 'NombreInsumo'},
                {data: 'umed_nombre'},
                {data: 'stocks_cantidad'},
                {data: 'part_nombre'}
        ],

        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[15, 25, 50, -1], [15, 25, 50, "All"]],
         "order": [[ 0, "desc" ]],


    });
    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();*/
    $('#lts-inskardex').DataTable( {
        "responsive": true,
        "order": [[ 0, "asc" ]],
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[15, 25, 50, -1], [15, 25, 50, "All"]],

    });
</script>
@endpush


