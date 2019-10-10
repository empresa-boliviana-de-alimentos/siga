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
.col-search-input{
  color: black;
}
</style>
@section('main-content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-3">
                    <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('ReportesInsumoMenu') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span>&nbsp;<span style="color:white">MENU</span></a>
                </div>
                <div class="col-md-9">
                     <h4><label for="box-title">SOLICITUDES ALMACÉN POR INSUMOS</label></h4>
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
            <div class="ocultarBotonDescargasSolicitudesInsumos" style="display: none;">
                <a href="" class="btn btn-danger pdfSolicitudesAlmacen" target="_blank"><span class="fa fa-file-pdf-o"> DESCARGAR PDF</span></a>
                <a href="" class="btn btn-success excelSolicitudesAlmacen"><span class="fa fa-file-excel-o"> DESCARGAR EXCEL</span></a>
            </div> 
            <div id="no-more-tables">
                <table class="table table-hover table-striped table-condensed cf" style="width: 100%" id="lts-solicitudesInsumos">
                    <thead class="cf">
                        <tr>
                            <th>
                                Nro
                            </th>                                    
                            <th>
                                Nro. ORP
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
                                Fecha Solicitud
                            </th>
                            <th>
                                Estado
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
                                Nro. ORP
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
                                Fecha Solicitud
                            </th>
                            <th>
                                Estado
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
$(document).ready(function ()
{
  $('#lts-solicitudesInsumos thead th').each(function () {
    var title = $(this).text();
      $(this).html(title+' <input type="text" class="col-search-input" placeholder="Buscar' + title + '" />');
    });      
});
function Buscarfechas() {
  console.log($("#id_mes").val());
  $(".ocultarBotonDescargasSolicitudesInsumos").show();
  $(".pdfSolicitudesAlmacen").attr('href','imprimirPdfSolicitudesAlmacenInsumosMes/'+$("#id_mes").val());
  $(".excelSolicitudesAlmacen").attr('href','imprimirExcelSolicitudesAlmacenInsumosMes/'+$("#id_mes").val());
  
  var t = $('#lts-solicitudesInsumos').DataTable( {
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax":{
               url : "createListarSolicitudesAlmacenInsumos/"+ $("#id_mes").val(),
               type: "GET",
               data: {"mes": $("#id_mes").val()}
             },
            "columns":[
                {data: 'orprod_id'},
                {data: 'orprod_nro_orden'},
                {data: 'ins_codigo'},
                {data: 'ins_desc'},
                {data: 'detorprod_cantidad'},
                {data: 'orprod_fecha_vodos'},
                {data: 'orprod_nro_salida',
                       'render': function(data, type, full, meta){
                          if(data){
                            return '<h5><span class="label label-success">APROBADO</span></h5>';
                          }else{
                            return '<h5><span class="label label-danger">SIN APROBACIÓN</span></h5>';
                          }
                        }
                } 
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
  t.columns().every(function () {
            var t = this;
            $('input', this.header()).on('keyup change', function () {
                if (t.search() !== this.value) {
                     t.search(this.value).draw();
                }
            });
        });
}
function BuscarDia() {
  console.log($("#id_dia").val());
  $(".ocultarBotonDescargasSolicitudesInsumos").show();
  $(".pdfSolicitudesAlmacen").attr('href','imprimirPdfSolicitudesAlmacenInsumosDia/'+$("#id_dia").val());
  $(".excelSolicitudesAlmacen").attr('href','imprimirExcelSolicitudesAlmacenInsumosDia/'+$("#id_dia").val());
  
  var t = $('#lts-solicitudesInsumos').DataTable( {
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax":{
               url : "createListarSolicitudesAlmacenInsumosDia/"+ $("#id_dia").val(),
               type: "GET",
               data: {"mes": $("#id_mes").val()}
             },
            "columns":[
                {data: 'orprod_id'},
                {data: 'orprod_nro_orden'},
                {data: 'ins_codigo'},
                {data: 'ins_desc'},
                {data: 'detorprod_cantidad'},
                {data: 'orprod_fecha_vodos'},
                {data: 'orprod_nro_salida',
                       'render': function(data, type, full, meta){
                          if(data){
                            return '<h5><span class="label label-success">APROBADO</span></h5>';
                          }else{
                            return '<h5><span class="label label-danger">SIN APROBACIÓN</span></h5>';
                          }
                        }
                } 
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
  t.columns().every(function () {
            var t = this;
            $('input', this.header()).on('keyup change', function () {
                if (t.search() !== this.value) {
                     t.search(this.value).draw();
                }
            });
        });
}
function BuscarRango() {
  console.log($("#id_dia_inicio").val()+' '+$("#id_dia_fin"));
  $(".ocultarBotonDescargasSolicitudesInsumos").show();
  $(".pdfSolicitudesAlmacen").attr('href','imprimirPdfSolicitudesAlmacenInsumosRango/'+$("#id_dia_inicio").val()+'/'+$("#id_dia_fin").val());
  $(".excelSolicitudesAlmacen").attr('href','imprimirExcelSolicitudesAlmacenInsumosRango/'+$("#id_dia_inicio").val()+'/'+$("#id_dia_fin").val());
  
  var t = $('#lts-solicitudesInsumos').DataTable( {
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax":{
               url : "createListarSolicitudesAlmacenInsumosRango/"+ $("#id_dia_inicio").val()+"/"+$("#id_dia_fin").val(),
               type: "GET",
               data: {"mes": $("#id_mes").val()}
             },
            "columns":[
                {data: 'orprod_id'},
                {data: 'orprod_nro_orden'},
                {data: 'ins_codigo'},
                {data: 'ins_desc'},
                {data: 'detorprod_cantidad'},
                {data: 'orprod_fecha_vodos'},
                {data: 'orprod_nro_salida',
                       'render': function(data, type, full, meta){
                          if(data){
                            return '<h5><span class="label label-success">APROBADO</span></h5>';
                          }else{
                            return '<h5><span class="label label-danger">SIN APROBACIÓN</span></h5>';
                          }
                        }
                } 
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
  t.columns().every(function () {
            var t = this;
            $('input', this.header()).on('keyup change', function () {
                if (t.search() !== this.value) {
                     t.search(this.value).draw();
                }
            });
        });
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


