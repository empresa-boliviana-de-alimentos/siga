@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.acopio.acopio_almendra.gbCambioModificacion.partials.modalSolicitudCambioModificacion')
<div class="row">
	<div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-1">
                <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('AcopioAlmendraMenu') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
                </div>

                <div class="col-md-8">
                     <h4><label for="box-title">CAMBIOS Y/O MODIFICACIONES RECIBIDAS</label></h4>
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
    <ul class="nav nav-tabs">
      <li id="tabsolRecibidasJa">
        <a data-toggle="tab" href="#solRecibidasJa" class="btn btn-primary">
          SOLICITUDES RECIBIDAS
        </a>
      </li>
      <li id="tabHistoricoSolicitudesAtendidas">
        <a data-toggle="tab" href="#historicoSolicitudesAtendidas" class="btn btn-warning">
          HISTÓRICO SOLICITUDES ATENDIDAS
        </a>
      </li>
    </ul>
  </div>
</div>
<div class="row">
  <div class="tab-content">
      <div class="tab-pane fade in active" id="solRecibidasJa">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border"></div>
                    <div class="box-body">

                        <div id="no-more-tables">
                            <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-acopio" style="width:100%">
                                <thead class="cf">
                                    <tr>
                                        <th>
                                            NRO SOLICITUD
                                        </th>
                                        <th>
                                            FECHA SOLICITUD
                                        </th>
                                        <th>
                                        	COMPRADOR
                                        </th>
                                        <th>
                                        	ZONA
                                        </th>
                                        <th>
                                            TIPO SOLICITUD
                                        </th>
                                        <th>
                                            DESCRIPCIÓN
                                        </th>
                                        <th>
                                            OPCIONES
                                        </th>                                      
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="historicoSolicitudesAtendidas">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border"></div>
                    <div class="box-body">

                        <div id="no-more-tables">
                            <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-historicoAtendidas" style="width:100%">
                                <thead class="cf">
                                    <tr>
                                        <th>
                                            NRO SOLICITUD
                                        </th>
                                        <th>
                                            FECHA SOLICITUD
                                        </th>
                                        <th>
                                          COMPRADOR
                                        </th>
                                        <th>
                                          ZONA
                                        </th>
                                        <th>
                                            TIPO SOLICITUD
                                        </th>
                                        <th>
                                            DESCRIPCIÓN
                                        </th>
                                        <th>
                                            OPCIONES
                                        </th>                                      
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function() {

    var table =$('#lts-acopio').DataTable( {   
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/SolicitudRecibidaCambioCreate",
            "columns":[
                // {data: 'acciones',orderable: false, searchable: false},
                {data: 'solcam_id'},
                {data: 'solcam_fecha_registro'},
                {data: 'nombreComprador'},
                {data: 'zona_nombre'},
                {data: 'nombreTipoSol'},
                {data: 'solcam_observacion'},
                {data: 'opciones'}
        ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });

 

 
});
function MostrarSolicitud(btn){
		var route = "MostrarSolicitudCambio/"+btn.value;
		$.get(route, function(res){
			console.log(res);
			$("#solcam_id").val(res.solcam_id);
			$("#solcam_id_acopio").val(res.aco_id);
  			document.getElementById("nombreComprador").innerHTML = res.prs_nombres+' '+res.prs_paterno+' '+res.prs_materno;
  			document.getElementById("nombreZona").innerHTML = res.zona_nombre;
  			document.getElementById("tipoSolicitud").innerHTML = res.tipsolcam_nombre;
  			$("#cantidadActual").val(res.aco_cantidad);
  			$("#costoUnitarioActual").val(res.aco_cos_un);
  			$("#costoTotalActual").val(res.aco_cos_total);
  			$("#pesoCajaActual").val(res.aco_peso_neto);
  			$("#nroReciboActual").val(res.aco_num_rec);
  			$("#proveedor").val(res.prov_nombre+' '+res.prov_ap+' '+res.prov_am);
  			$("#cantidadModificar").val(res.solcam_cantidad);
  			$("#costoUnitarioModificar").val(res.solcam_costo_unitario);
  			$("#costoTotalModificar").val(res.solcam_costo_total);
  			$("#pesoCajaModificar").val(res.solcam_peso_caja);
  			$("#nroReciboModificar").val(res.solcam_nro_recibo);
  			$("#solcam_observacion").val(res.solcam_observacion);
		});
	}

