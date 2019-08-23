@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.acopio.acopio_almendra.gbAcopios.partials.modalCreate')

<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-1">
                <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('AcopioAlmendraMenu') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
                </div>

                <div class="col-md-8">
                     <h4><label for="box-title">Acopios Realizados de Almendra</label></h4>
                </div>
                
                <div class="col-md-2"> 
                    
                    <center><b>Monto Asignado Bs.- {{ $total }}</b> 
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<center><b>Monto Utilizado Bs.- {{ $total2}}</b></center><br>
                    <center><b>Monto Actual Bs.- {{ $total3 }}</b></center><br> 
                </div>

            </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border"></div>
                    <div class="box-body">
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="col-sm-12">
                                  <label>
                                      BUSQUEDA POR AP PATERNO:
                                  </label>
                                  <input type="text" name="buscarpat" id="buscarpat" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="col-sm-12">
                                  <label>
                                      AP MATERNO:
                                  </label>
                                  <input type="text" name="buscarmat" id="buscarmat" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="col-sm-12">
                                  <label>
                                      NOMBRES:
                                  </label>
                                  <input type="text" name="buscarnom" id="buscarnom" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                        </div>
                        <div id="no-more-tables">
                            <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-acopio" style="width:100%">
                                <thead class="cf">
                                    <tr>
                                        <th>
                                            Operaciones
                                        </th>
                                        <th>
                                            Ap. Paterno
                                        </th>
                                        <th>
                                            Ap. Materno
                                        </th>
                                        <th>
                                            Nombres
                                        </th>
                                        <th>
                                            Cedula
                                        </th>
                                        <th>
                                            Nro Acopio/Venta
                                        </th>
                                        <th>
                                            Nro Cajas
                                        </th>
                                        <th>
                                            Peso
                                        </th>
                                        <th>
                                            Total
                                        </th>
                                    </tr>
                                </thead>
                            </table>
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
            "ajax": "/Acopio/create",
            "columns":[
                {data: 'acciones',orderable: false, searchable: false},
                {data: 'prov_ap1'},
                {data: 'prov_am1'},
                {data: 'prov_nombre1'},
                {data: 'prov_ci1'},
                {data: 'aco_numaco1'},
                {data: 'aco_cantidad1'},
                {data: 'aco_peso_neto1'},
                {data: 'aco_cos_total1'},
        ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });

     $('#buscarpat').on( 'keyup', function () {
    table
        .columns( 1 )
        .search( this.value )
        .draw();
    } );

    $('#buscarmat').on( 'keyup', function () {
    table
        .columns( 2 )
        .search( this.value )
        .draw();
    } );

    $('#buscarnom').on( 'keyup', function () {
    table
        .columns( 3 )
        .search( this.value )
        .draw();
    } );
 
});


		function MostrarRegistro(btn){
			var route = "/Acopio/"+btn.value+"/edit";
            console.log ('idprov',route);
			$.get(route, function(res){
                 $("#id_prov").val(res.prov_id);
                 $("#nombre").val(res.prov_nombre);
                 //var aconumaco = parseInt(res.nroaco)+1;
		 if(res.nroaco == null) {
                    //console.log("Es NAN");
                    var aconumaco = 1;
                 }else {
                    console.log(res.nroaco);
                    var aconumaco = parseInt(res.nroaco)+1;
                 }
                 document.getElementById("nombre_prov").innerHTML = res.prov_ap+' '+res.prov_am+' '+res.prov_nombre;
                 var val = $("#id_prov").val();
                 document.getElementById("aconumaconuevo").innerHTML = aconumaco;			});
		}

         function Limpiar(){
        $("#proveedor").val("");$("#centro_acopio").val("");$("#nro_recibo").val("");$("#peso_neto").val("");$("#id_tipo").val("");$("#cantidad").val("");$("#id_unidad").val("");$("#costo").val("");$("#total").val("");$("#fecha_acopio").val("");$("#id_lugar").val("");$("#id_comunidad").val("");$("#observacion").val("");      
        }

		$("#registroAcopio").click(function(){
			var value =$("#id_prov").val();
            console.log ('idproveeee',value);
			var route="/Acopio";
			var token =$("#token").val();
		var monto = parseFloat($("#total").val());
            var montoActual =parseFloat($("#montoActual").val());
            if(monto > montoActual ){
               swal("Lo Siento!", "El monto total supera al monto que tiene Asignado");
               return;
            }
            // else if($("#id_comunidad").val() == null){
            //     swal("Lo siento", "Debe Elegir una comunidad");
            // }
            else{

			$.ajax({
				url: route,
				headers: {'X-CSRF-TOKEN': token},
				type: 'POST',
				dataType: 'json',
				data: {
				'aco_id_prov':$("#id_prov").val(),
				'aco_centro':$("#centro_acopio").val(),
				'aco_num_rec':$("#nro_recibo").val(),
				'aco_peso_neto':$("#peso_neto").val(),
				'aco_id_tipo_cas':$("#id_tipo").val(),
				'aco_cantidad':$("#cantidad").val(),
                'aco_unidad':$("#id_unidad").val(),
                'aco_cos_un':$("#costo").val(),
                'aco_cos_total':$("#total").val(),
                'aco_fecha_acop':$("#fecha_acopio").val(),
                'aco_id_proc':$("#id_lugar").val(),
                // 'aco_id_comunidad':$("#id_comunidad").val(),
                'aco_obs':$("#observacion").val(),
		'aco_montoactual': $("#montoActual").val(),
		'aco_plus' : $("#aco_plus").val(),				
                },
				success: function(data){
					$("#myCreate").modal('toggle');Limpiar();
					//swal("Acceso!", "registro correcto","success");
					//$('#lts-acopio').DataTable().ajax.reload();
					// location.reload();
					swal({ 
                              			title: "Exito",
                               			text: "Registrado con Exito",
                                		type: "success" 
                              			},
                              		function(){
                                		location.reload();
                        		});
				},
				error: function(result)
				{
				swal("Opss..!", "Error al registrar el dato", "error");
				}
			});
		    }
		});

        $("#registroComunidad").click(function(){
            var route="/RegComunidad";
            var token =$("#token").val();
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: {
                'com_nombre':$("#com_comunidad1").val(),
                'com_id_mun':$("#com_municipio1").val(),          
                },
                success: function(data){
                    $("#myCreateComunidad").modal('toggle');
                    swal("Acceso!", "registro correcto","success");
                   // $('#lts-proveedor').DataTable().ajax.reload();
                },
                error: function(result)
                {
                swal("Opss..!", "Error al registrar el dato", "error");
                }
            });
        });

