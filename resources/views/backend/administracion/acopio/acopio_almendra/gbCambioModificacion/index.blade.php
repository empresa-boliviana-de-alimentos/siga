@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.acopio.acopio_almendra.gbCambioModificacion.partials.modalCreateCambioModificacion')
<div class="row">
	<div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-1">
                <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('AcopioAlmendraMenu') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
                </div>

                <div class="col-md-8">
                     <h4><label for="box-title">CAMBIOS Y/O MODIFICACIONES</label></h4>
                </div>
                
                <div class="col-md-2"> 
                    
                    <button class="btn btn-default" data-target="#myCreateCambioModificacion" data-toggle="modal" style="background: #616A6B"><h6 style="color: white">+&nbsp;&nbsp;NUEVA SOLICITUD CAMBIO/MODIFICACIÓN</h6></button>
                </div>

            </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
  <div class="col-md-12">
    <ul class="nav nav-tabs">
      <li id="tabsolRealizadas">
        <a data-toggle="tab" href="#solRealizadas" class="btn btn-primary">
          SOLICITUDES REALIZADAS
        </a>
      </li>
      <li id="tabHistoricoSolicitudesRealizadas">
        <a data-toggle="tab" href="#historicoSolicitudesRealizadas" class="btn btn-warning">
          HISTÓRICO SOLICITUDES
        </a>
      </li>
    </ul>
  </div>