$("#registroApSolJefe").click(function(){
	var route = "AprobarSolicitudCambio";
	var token =$("#token").val();
  var tipo_solcitud = document.getElementById("tipoSolicitud").innerHTML;
  if (tipo_solcitud == 'ELIMINACION') {
    swal({   title: "APROBAR SOLICITUD!",
      text: "Usted. esta seguro de aprobar la solicitud tipo "+tipo_solcitud+"?, ya que este tiene un monto total de "+$("#costoTotalActual").val()+" Bs.",
      type: "warning",   showCancelButton: true,
      confirmButtonColor: "#2ECC71",
      confirmButtonText: "ENVIAR!",
      closeOnConfirm: false
    }, function(){
        $.ajax({
          url: route,
          headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data: {
              'apsoljefe_aco_id':$("#solcam_id_acopio").val(),
              'apsoljefe_solcam_id':$("#solcam_id").val(),
              'apsoljefe_observacion':$("#observacion_aprobacion").val()
            },
          success: function(data){
                $("#modalSolicitud").modal('toggle');
                swal("Acceso!", "registro correcto","success");
                         
                $('#lts-acopio').DataTable().ajax.reload();
                $('#lts-historicoAtendidas').DataTable().ajax.reload();
          },
          error: function(result)
          {
              swal("Opss..!", "Error al registrar el dato", "error");
          }
        });
    });
  }else if(tipo_solcitud == 'CANTIDAD'){
    swal({   title: "APROBAR SOLICITUD!",
      text: "Usted. esta seguro de aprobar la solicitud tipo "+tipo_solcitud+"?, ya que este tiene un monto total a modificar de "+$("#costoTotalActual").val()+"Bs a "+$("#costoTotalModificar").val()+" Bs.",
      type: "warning",   showCancelButton: true,
      confirmButtonColor: "#2ECC71",
      confirmButtonText: "ENVIAR!",
      closeOnConfirm: false
    }, function(){
        $.ajax({
          url: route,
          headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data: {
              'apsoljefe_aco_id':$("#solcam_id_acopio").val(),
              'apsoljefe_solcam_id':$("#solcam_id").val(),
              'apsoljefe_observacion':$("#observacion_aprobacion").val()
            },
          success: function(data){
                $("#modalSolicitud").modal('toggle');
                swal("Acceso!", "registro correcto","success");
                         
                $('#lts-acopio').DataTable().ajax.reload();
                $('#lts-historicoAtendidas').DataTable().ajax.reload();
          },
          error: function(result)
          {
              swal("Opss..!", "Error al registrar el dato", "error");
          }
        });
    });
  }else if(tipo_solcitud == 'PESO'){
    swal({   title: "APROBAR SOLICITUD!",
      text: "Usted. esta seguro de aprobar la solicitud tipo: "+tipo_solcitud+"?, ya que este tiene un peso a modificar de "+$("#pesoCajaActual").val()+"Kg a "+$("#pesoCajaModificar").val()+" Kg.",
      type: "warning",   showCancelButton: true,
      confirmButtonColor: "#2ECC71",
      confirmButtonText: "ENVIAR!",
      closeOnConfirm: false
    }, function(){
        $.ajax({
          url: route,
          headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data: {
              'apsoljefe_aco_id':$("#solcam_id_acopio").val(),
              'apsoljefe_solcam_id':$("#solcam_id").val(),
              'apsoljefe_observacion':$("#observacion_aprobacion").val()
            },
          success: function(data){
                $("#modalSolicitud").modal('toggle');
                swal("Acceso!", "registro correcto","success");
                         
                $('#lts-acopio').DataTable().ajax.reload();
                $('#lts-historicoAtendidas').DataTable().ajax.reload();
          },
          error: function(result)
          {
              swal("Opss..!", "Error al registrar el dato", "error");
          }
        });
    });
  }else if(tipo_solcitud == 'PRECIO'){
    swal({   title: "APROBAR SOLICITUD!",
      text: "Usted. esta seguro de aprobar la solicitud tipo: "+tipo_solcitud+"?, ya que este tiene un monto total a moificar de "+$("#costoTotalActual").val()+"Bs a "+$("#costoTotalModificar").val()+" Bs.",
      type: "warning",   showCancelButton: true,
      confirmButtonColor: "#2ECC71",
      confirmButtonText: "ENVIAR!",
      closeOnConfirm: false
    }, function(){
        $.ajax({
          url: route,
          headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data: {
              'apsoljefe_aco_id':$("#solcam_id_acopio").val(),
              'apsoljefe_solcam_id':$("#solcam_id").val(),
              'apsoljefe_observacion':$("#observacion_aprobacion").val()
            },
          success: function(data){
                $("#modalSolicitud").modal('toggle');
                swal("Acceso!", "registro correcto","success");
                         
                $('#lts-acopio').DataTable().ajax.reload();
                $('#lts-historicoAtendidas').DataTable().ajax.reload();
          },
          error: function(result)
          {
              swal("Opss..!", "Error al registrar el dato", "error");
          }
        });
    });
  }else if(tipo_solcitud == 'NUMERO RECIBO'){
    swal({   title: "APROBAR SOLICITUD!",
      text: "Usted. esta seguro de aprobar la solicitud tipo: "+tipo_solcitud+"?, ya que este tiene un numero de recibo amodificar de "+$("#nroReciboActual").val()+" a "+$("#nroReciboModificar").val(),
      type: "warning",   showCancelButton: true,
      confirmButtonColor: "#2ECC71",
      confirmButtonText: "ENVIAR!",
      closeOnConfirm: false
    }, function(){
        $.ajax({
          url: route,
          headers: {'X-CSRF-TOKEN': token},
          type: 'POST',
          dataType: 'json',
          data: {
              'apsoljefe_aco_id':$("#solcam_id_acopio").val(),
              'apsoljefe_solcam_id':$("#solcam_id").val(),
              'apsoljefe_observacion':$("#observacion_aprobacion").val()
            },
          success: function(data){
                $("#modalSolicitud").modal('toggle');
                swal("Acceso!", "registro correcto","success");
                         
                $('#lts-acopio').DataTable().ajax.reload();
                $('#lts-historicoAtendidas').DataTable().ajax.reload();
          },
          error: function(result)
          {
              swal("Opss..!", "Error al registrar el dato", "error");
          }
        });
    });
  }
  
});
$("#rechazarApSolJefe").click(function(){
  var route = "RechazarSolicitudCambio2";
  var token = $("#token").val();
  swal({   title: "RECHAZAR SOLICITUD!",
      text: "Usted. esta seguro de rechazar la solicitud?",
      type: "warning",   showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "RECHAZAR!",
      closeOnConfirm: false
    }, function(){
  $.ajax({
    url: route,
    headers: {'X-CSRF-TOKEN': token},
    type: 'POST',
    dataType: 'json',
    data: {
        'apsoljefe_aco_id':$("#solcam_id_acopio").val(),
        'apsoljefe_solcam_id':$("#solcam_id").val(),
        'apsoljefe_observacion':$("#observacion_aprobacion").val()
      },
    success: function(data){
          $("#modalSolicitud").modal('toggle');
          swal("Acceso!", "Se rechazo la solicitud","success");
                   
          $('#lts-acopio').DataTable().ajax.reload();
          $('#lts-historicoAtendidas').DataTable().ajax.reload();
    },
    error: function(result)
    {
        swal("Opss..!", "Error al procesar", "error");
    }  });
  });
});
function EliminarSolicitud(btn){
    var route="RechazarSolicitudCambio/"+btn.value+"";
    var token =$("#token").val();
    swal({   title: "RECHAZAR SOLICITUD!",
      text: "Usted. esta seguro de rechazar la solicitud?",
      type: "warning",   showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "RECHAZAR!",
      closeOnConfirm: false
    }, function(){
       $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'DELETE',
            dataType: 'json',

            success: function(data){
                $('#lts-acopio').DataTable().ajax.reload();
                $('#lts-historicoAtendidas').DataTable().ajax.reload();
                swal("Acceso!", "Se rechazo la solicitud!", "success");
            },
                error: function(result) {
                    swal("Opss..!", "error al procesar", "error")
            }
        });
    });
}
// LISTAR SOLCITUDES ATENIDAS
$('#lts-historicoAtendidas').DataTable( {   
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/SolicitudCambioAtendidaCreate",
            "columns":[
                // {data: 'acciones',orderable: false, searchable: false},
                {data: 'solcam_id'},
                {data: 'solcam_fecha_registro'},
                {data: 'nombreComprador'},
                {data: 'zona_nombre'},
                {data: 'nombreTipoSol'},
                {data: 'solcam_observacion'},
                {data: 'opciones'}
        ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });

// LIMPIAR CAPO
function LimiarCampo(){
  $("#observacion_aprobacion").val("");
}
</script>
@endpush