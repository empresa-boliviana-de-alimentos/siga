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
@include('backend.administracion.insumo.insumo_devolucion.devolucion_recibidas.partials.modalCreate')
<div class="panel panel-primary">

<div class="panel-heading">
    <div class="row">
        <div class="col-md-2">
            <a type="button" class="btn btn-danger fa fa-arrow-left" href="{{ url('DevolucionRegistrosMenu') }}"></span><h7 style="color:#ffffff">&nbsp;&nbsp;VOLVER</h7></a>
        </div>
        <div class="col-md-7 text-center">
            <p class="panel-title">LISTA DE DEVOLUCIONES RECIBIDAS</p>
        </div>
        <div class="col-md-3 text-right">
            
        </div>
    </div>
    </div>
<!-- <section class="content"> -->
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
              <li class="active" id="tabsolSobrante">
                  <a data-toggle="tab" href="#solReceta" class="btn btn-primary">
                      SOLICITUDES DEVOLUCION POR SOBRANTE
                  </a>
              </li>
                <li id="tabsolDefectuoso">
                    <a data-toggle="tab" href="#solInsumo" class="btn btn-warning">
                        SOLICITUDES DEVOLUCION POR DEFECTUOSO
                    </a>
                </li>
            </ul>
    <div class="tab-content">
      <div class="tab-pane fade in active" id="solReceta">
       <div class="box">
                <div class="box-header with-border text-center">
                    <h3 class="box-title">
                        LISTADO DE SOLICITUDES POR DEVOLUCION SOBRANTE
                    </h3>
                        
                </div>
            <div id="no-more-tables">
                <table class="table table-hover table-striped table-condensed cf" style="width: 100%" id="lts-tabsolSobrante">
                    <thead class="cf">
                                <tr>
                                    <th>
                                        #
                                    </th>                                    
                                    <th>
                                        NRO. ORP
                                    </th>
                                    <th>
                                        FECHA SOLICITUD
                                    </th>
                                    <th>
                                        NRO SALIDA
                                    </th>
                                    <th>
                                        FECHA DEVOLUCION
                                    </th>
                                    <th>
                                        PRODUCTO PRODUCIR
                                    </th>
                                    <th>
                                        SOLICITANTE
                                    </th>     
                                    <th>
                                        OPCIONES
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
            
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>
                                        #
                                    </th>                                    
                                    <th>
                                        NRO. ORP
                                    </th>
                                    <th>
                                        FECHA SOLICITUD
                                    </th>
                                    <th>
                                        NRO SALIDA
                                    </th>
                                    <th>
                                        FECHA DEVOLUCION
                                    </th>
                                    <th>
                                        PRODUCTO PRODUCIR
                                    </th>
                                    <th>
                                        SOLICITANTE
                                    </th>     
                                    <th>
                                        OPCIONES
                                    </th>                                
                                </tr>
                            </tfoot>
                </table>
            </div>
        </div>
        </div>
        <div class="tab-pane fade" id="solInsumo">
            <div class="box">
                <div class="box-header with-border text-center">
                    <h3 class="box-title">
                        LISTADO DE SOLICITUDES POR DEVOLUCION DEFECTUOSO
                    </h3>
                </div>
                <div class="box-body">
                 <div id="no-more-tables">
                    <table class="table table-hover table-striped table-condensed cf" style="width: 100%" id="lts-tabsolDefectuoso">
                        <thead class="cf">
                                <tr>
                                    <th>
                                        #
                                    </th>                                    
                                    <th>
                                        NRO. ORP
                                    </th>
                                    <th>
                                        FECHA SOLICITUD
                                    </th>
                                    <th>
                                        NRO SALIDA
                                    </th>
                                    <th>
                                        FECHA DEVOLUCION
                                    </th>
                                    <th>
                                        PRODUCTO PRODUCIR
                                    </th>
                                    <th>
                                        SOLICITANTE
                                    </th>     
                                    <th>
                                        OPCIONES
                                    </th>                      
                                </tr>
                            </thead>
                            <tbody>
            
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>
                                        #
                                    </th>                                    
                                    <th>
                                        NRO. ORP
                                    </th>
                                    <th>
                                        FECHA SOLICITUD
                                    </th>
                                    <th>
                                        NRO SALIDA
                                    </th>
                                    <th>
                                        FECHA DEVOLUCION
                                    </th>
                                    <th>
                                        PRODUCTO PRODUCIR
                                    </th>
                                    <th>
                                        SOLICITANTE
                                    </th>     
                                    <th>
                                        OPCIONES
                                    </th>                   
                                </tr>
                            </tfoot>
                    </table>
                </div>
                </div>
                <div class="box-footer clearfix">
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>

