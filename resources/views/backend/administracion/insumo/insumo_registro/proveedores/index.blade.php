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
@include('backend.administracion.insumo.insumo_registro.proveedores.partials.modalCreate')
@include('backend.administracion.insumo.insumo_registro.proveedores.partials.modalUpdate')
@include('backend.administracion.insumo.insumo_registro.proveedores.partials.modalFormEvaluacion')
@include('backend.administracion.insumo.insumo_registro.proveedores.partials.modalListarEvaluacion')
<div class="panel panel-primary">
    <div class="panel-heading" style="background-color:#202040">
        <div class="row">
            <div class="col-md-2">
                <a type="button" class="btn btn-danger fa fa-arrow-left" href="{{ url('InsumoRegistrosMenu') }}"></span><h7 style="color:#ffffff">&nbsp;&nbsp;VOLVER</h7></a>
            </div>
            <div class="col-md-5 text-center">
                <p class="panel-title">LISTA DE PROVEEDORES INSUMOS</p>
            </div>
            <div class="col-md-2 text-center">
                 <a href="ExportarEvalucionProveedores" class="btn btn-success" target="_blank"><h6 style="color: white"><span class="fa fa-file-o"></span> EXPORTAR EVALUACIONES</h6></a>
            </div>
            <div class="col-md-3 text-right">
                <button class="btn pull-right btn-default" style="background: #616A6B"  data-target="#myCreateProv" data-toggle="modal"><h6 style="color: white">+&nbsp;NUEVO PROVEEDOR</h6></button>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-proveedores">
            <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        OPCIONES
                    </th>
                    <th>
                        PROVEEDOR
                    </th>
                    <th>
                        DIRECCIÓN
                    </th>
                    <th>
                        TELÉFONO
                    </th>
                    <th>
                        RESPONSABLE
                    </th>
                    <th>
                        EVAL. PROV.
                    </th>
                </tr>
            </thead>
            <tr></tr>           
        </table>               
    </div>
