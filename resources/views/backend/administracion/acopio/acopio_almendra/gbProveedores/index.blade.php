@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.acopio.acopio_almendra.gbProveedores.partials.modalCreate')
@include('backend.administracion.acopio.acopio_almendra.gbProveedores.partials.modalUpdate')
<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-1">
                <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('AcopioAlmendraMenu') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
                </div>
                <div class="col-md-8">
                     <h4><label for="box-title">Proveedores de Almendra</label></h4>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-2">
                <button class="btn fa fa-plus-square pull-right btn-dark"  data-target="#myCreate" data-toggle="modal">&nbsp;Nuevo</button>
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
                        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-proveedor" style="width:100%">
                            <thead class="cf">
                                <tr>
                                    <th>
                                        Operaciones
                                    </th>
                                    <th>
                                        Paterno
                                    </th>
                                    <th>
                                        Materno
                                    </th>
                                    <th>
                                        Nombres
                                    </th>
                                    <th>
                                        Cedula
                                    </th>
                                    <th>
                                        Telefono
                                    </th>
                                </tr>
                            </thead>
                            <tr>
                            </tr>
                    </table>
                </div>    
            </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    var table = $('#lts-proveedor').DataTable( {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/Proveedor/create/",
            "columns":[
                {data: 'acciones',orderable: false, searchable: false},
                {data: 'prov_ap'},
                {data: 'prov_am'},
                {data: 'prov_nombre'},
                {data: 'ci'},
                {data: 'prov_tel'},
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

		function MostrarProveedor(btn){
			var route = "/Proveedor/"+btn.value+"/edit";
			$.get(route, function(res){
                $("#id_proveedor1").val(res.prov_id);
				$("#nombres1").val(res.prov_nombre);
				$("#apellido_paterno1").val(res.prov_ap);
				$("#apellido_materno1").val(res.prov_am);
				$("#ci1").val(res.prov_ci);
				$("#exp1").val(res.prov_exp);
				$("#telefono1").val(res.prov_tel);
				$("#id_tipo_prov1").val(res.prov_id_tipo);
                $("#id_convenio1").val(res.prov_id_convenio);
                $("#id_departamento1").val(res.prov_departamento);
                $("#id_municipio1").val(res.prov_id_municipio);
                $("#id_comunidad1").val(res.prov_id_comunidad);
                $("#id_comprador1").val(res.prov_id_usr);
                $("#img1").val(res.prov_foto);
			});
		}


    function Limpiar(){
        $("#nombres").val("");$("#apellido_paterno").val("");$("#apellido_materno").val("");$("#ci").val("");$("#exp").val("");
        $("#telefono").val("");$("#id_tipo_prov").val("");$("#id_convenio").val("");$("#id_departamento").val("");$("#id_municipio").val("");
        $("#id_comunidad").val("");$("#id_asociacion").val("");
        
        //$('#proveedor').data('bootstrapValidator').resetForm();
    }

		$("#registro").click(function(){
			var route="/Proveedor";
			var token =$("#token").val();
			$.ajax({
				url: route,
				headers: {'X-CSRF-TOKEN': token},
				type: 'POST',
				dataType: 'json',
				data: {
				'prov_nombre':$("#nombres").val(),
				'prov_ap':$("#apellido_paterno").val(),
				'prov_am':$("#apellido_materno").val(),
				'prov_ci':$("#ci").val(),
				'prov_exp':$("#exp").val(),
				'prov_tel':$("#telefono").val(),
                'prov_id_tipo':$("#id_tipo_prov").val(),
                'prov_id_convenio':$("#id_convenio").val(),
                'prov_departamento':$("#id_departamento").val(),
                'prov_id_municipio':$("#id_municipio").val(),
                'prov_id_comunidad':$("#id_comunidad").val(),
                'prov_id_asociacion':$("#id_asociacion").val(),
               // 'prov_foto':$("#img").val(),			
                },
				success: function(data){
					$("#myCreate").modal('toggle');Limpiar();
					swal("Acceso!", "registro correcto","success");
                   // $('#proveedor').data('bootstrapValidator').resetForm();
					$('#lts-proveedor').DataTable().ajax.reload();
				},
				error: function(result)
				{
				swal("Opss..!", "Error al registrar el dato", "error");
				}
			});
		});

        $("#registroMunicipio").click(function(){
            var route="/RegMunicipio";
            var token =$("#token").val();
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: {
                'mun_nombre':$("#m_municipio").val(),
                'mun_id_dep':$("#m_departamento").val(),          
                },
                success: function(data){
                    $("#myCreateMunicipio").modal('toggle');
                    swal("Acceso!", "registro correcto","success");
                    //$('#myCreate').modal().ajax.reload();
                },
                error: function(result)
                {
                swal("Opss..!", "Error al registrar el dato", "error");
                }
            });
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
                'com_nombre':$("#com_comunidad").val(),
                'com_id_mun':$("#com_municipio").val(),          
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

        $("#registroAsociacion").click(function(){
            var route="/RegAsociacion";
            var token =$("#token").val();
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: {
                'aso_nombre':$("#as_asociacion").val(),
                'aso_sigla':$("#as_sigla").val(),    
                'aso_id_mun':$("#as_municipio").val(), 
                },
                success: function(data){
                    $("#myCreateAsociacion").modal('toggle');
                    swal("Acceso!", "registro correcto","success");
                   // $('#lts-proveedor').DataTable().ajax.reload();
                },
                error: function(result)
                {
                swal("Opss..!", "Error al registrar el dato", "error");
                }
            });
        });

		$("#actualizar").click(function(){
        var value = $("#id_proveedor1").val();
        // alert("este texto es el que modificas",value);
        var route="/Proveedor/"+value+"";
        var token =$("#token").val();
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',
            dataType: 'json',
			data: {
					'prov_nombre':$("#nombres1").val(),
                    'prov_ap':$("#apellido_paterno1").val(),
                    'prov_am':$("#apellido_materno1").val(),
                    'prov_ci':$("#ci1").val(),
                    'prov_exp':$("#exp1").val(),
                    'prov_tel':$("#telefono1").val(),
                    'prov_id_tipo':$("#id_tipo_prov1").val(),
                    'prov_id_convenio':$("#id_convenio1").val(),
                    'prov_departamento':$("#id_departamento1").val(),
                    'prov_id_municipio':$("#id_municipio1").val(),
                    'prov_id_comunidad':$("#id_comunidad1").val(),
                    'prov_id_usr':$("#id_comprador1").val(),
				  },
						success: function(data){
                $("#myUpdate").modal('toggle');
                swal("Proveedor!", "edicion exitosa!", "success");
                $('#lts-proveedor').DataTable().ajax.reload();

            },  error: function(result) {
                  console.log(result);
                 swal("Opss..!", "Edicion rechazada", "error")
            }
        });
        });

    function Eliminar(btn){
    var route="/Proveedor/"+btn.value+"";
    var token =$("#token").val();
    swal({   title: "Eliminacion de registro?",
      text: "Uds. esta a punto de eliminar 1 registro",
      type: "warning",   showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Eliminar!",
      closeOnConfirm: false
    }, function(){
       $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'DELETE',
                dataType: 'json',

                success: function(data){
                    $('#lts-proveedor').DataTable().ajax.reload();
                    swal("Acceso!", "El registro fue dado de baja!", "success");
                },
                    error: function(result) {
                        swal("Opss..!", "error al procesar la solicitud", "error")
                }
            });
    });
    }
</script>
<script type="text/javascript">
    $("#img").fileinput({
    showCaption: false,
    browseClass: "btn btn-primary btn-lg",
    fileType: "any"
    });
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