@endsection
@push('scripts')
<script>
//TABLE SOBRANTE
var t = $('#lts-tabsolSobrante').DataTable( {
            "destroy":true,
            "processing": true,
            "serverSide": true,
            "ajax": "/DevolucionRecibida/create/",
            "columns":[
                {data: 'devo_id'},
                {data: 'devo_nro_orden'},
                {data: 'devo_registrado'},
                {data: 'devo_nro_salida'},
                {data: 'devo_modificado'},
                {data: 'nombreReceta'},                
                {data: 'nombreSol'},
                {data: 'acciones',orderable: false, searchable: false},
            ],
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
         "order": [[ 0, "desc" ]]
       
    });
t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
//TABLE DEFECTUOSO
var t2 = $('#lts-tabsolDefectuoso').DataTable( {
            "destroy":true,
            "processing": true,
            "serverSide": true,
            "ajax": "DevolucionRecibidaDefecCreate",
            "columns":[
                //{data: 'estadoDevoDefectuoso'}
                {data: 'devo_id'},
                {data: 'devo_nro_orden'},
                {data: 'devo_registrado'},
                {data: 'devo_nro_salida'},
                {data: 'devo_modificado'},
                {data: 'nombreReceta'},                
                {data: 'nombreSol'},
                {data: 'acciones',orderable: false, searchable: false},
            ],
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
         "order": [[ 0, "desc" ]]
       
    });
t2.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
 function MostrarDevolucionRec(id){     
    var dat=id.value;
    console.log(dat);
      $('#lts-devolucionDetalleRec').DataTable( {
            "destroy":true,
            "processing": true,
            "serverSide": true,
            "ajax": "DevolucionDetalleRec/"+dat,
            "columns":[
                {data: 'id'},
                {data: 'insumo'},
                {data: 'unidad'},
                {data: 'cantidad'},
                {data: 'rango'},
                {data: 'adicion'},
                {data: 'devolucion'},
        ],
        "order": [[ 0, "asc" ]],
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[5, 25, 50, -1], [10, 25, 50, "All"]],
         "order": [[ 0, "desc" ]]
    });
   }

 function MostrarDatos(btn){
      var route = "/DevolucionRecibida/"+btn.value+"/edit";
      $.get(route, function(res){
        $("#dev_id1").val(res.dev_id);
        $("#nom_rec1").val(res.dev_nom_rec);
        $("#num_salida1").val(res.dev_num_sal);
        $("#dev_solicitante").val(res.prs_nombres+' '+res.prs_paterno+' '+ res.prs_materno);
      });
    }

 $("#aprobDevoluciones").click(function(){
    var rows = [];
        $('#lts-devolucionDetalleRec tbody tr').each(function(){
            rows.push({
                id1:$(this).find("td").eq(0).html(),
                insumo1:$(this).find("td").eq(1).html(),
                unidad1:$(this).find("td").eq(2).html(),
                cantidad1:$(this).find("td").eq(3).html(),
                rango1:$(this).find("td").eq(4).html(),
                adicion1:$(this).find("td").eq(4).html(),
                devolucion1:$(this).find("td").eq(4).html(),
            });
        });
            itemsDevoluciones = JSON.stringify(rows);
            console.log('Json Table devolucion: ', itemsDevoluciones);
          
            var route="/DevolucionRecibida";
                     var token =$("#token").val();
                     $.ajax({
                         url: route,
                         headers: {'X-CSRF-TOKEN': token},
                         type: 'POST',
                         dataType: 'json',
                         data: {
                         'devrec_id_dev':$("#dev_id1").val(),
                         'devrec_nom_receta':$("#nom_rec1").val(),
                         'devrec_num_salida':$("#num_salida1").val(),
                        // 'devrec_tipo_sol':$("#dev_solicitante").val(),
                         'data':itemsDevoluciones,
                        // 'obs':$("#obs").val(),
                         },
                         success: function(data){
                            // $('#lts-carrito').DataTable().ajax.reload();
                             swal("Devolucion!", "aprobado correctamente","success");
                             $("#myCreateRecibidas").modal('toggle');Limpiar();
                         },
                         error: function(result)
                         {
                         swal("Opss..!", "Error al registrar el dato", "error");
                         }
                     });
    });
   

</script>
@endpush


