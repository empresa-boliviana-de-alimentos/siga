@extends('backend.template.app')
@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-1">
                    <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('ReporteGralInsumo') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
                </div>
                <div class="col-md-8">
                     <h4><label for="box-title">INGRESOS ALMACEN (REPORTES GENERAL)</label></h4>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-2">
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
        <div class="col-md-12">
         
    <div class="tab-content">
      <div class="tab-pane fade in active" id="ingresoNormal">
       <div class="box">
                <div class="box-header with-border text-center">
                    <h3 class="box-title">
                        INGRESOS ALMACEN
                    </h3>
                        
                </div>
            <div id="no-more-tables">
                <table class="table table-hover table-striped table-condensed cf" style="width: 100%" id="lts-ingresoNormales">
                    <thead class="cf">
                                <tr>
                                    <th>
                                        Nro
                                    </th>                                    
                                    <th>
                                        Reporte
                                    </th>
                                    <th>
                                        Nro. Ingreso
                                    </th>
                                    <th>
                                        Fecha
                                    </th>
                                    <th>
                                        Usuario Registro
                                    </th>
                                    <th>
                                        Nro. Remisión
                                    </th>                    
                                </tr>
                            </thead>
                            <tbody>
            
                            </tbody>
                            <tfoot>
                                <tr>
                                   <th>
                                        Nro
                                    </th>                                    
                                    <th>
                                        Reporte
                                    </th>
                                    <th>
                                        Nro. Ingreso
                                    </th>
                                    <th>
                                        Fecha
                                    </th>
                                    <th>
                                        Usuario Registro
                                    </th>
                                    <th>
                                        Nro. Remisión
                                    </th>                                   
                                </tr>
                            </tfoot>
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
    var t = $('#lts-ingresoNormales').DataTable( {
      
            "processing": false,
            "serverSide": true,
            "ajax": "CreateListarReporteGralIngreso",
            "columns":[
                {data: 'ing_id'},
                {data: 'acciones',orderable: false, searchable: false},
                {data: 'ing_enumeracion'}, 
                {data: 'ing_registrado'},
                {data: 'nombre_usuario'},
                {data: 'ing_remision'},
                {data: 'factura'},

        ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
         "order": [[ 0, "desc" ]],
         
       
    });
    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
</script>
@endpush  