</script>
<script type="text/javascript">
    $("#img").fileinput({
    showCaption: false,
    browseClass: "btn btn-primary btn-lg",
    fileType: "any"
    });
</script>
<script type="text/javascript">
    $('.datepicker').datepicker({
                format: "yyyy-mm-dd",
                language: "es",
                autoclose: true
            });
        
            var fecha= new Date();
            var vDia; 
            var vMes;

            if ((fecha.getMonth()+1) < 10) { vMes = "0" + (fecha.getMonth()+1); }
            else { vMes = (fecha.getMonth()+1); }

            if (fecha.getDate() < 10) { vDia = "0" + fecha.getDate(); }
            else{ vDia = fecha.getDate(); }
</script>
<script type="text/javascript">
   /* $(document).ready(function() {
                $('#acceso').bootstrapValidator({
                    message: 'Valor errado',
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    },
                    fields: {
                        opc_opcion: {
                            message: 'Registro no valido',
                            validators: {
                                notEmpty: {
                                    message: 'Dato requerido'
                                },
                                stringLength: {
                                    min: 4,
                                    max: 100,
                                    message: 'Campo mayor a 4 caracteres y un maximo de 50'
                                },
                                regexp: {
                                    regexp: /(\s*[a-zA-Z]+$)/,
                                    message: 'Solo caracteres alfabeticos'
                                }
                            }
                        },
                    }
                });
            });*/
</script>
@endpush
