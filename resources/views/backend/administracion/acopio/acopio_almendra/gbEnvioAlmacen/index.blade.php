@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.acopio.acopio_almendra.gbEnvioAlmacen.partials.modalCreateEnvio')
@include('backend.administracion.acopio.acopio_almendra.gbEnvioAlmacen.partials.modalBoletaEnvioAlm')

<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-8">
                     <h4><label for="box-title">Envio Almacen</label></h4>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-2">
                <button class="btn fa fa-plus-square pull-right btn-dark"  data-target="#myCreateEnvioAlm" data-toggle="modal">&nbsp;Nuevo Envio</button>
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
                        <!-- <div class="col-md-3">
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
                        </div> -->
                        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-enviosalmacen" style="width:100%">
                            <thead class="cf">
                                <tr>
                                    <th>
                                        Operaciones
                                    </th>
                                    <th>
                                        Nota de Envio
                                    </th>
                                    <th>
                                        Cantidad Envio
                                    </th>
                                    <th>
                                        Costo total de Envio
                                    </th>
                                    <th>
                                        Planta Destino
                                    </th>
                                    <th>
                                        Estado de Envio
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
    var table = $('#lts-enviosalmacen').DataTable( {
            "responsive":true,
            "processing": true,
            "serverSide": true,
            "ajax": "/EnvioAcopioAlm/create/",
            "columns":[ 
                {data: 'acciones',orderable: false, searchable: false},
                {data: 'enval_nro_env'},
                {data: 'enval_cant_total'},
                {data: 'enval_cost_total'},
                {data: 'nombre_planta'},
                {data: 'enval_estado'},
        ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
       
    });

    // $('#buscarpat').on( 'keyup', function () {
    // table
    //     .columns( 1 )
    //     .search( this.value )
    //     .draw();
    // } );

    // $('#buscarmat').on( 'keyup', function () {
    // table
    //     .columns( 2 )
    //     .search( this.value )
    //     .draw();
    // } );

    // $('#buscarnom').on( 'keyup', function () {
    // table
    //     .columns( 3 )
    //     .search( this.value )
    //     .draw();
    // } );
});

        // function MostrarProveedor(btn){
        //     var route = "/Proveedor/"+btn.value+"/edit";
        //     $.get(route, function(res){
        //         $("#id_proveedor1").val(res.prov_id);
        //         $("#nombres1").val(res.prov_nombre);
        //         $("#apellido_paterno1").val(res.prov_ap);
        //         $("#apellido_materno1").val(res.prov_am);
        //         $("#ci1").val(res.prov_ci);
        //         $("#exp1").val(res.prov_exp);
        //         $("#telefono1").val(res.prov_tel);
        //         $("#id_tipo_prov1").val(res.prov_id_tipo);
        //         $("#id_convenio1").val(res.prov_id_convenio);
        //         $("#id_departamento1").val(res.prov_departamento);
        //         $("#id_municipio1").val(res.prov_id_municipio);
        //         $("#id_comunidad1").val(res.prov_id_comunidad);
        //         $("#id_comprador1").val(res.prov_id_usr);
        //         $("#img1").val(res.prov_foto);
        //     });
        // }


    // function Limpiar(){
    //     $("#nombres").val("");$("#apellido_paterno").val("");$("#apellido_materno").val("");$("#ci").val("");$("#exp").val("");
    //     $("#telefono").val("");$("#id_tipo_prov").val("");$("#id_convenio").val("");$("#id_departamento").val("");$("#id_municipio").val("");
    //     $("#id_comunidad").val("");$("#id_asociacion").val("");
        
    //     //$('#proveedor').data('bootstrapValidator').resetForm();
    // }

        $("#envioAlm").click(function(){
            var route="/EnvioAcopioAlm";
            var token =$("#token").val();
            swal({   title: "Confirmacion de envio a Almacen?",
              text: "Usted esta seguro de enviar los totales a Almacen",
              type: "warning",   
              showCancelButton: true,
              confirmButtonColor: "#28A345",
              confirmButtonText: "Enviar!",
              closeOnConfirm: true
            },function(){
                $.ajax({
                    url: route,
                    headers: {'X-CSRF-TOKEN': token},
                    type: 'POST',
                    dataType: 'json',
                    data: {
                    'enval_cant_total':$("#enval_cant_total").val(),
                    'enval_cost_total':$("#enval_cost_total").val(),
                    'enval_registro':$("#enval_registro").val(),
                    'planta_destino':$("#enval_destino").val(),         
                    },
                    success: function(data){
                        // $("#myCreateEnvioAlm").modal('toggle');
                        // swal("Acceso!", "registro correcto","success");
                        // $('#lts-enviosalmacen').DataTable().ajax.reload();

                        console.log('id del envio_alm: '+data.enval_id);
                        $('#idBolEnvioAlm').val(data.enval_id);
                        $('#iframeboletaEnvioAlm').attr('src', 'boletaEnvioAlm/'+data.enval_id);
                        $('#myBoletaEnvioAlm').modal('show'); 
                        $("#myCreateEnvioAlm").modal('toggle');
                        $('#lts-enviosalmacen').DataTable().ajax.reload();
                    },
                    error: function(result)
                    {
                    // swal("Opss..!", "Error al registrar el dato", "error");
                        var errorCompleto='Tiene los siguientes errores: ';
                        $.each(result.responseJSON.errors,function(indice,valor){
                            errorCompleto = errorCompleto + valor+' ' ;                       
                        });
                        swal("Opss..., Hubo un error!",errorCompleto,"error");
                    }
                });
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


@endpush