</div>
@endsection
@push('scripts')
<script>
    var t =  $('#lts-proveedores').DataTable( {
      
         "processing": true,
            "serverSide": true,
            "ajax": "/ProveedorInsumo/create/",
            "columns":[
                {data: 'prov_id'},
                {data: 'acciones',orderable: false, searchable: false}, 
                {data: 'prov_nom'},
                {data: 'prov_dir'},
                {data: 'prov_tel'},
                {data: 'prov_nom_res'},
                {data: 'evaluacion_prov'}
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

     function Limpiar(){
        $("#nombre").val("");
        $("#direccion").val("");
        $("#telefono").val("");
        $("#nomres").val("");
        $("#apres").val("");
        $("#amres").val("");
        $("#telres").val("");
        $("#obs").val("");
      }
      function LimpiarEvaluacion()
      {
        $("#costo_aprob").val("");
        $("#puntos_costo_aprob").val("");
        $("#fiabilidad").val("");
        $("#puntos_fiabilidad").val("");
        $("#imagen").val("");
        $("#puntos_imagen").val("");
        $("#calidad").val("");
        $("#puntos_calidad").val("");
        $("#plazos").val("");
        $("#puntos_plazos").val("");
        $("#pagos").val("");
        $("#puntos_pagos").val("");
        $("#cooperacion").val("");
        $("#puntos_cooperacion").val("");
        $("#flexibilidad").val("");
        $("#puntos_flexibilidad").val("");
        $("#puntos_totales").val("");
        $("#totales").val("");
        $("#puntos_puntos").val("");
        $("#puntos_porcentaje").val("");
      }

        $("#registroProv").click(function(){
            var route="/ProveedorInsumo";
            var token =$("#token").val();
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: {
                'nombre_proveedor':$("#nombre").val(),
                'prov_dir':$("#direccion").val(),
                'prov_tel':$("#telefono").val(),
                'nombre_responsable':$("#nomres").val(),
                'prov_ap_res':$("#apres").val(),
                'prov_am_res':$("#amres").val(),
                'prov_tel_res':$("#telres").val(),
                'prov_obs':$("#obs").val(),
                },
                success: function(data){
                    $("#myCreateProv").modal('toggle');Limpiar();
                    swal("Proveedor!", "registro correcto","success");
                    $('#lts-proveedores').DataTable().ajax.reload();
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

        function MostrarProv(btn){
            var route = "/ProveedorInsumo/"+btn.value+"/edit";
            $.get(route, function(res){
                $("#prov_id1").val(res.prov_id);
                $("#prov_nom1").val(res.prov_nom);
                $("#prov_dir1").val(res.prov_dir);
                $("#prov_tel1").val(res.prov_tel);
                $("#prov_nom_res1").val(res.prov_nom_res);
                $("#prov_ap_res1").val(res.prov_ap_res);
                $("#prov_am_res1").val(res.prov_am_res);
                $("#prov_tel_res1").val(res.prov_tel_res);
                $("#prov_obs1").val(res.prov_obs);
            });
        }

        $("#actualizarProv").click(function(){
        var value = $("#prov_id1").val();
        var route="/ProveedorInsumo/"+value+"";
        var token =$("#token").val();
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',
            dataType: 'json',
            data: {
                    'prov_nom':$("#prov_nom1").val(),
                    'prov_dir':$("#prov_dir1").val(),
                    'prov_tel':$("#prov_tel1").val(),
                    'prov_nom_res':$("#prov_nom_res1").val(),
                    'prov_ap_res':$("#prov_ap_res1").val(),
                    'prov_am_res':$("#prov_am_res1").val(),
                    'prov_tel_res':$("#prov_tel_res1").val(),
                    'prov_obs':$("#prov_obs1").val(),
                  },
                        success: function(data){
                $("#myUpdateProv").modal('toggle');
                swal("Proveedor!", "edicion exitosa!", "success");
                $('#lts-proveedores').DataTable().ajax.reload();

            },  error: function(result) {
                  console.log(result);
                 swal("Opss..!", "Edicion rechazada", "error")
            }
        });
        });

        function Eliminar(btn){
        var route="/ProveedorInsumo/"+btn.value+"";
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
                        $('#lts-proveedores').DataTable().ajax.reload();
                        swal("Proveedor!", "El registro fue dado de baja!", "success");
                    },
                        error: function(result) {
                            swal("Opss..!", "error al procesar la solicitud", "error")
                    }
                });
        });
        }

        function FormEval(btn){
            var route = "/ProveedorInsumo/"+btn+"/edit";
            $.get(route, function(res){
                console.log(res);
                $('#nombre_proveedor').val(res.prov_nom);
                $('#prov_id_eval').val(res.prov_id);
            });
        }

        $("#registroProvEval").click(function(){
            var route="/EvaluacionProv";
            var token =$("#token").val();
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: {
                    'eval_prov_id':$("#prov_id_eval").val(),
                    'eval_evaluacion':$("#evaluacion").val(),
                    'eval_costo_apro':$("#puntos_costo_aprob").val(),
                    'eval_fiabilidad':$("#puntos_fiabilidad").val(),
                    'eval_imagen':$("#puntos_imagen").val(),
                    'eval_calidad':$("#puntos_calidad").val(),
                    'eval_cumplimientos_plazos':$("#puntos_plazos").val(),
                    'eval_condiciones_pago':$("#puntos_pagos").val(),
                    'eval_capacidad_cooperacion':$("#puntos_cooperacion").val(),
                    'eval_flexibilidad': $("#puntos_flexibilidad").val(),                
                },
                success: function(data){
                    $("#formEvaluacion").modal('toggle');
                    swal("Evaluación Proveedor!", "Registro correcto","success");
                    $('#lts-proveedores').DataTable().ajax.reload();
                    LimpiarEvaluacion();
                },
                error: function(result)
                {
                    var errorCompleto='Tiene los siguientes errores: ';
                    $.each(result.responseJSON.errors,function(indice,valor){
                       errorCompleto = errorCompleto + valor+' ' ;                       
                    });
                    swal("Opss..., Hubo un error!",errorCompleto,"error");
                }
            });
        });

        //LISTAR EVALUACIONES PROVEEDOR
        function MostrarEvaluacion(btn){
            var route = "ListarEvalProv/"+btn;
            $.get(route, function(res){
                console.log(res);
                if (typeof(res[0]) === "undefined") {
                    console.log('No Existe Datos');
                    $("#TableEvaluaciones tr td").remove(); 
                }
                else{
                    console.log('Existe Datos');            
                    //$("#TableEvaluaciones tr td").remove(); 
                    //var nro = 0;
                    $( "#TableEvaluaciones tbody tr" ).each( function(){ this.parentNode.removeChild( this ); }); 
                    var nro = 0;
                    for (i = 0; i < res.length; i++){
                        nro = nro + 1;
                        var totales = res[i].eval_costo_apro+res[i].eval_fiabilidad+res[i].eval_imagen+res[i].eval_calidad+res[i].eval_cumplimientos_plazos+res[i].eval_condiciones_pago+res[i].eval_capacidad_cooperacion+res[i].eval_flexibilidad;
                        var total_puntos = totales/100;
                        var total_porcentaje = (total_puntos/5)*100;
                             $("#TableEvaluaciones").append('<tr class="items_columsReceta3">' + 
                                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+nro+ '"></input></td>'+
                                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+totales+ '"></input></td>'+
                                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+total_puntos+ '"></input></td>'+
                                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+total_porcentaje+ '"></input></td>'+'</tr>');
                        }
                    itemAux = res;
                        
                    
                }
                
            });
        }

        function desc(id){
            if (id == 1) {
                return 'Entrego muy tarde';
            }else if(id == 2){
                return 'Entrego productos dañados';
            }else{
                return 'No Entrego';
            } 
        }
</script>
@endpush