</div>
<div class="row">
	<div class="tab-content">
    	<div class="tab-pane fade in active" id="solRealizadas">
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
	                                            TIPO SOLICITUD
	                                        </th>
	                                        <th>
	                                            DESCRIPCIÓN
	                                        </th>
	                                        <th>
	                                            ESTADO
	                                        </th>
	                                        <th>
	                                            USUARIO
	                                        </th>                                        
	                                    </tr>
	                                </thead>
	                            </table>
	                        </div>
	                    </div>
	            </div>
	        </div>
	    </div>
	    <div class="tab-pane fade" id="historicoSolicitudesRealizadas">
	        <div class="col-md-12">        	
	            <div class="box">
	                <div class="box-header with-border"></div>
	                    <div class="box-body">
	                        
	                        <div id="no-more-tables">
	                            <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-historicosRealizadas" style="width:100%">
	                                <thead class="cf">
	                                    <tr>
	                                        <th>
	                                            NRO SOLICITUD
	                                        </th>
	                                        <th>
	                                            FECHA SOLICITUD
	                                        </th>
	                                        <th>
	                                            TIPO SOLICITUD
	                                        </th>
	                                        <th>
	                                            DESCRIPCIÓN
	                                        </th>
	                                        <th>
	                                            ESTADO
	                                        </th>
	                                        <th>
	                                            USUARIO
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
            "ajax": "/SolicitudCambio/create",
            "columns":[
                // {data: 'acciones',orderable: false, searchable: false},
                {data: 'solcam_id'},
                {data: 'solcam_fecha_registro'},
                {data: 'tipoSolicitud'},
                {data: 'solcam_observacion'},
                {data: 'estadoSolicitud'},
                {data: 'nombreComprador'}
        ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });

 $("#registroSolCam").click(function(){
	var route="/SolicitudCambio";
	var token =$("#token").val();
	var checkCantidad = document.getElementById("checkCantidad");
	var checPeso = document.getElementById("checkPeso");
	var checkNroRecibo = document.getElementById("checkNroRecibo");
	var checkEliminacion = document.getElementById("checkEliminacion");
	var checkPrecio = document.getElementById("checkPrecio");
	var solcam_cantidad, solcam_costo_unitario, solcam_costo_total, solcam_peso_caja, solcam_nro_recibo, solcam_tipo_id;
	if (checkCantidad.checked) {
		console.log("CHECKED CANTIDAD");
		solcam_cantidad = $("#cantidadCambio").val();
		solcam_costo_unitario = $("#costoUnitario").val();
		solcam_costo_total = $("#costoTotal").val(); 
		solcam_peso_caja = $("#pesoCaja").val(); 
		solcam_nro_recibo = $("#nroRecibo").val();
		solcam_tipo_id = $("#checkCantidad").val();

		swal({   title: "Esta seguro de enviar la solicitud?",
	      text: "por que el cambio de cantidad: "+ $("#cantidadActual").val() +" a "+ solcam_cantidad +" tiene un costo de "+ solcam_costo_total +" a modificar.",
	      type: "warning",   showCancelButton: true,
	      confirmButtonColor: "#28A345",
	      confirmButtonText: "SI",
	      closeOnConfirm: false
	    }, function(){
	           
			$.ajax({
				url: route,
				headers: {'X-CSRF-TOKEN': token},
				type: 'POST',
				dataType: 'json',
				data: {
					'solcam_aco_id':$("#id_acopio").val(),
					'solcam_usr_id':$("#id_comprador").val(),
					'solcam_cantidad':solcam_cantidad,
					'solcam_costo_unitario':solcam_costo_unitario,
					'solcam_costo_total':solcam_costo_total,
					'solcam_peso_caja':solcam_peso_caja,
		            'solcam_nro_recibo':solcam_nro_recibo,
		            'solcam_tipo_id':solcam_tipo_id,
		            'solcam_observacion':$("#observacion_sol").val()
		            				
		        },
				success: function(data){
					$("#myCreateCambioModificacion").modal('toggle');
					swal({ 
		            	title: "Exito",
		                text: "Registrado con Exito",
		                type: "success" 
		            },
		            function(){
		                location.reload();
		            });
				},
				error: function(result){
						swal("Opss..!", "Error al registrar el dato", "error");
				}
			});
		});
	}else if(checPeso.checked){
		console.log("CHECKED PESO");
		solcam_cantidad = $("#cantidad1").val();
		solcam_costo_unitario = $("#costoUnitario1").val();
		solcam_costo_total = $("#costoTotal1").val(); 
		solcam_peso_caja = $("#pesoCambio1").val();
		solcam_nro_recibo = $("#nroRecibo1").val();
		solcam_tipo_id = $("#checkPeso").val();
		swal({   title: "Esta seguro de enviar la solicitud?",
	      text: "Se cambiara el peso: "+ $("#pesoActual1").val() +" a "+ solcam_peso_caja+", el cual tiene un costo total de "+solcam_costo_total,
	      type: "warning",   showCancelButton: true,
	      confirmButtonColor: "#28A345",
	      confirmButtonText: "SI",
	      closeOnConfirm: false
	    }, function(){
	           
			$.ajax({
				url: route,
				headers: {'X-CSRF-TOKEN': token},
				type: 'POST',
				dataType: 'json',
				data: {
					'solcam_aco_id':$("#id_acopio").val(),
					'solcam_usr_id':$("#id_comprador").val(),
					'solcam_cantidad':solcam_cantidad,
					'solcam_costo_unitario':solcam_costo_unitario,
					'solcam_costo_total':solcam_costo_total,
					'solcam_peso_caja':solcam_peso_caja,
		            'solcam_nro_recibo':solcam_nro_recibo,
		            'solcam_tipo_id':solcam_tipo_id,
		            'solcam_observacion':$("#observacion_sol").val()
		            				
		        },
				success: function(data){
					$("#myCreateCambioModificacion").modal('toggle');
					swal({ 
		            	title: "Exito",
		                text: "Registrado con Exito",
		                type: "success" 
		            },
		            function(){
		                location.reload();
		            });
				},
				error: function(result){
						swal("Opss..!", "Error al registrar el dato", "error");
				}
			});
		});
	}else if(checkNroRecibo.checked){
		console.log("CHECKED NRO RECIBO");
		solcam_cantidad = $("#cantidad2").val();
		solcam_costo_unitario = $("#costoUnitario2").val();
		solcam_costo_total = $("#costoTotal2").val(); 
		solcam_peso_caja = $("#pesoCaja2").val();
		solcam_nro_recibo = $("#nroReciboNuevo").val();
		solcam_tipo_id = $("#checkNroRecibo").val();
		swal({   title: "Esta seguro de enviar la solicitud?",
	      text: "Se cambiara el Nro de Recibo: "+ $("#nroReciboActual2").val() +" a "+ solcam_nro_recibo,
	      type: "warning",   showCancelButton: true,
	      confirmButtonColor: "#28A345",
	      confirmButtonText: "SI",
	      closeOnConfirm: false
	    }, function(){
	           
			$.ajax({
				url: route,
				headers: {'X-CSRF-TOKEN': token},
				type: 'POST',
				dataType: 'json',
				data: {
					'solcam_aco_id':$("#id_acopio").val(),
					'solcam_usr_id':$("#id_comprador").val(),
					'solcam_cantidad':solcam_cantidad,
					'solcam_costo_unitario':solcam_costo_unitario,
					'solcam_costo_total':solcam_costo_total,
					'solcam_peso_caja':solcam_peso_caja,
		            'solcam_nro_recibo':solcam_nro_recibo,
		            'solcam_tipo_id':solcam_tipo_id,
		            'solcam_observacion':$("#observacion_sol").val()
		            				
		        },
				success: function(data){
					$("#myCreateCambioModificacion").modal('toggle');
					swal({ 
		            	title: "Exito",
		                text: "Registrado con Exito",
		                type: "success" 
		            },
		            function(){
		                location.reload();
		            });
				},
				error: function(result){
						swal("Opss..!", "Error al registrar el dato", "error");
				}
			});
		});
	}else if(checkEliminacion.checked){
		console.log("CHECKED ELIMINACION");
		solcam_cantidad = $("#cantidad3").val();
		solcam_costo_unitario = $("#costoUnitario3").val();
		solcam_costo_total = $("#costoTotal3").val(); 
		solcam_peso_caja = $("#pesoCaja3").val();
		solcam_nro_recibo = $("#nroRecibo3").val();
		solcam_tipo_id = $("#checkEliminacion").val();
		swal({   title: "Esta seguro de enviar la solicitud?",
	      text: "Por que tiene un peso: "+ solcam_peso_caja +", cantidad: "+ solcam_cantidad+" y costo total: "+solcam_costo_total+" el cual seran eliminados.",
	      type: "warning",   showCancelButton: true,
	      confirmButtonColor: "#28A345",
	      confirmButtonText: "SI",
	      closeOnConfirm: false
	    }, function(){
	           
			$.ajax({
				url: route,
				headers: {'X-CSRF-TOKEN': token},
				type: 'POST',
				dataType: 'json',
				data: {
					'solcam_aco_id':$("#id_acopio").val(),
					'solcam_usr_id':$("#id_comprador").val(),
					'solcam_cantidad':solcam_cantidad,
					'solcam_costo_unitario':solcam_costo_unitario,
					'solcam_costo_total':solcam_costo_total,
					'solcam_peso_caja':solcam_peso_caja,
		            'solcam_nro_recibo':solcam_nro_recibo,
		            'solcam_tipo_id':solcam_tipo_id,
		            'solcam_observacion':$("#observacion_sol").val()
		            				
		        },
				success: function(data){
					$("#myCreateCambioModificacion").modal('toggle');
					swal({ 
		            	title: "Exito",
		                text: "Registrado con Exito",
		                type: "success" 
		            },
		            function(){
		                location.reload();
		            });
				},
				error: function(result){
						swal("Opss..!", "Error al registrar el dato", "error");
				}
			});
		});
	}else if(checkPrecio.checked){
		console.log("CHECKED PRECIO");
		solcam_cantidad = $("#cantidad4").val();
		solcam_costo_unitario = $("#costoUnitarioNuevo").val();
		solcam_costo_total = $("#costoTotal4").val(); 
		solcam_peso_caja = $("#pesoCaja4").val();
		solcam_nro_recibo = $("#nroRecibo4").val();
		solcam_tipo_id = $("#checkPrecio").val();
		swal({   title: "Esta seguro de enviar la solicitud?",
	      text: "Se cambiara el precio: "+ $("#costoUnitarioActual4").val() +" a "+ solcam_costo_unitario+" tiene un costo total de: "+solcam_costo_total+" a modificar.",
	      type: "warning",   showCancelButton: true,
	      confirmButtonColor: "#28A345",
	      confirmButtonText: "SI",
	      closeOnConfirm: false
	    }, function(){
	           
			$.ajax({
				url: route,
				headers: {'X-CSRF-TOKEN': token},
				type: 'POST',
				dataType: 'json',
				data: {
					'solcam_aco_id':$("#id_acopio").val(),
					'solcam_usr_id':$("#id_comprador").val(),
					'solcam_cantidad':solcam_cantidad,
					'solcam_costo_unitario':solcam_costo_unitario,
					'solcam_costo_total':solcam_costo_total,
					'solcam_peso_caja':solcam_peso_caja,
		            'solcam_nro_recibo':solcam_nro_recibo,
		            'solcam_tipo_id':solcam_tipo_id,
		            'solcam_observacion':$("#observacion_sol").val()
		            				
		        },
				success: function(data){
					$("#myCreateCambioModificacion").modal('toggle');
					swal({ 
		            	title: "Exito",
		                text: "Registrado con Exito",
		                type: "success" 
		            },
		            function(){
		                location.reload();
		            });
				},
				error: function(result){
						swal("Opss..!", "Error al registrar el dato", "error");
				}
			});
		});
	}
	// swal({   title: "Esta seguro de enviar la solicitud?",
 //      text: "por que el cambio _____ a _____ tiene un costo de ______ a modificar.",
 //      type: "warning",   showCancelButton: true,
 //      confirmButtonColor: "#28A345",
 //      confirmButtonText: "SI",
 //      closeOnConfirm: false
 //    }, function(){
           
	// 	$.ajax({
	// 		url: route,
	// 		headers: {'X-CSRF-TOKEN': token},
	// 		type: 'POST',
	// 		dataType: 'json',
	// 		data: {
	// 			'solcam_aco_id':$("#id_acopio").val(),
	// 			'solcam_usr_id':$("#id_comprador").val(),
	// 			'solcam_cantidad':solcam_cantidad,
	// 			'solcam_costo_unitario':solcam_costo_unitario,
	// 			'solcam_costo_total':solcam_costo_total,
	// 			'solcam_peso_caja':solcam_peso_caja,
	//             'solcam_nro_recibo':solcam_nro_recibo,
	//             'solcam_tipo_id':solcam_tipo_id,
	//             'solcam_observacion':$("#observacion_sol").val()
	            				
	//         },
	// 		success: function(data){
	// 			$("#myCreateCambioModificacion").modal('toggle');
	// 			swal({ 
	//             	title: "Exito",
	//                 text: "Registrado con Exito",
	//                 type: "success" 
	//             },
	//             function(){
	//                 location.reload();
	//             });
	// 		},
	// 		error: function(result){
	// 				swal("Opss..!", "Error al registrar el dato", "error");
	// 		}
	// 	});
	// });
		    
});
 
});


var table =$('#lts-historicosRealizadas').DataTable( {   
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/SolicitudCambioRealizadasCreate",
            "columns":[
                // {data: 'acciones',orderable: false, searchable: false},
                {data: 'solcam_id'},
                {data: 'solcam_fecha_registro'},
                {data: 'tipoSolicitud'},
                {data: 'solcam_observacion'},
                {data: 'estadoSolicitud'},
                {data: 'nombreComprador'}
        ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
</script>
@endpush