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
    tfoot th {
      background-color:#202040;
      color: white;
      font-size: 12px;
    }
    tbody td {
        font-size: 10px
    }
</style>
@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-1">
                    <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('ReportesInsumoMenu') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
                </div>
                <div class="col-md-8">
                     <h4><label for="box-title">INGRESOS ALMACEN (REPORTES)</label></h4>
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
                <div class="col-md-3" style="background-color: #338CC0; color: white">
                    <div class="form-group">
                        <div class="text-center">
                            <label>
                                <strong>Seleccione Mes</strong>
                            </label>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control datepickerMonths" id="id_mes" name="id_mes" placeholder="Introduzca mes"> 
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="busca_mes" onclick="Buscarfechas();">Buscar</button>
                            </span>                  
                        </div>         
                    </div>
                </div>
                <div class="col-md-3" style="background-color: #30759D; color: white">
                    <div class="form-group">
                        <div class="text-center">
                            <label><strong>Seleccione Día</strong></label>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control datepickerDays" id="id_dia" name="id_dia" placeholder="Introduzca dia"> 
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="busca_mes" onclick="BuscarDia();">Buscar</button>
                            </span>
                        </div>                            
                    </div>
                </div>
                <div class="col-md-6" style="background-color: #5993B6; color: white">
                    <div class="form-group">
                          <div class="text-center">
                            <label><strong>Seleccione Rango de Fecha</strong></label>
                          </div>
                          <div class="input-group">
                            <div class="col-md-6">
                              <input type="text" class="form-control datepickerDays" id="id_dia_inicio" name="id_dia_inicio" placeholder="Introduzca dia">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control datepickerDays" id="id_dia_fin" name="id_dia_fin" placeholder="Introduzca dia">  
                            </div>
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="busca_mes" onclick="BuscarRango();">Buscar</button>
                            </span>
                          </div>                            
                    </div>
                </div>             
            </div>
            <div class="ocultarBotonDescargasIngresosPorInsumos" style="display: none;">
                <a href="" class="btn btn-danger pdfIngresosAlmacen" target="_blank"><span class="fa fa-file-pdf-o"> DESCARGAR PDF</span></a>
                <a href="" class="btn btn-success excelIngresosAlmacen"><span class="fa fa-file-excel-o"> DESCARGAR EXCEL</span></a>
            </div> 
            <div id="no-more-tables">
                <table class="table table-hover table-striped table-condensed cf" style="width: 100%" id="lts-ingresoNormales">
                    <thead class="cf">
                                <tr>
                                    <th>
                                        Nro
                                    </th>                                    
                                    <th>
                                        Nro. Ingreso
                                    </th>
                                    <th>
                                        Codigo
                                    </th>
                                    <th>
                                        Insumo
                                    </th>
                                    <th>
                                        Cantidad
                                    </th>
                                    <th>
                                        Costo U.
                                    </th>
                                    <th>
                                        Fecha Ingreso
                                    </th>            
                                    <th>
                                        Fecha Venc.
                                    </th>
                                    <th>
                                        Tipo Ingreso
                                    </th>
                                    <th>
                                        Nro Remisión
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
                                        Nro. Ingreso
                                    </th>
                                    <th>
                                        Codigo
                                    </th>
                                    <th>
                                        Insumo
                                    </th>
                                    <th>
                                        Cantidad
                                    </th>
                                    <th>
                                        Costo U.
                                    </th>
                                    <th>
                                        Fecha Ingreso
                                    </th>            
                                    <th>
                                        Fecha Venc.
                                    </th>
                                    <th>
                                        Tipo Ingreso
                                    </th>
                                    <th>
                                        Nro Remisión
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
function Buscarfechas() {
  console.log($("#id_mes").val());
  $(".ocultarBotonDescargasIngresosPorInsumos").show();
  $(".pdfIngresosAlmacen").attr('href','imprimirPdfIngresosAlmacenporInsumosMes/'+$("#id_mes").val());
  $(".excelIngresosAlmacen").attr('href','imprimirExcelIngresoAlmacenporInsumosMes/'+$("#id_mes").val());
  
  var t = $('#lts-ingresoNormales').DataTable( {
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax":{
               url : "createListarIngresoAlmacen/"+ $("#id_mes").val(),
               type: "GET",
               data: {"mes": $("#id_mes").val()}
             },
            "columns":[
                {data: 'deting_id'},
                {data: 'ing_enumeracion'},
                {data: 'ins_codigo'}, 
                {data: 'ins_desc'},
                {data: 'deting_cantidad'},
                {data: 'deting_costo'},
                {data: 'ing_registrado'},
                {data: 'deting_fecha_venc'},
                {data: 'ting_nombre'},
                {data: 'ing_remision'}
            ],        
        "language": {
             "url": "/lenguaje"
        },
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "paging":   true,
        "ordering": true,
        "info":     true       
  });
  t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
  } ).draw();
}
function BuscarDia() {
  console.log($("#id_mes").val());
  $(".ocultarBotonDescargasIngresosPorInsumos").show();
  $(".pdfIngresosAlmacen").attr('href','imprimirPdfIngresosAlmacenporInsumosDia/'+$("#id_dia").val());
  $(".excelIngresosAlmacen").attr('href','imprimirExcelIngresoAlmacenporInsumosDia/'+$("#id_dia").val());
  
  var t = $('#lts-ingresoNormales').DataTable( {
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax":{
               url : "createListarIngresoAlmacenDia/"+ $("#id_dia").val(),
               type: "GET",
               data: {"mes": $("#id_mes").val()}
             },
            "columns":[
                {data: 'deting_id'},
                {data: 'ing_enumeracion'},
                {data: 'ins_codigo'}, 
                {data: 'ins_desc'},
                {data: 'deting_cantidad'},
                {data: 'deting_costo'},
                {data: 'ing_registrado'},
                {data: 'deting_fecha_venc'},
                {data: 'ting_nombre'},
                {data: 'ing_remision'}
            ],        
        "language": {
             "url": "/lenguaje"
        },
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "paging":   true,
        "ordering": true,
        "info":     true       
  });
  t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
  } ).draw();
}
function BuscarRango() {
  console.log($("#id_mes").val());
  $(".ocultarBotonDescargasIngresosPorInsumos").show();
  $(".pdfIngresosAlmacen").attr('href','imprimirPdfIngresosAlmacenporInsumosRango/'+$("#id_dia_inicio").val()+'/'+$("#id_dia_fin").val());
  $(".excelIngresosAlmacen").attr('href','imprimirExcelIngresoAlmacenporInsumosRango/'+$("#id_dia_inicio").val()+'/'+$("#id_dia_fin").val());
  
  var t = $('#lts-ingresoNormales').DataTable( {
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax":{
               url : "createListarIngresoAlmacenRango/"+ $("#id_dia_inicio").val()+"/"+$("#id_dia_fin").val(),
               type: "GET",
               data: {"mes": $("#id_mes").val()}
             },
            "columns":[
                {data: 'deting_id'},
                {data: 'ing_enumeracion'},
                {data: 'ins_codigo'}, 
                {data: 'ins_desc'},
                {data: 'deting_cantidad'},
                {data: 'deting_costo'},
                {data: 'ing_registrado'},
                {data: 'deting_fecha_venc'},
                {data: 'ting_nombre'},
                {data: 'ing_remision'}
            ],        
        "language": {
             "url": "/lenguaje"
        },
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "paging":   true,
        "ordering": true,
        "info":     true       
  });
  t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
  } ).draw();
}
$('.datepickerMonths').datepicker({
        format: "mm/yyyy",
        viewMode: "months", 
        minViewMode: "months",
        language: "es",
    }).datepicker("setDate", new Date()); 

    $('.datepickerDays').datepicker({
        format: "dd/mm/yyyy",        
        language: "es",
    }).datepicker("setDate", new Date()); 
</script>
@endpush  


