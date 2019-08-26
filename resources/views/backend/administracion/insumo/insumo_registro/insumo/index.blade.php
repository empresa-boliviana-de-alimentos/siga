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
@include('backend.administracion.insumo.insumo_registro.insumo.partials.modalCreate')
@include('backend.administracion.insumo.insumo_registro.insumo.partials.modalUpdate')
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-2">
                <a type="button" class="btn btn-danger fa fa-arrow-left" href="{{ url('InsumoRegistrosMenu') }}"></span><h7 style="color:#ffffff">&nbsp;&nbsp;VOLVER</h7></a>
            </div>
            <div class="col-md-7 text-center">
                <p class="panel-title">LISTA DE INSUMOS</p>
            </div>
            
            <div class="col-md-3 text-right">
                <button class="btn pull-right btn-default" style="background: #616A6B"  data-target="#myCreateIns" data-toggle="modal"><h6 style="color: white">+&nbsp;NUEVO INSUMO</h6></button>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <table class="col-md-12 table-bordered table-striped responsive table-condensed cf" id="lts-insumo">
            <thead class="cf">
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        CODIGO
                    </th>
                    <th>
                        TIPO
                    </th>
                    <th>
                        NOMBRE GENÉRICO
                    </th>
                    <th>
                        UNIDAD MEDIDA
                    </th>
                    <th>
                        PARTIDA
                    </th>
                    <th>
                        ESTADO
                    </th>
                    <th>                        
                        OPCIONES
                    </th>
                </tr>
            </thead>
                <tr>
                </tr>
        </table>
    </div>
</div>
@endsection
@push('scripts')
<script>
     var t = $('#lts-insumo').DataTable( {
      
         "processing": true,
            "serverSide": true,
            "ajax": "/Insumo/create/",
            "columns":[
                {data: 'ins_id'},                
                {data: 'ins_codigo'},
                {data: 'tins_nombre'},
                {data: 'nombre_generico'},
                {data: 'umed_nombre'},
                {data: 'part_nombre'},              
                {data: 'ins_estado'},
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

    function Limpiar(){
        $("#codigo").val("");
        $("#id_cat").val(""); 
        $("#id_part").val("");
        $("#id_uni").val(""); 
        $("#descripcion").val("");
        $("#id_tip_ins").val(""); 
      }

        $("#registroIns").click(function(){
            var route="/Insumo";
            var token =$("#token").val();
            var unidadmed;
            if ($('#id_uni').val()) {
                //console.log("Existe");
                unidadmed = $('#id_uni').val();
            }else if($('#id_uni_ins').val()){
                //console.log("No existe");
                unidadmed = $('#id_uni_ins').val();
            }else{
                unidadmed = $('#id_uni_ins_map').val();
            }
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: {
                'codigo_insumo':$("#codigo").val(),
                //'categoria_insumo':$("#id_cat").val(),
                'partida_insumo':$("#id_part").val(),
                'unidad_medida':unidadmed,
                'descripcion_insumo':$("#descripcion").val(),
                'tipo_de_insumo':$("#id_tip_ins").val(),
                'tipo_envase':$("#id_tip_env").val(),
                'linea_produccion':$('#id_linea_prod').val(),
                'mercado':$('#id_mercado').val(),
                'formato':$('#formato').val(),
                'municipio':$('#id_municipio').val(),
                'producto_especifico':$('#id_prod_especifico').val(),
                'sabor':$('#id_sabor').val(),
                'color':$('#id_color').val(),
                'presentacion':$('#presentacion').val(),  
                },
                success: function(data){
                    $("#myCreateIns").modal('toggle');Limpiar();
                    swal("Insumo!", "registro correcto","success");
                    $('#lts-insumo').DataTable().ajax.reload();
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

        function MostrarInsumo(btn){
            var route = "/Insumo/"+btn.value+"/edit";
            $.get(route, function(res){
                console.log(res);
                $("#descripcion1").val(res.ins_desc);
                $("#ins_id_tip_ins1").val(res.ins_id_tip_ins);
                $("#ins_id_part1").val(res.ins_id_part);
                $("#ins_id1").val(res.ins_id);
                var id_tipins1 = res.ins_id_tip_ins;
                if (id_tipins1==1) {
                    $('#tipo_insumo1').show();
                    $('#tipo_envase1').hide();
                    $('#tipo_insumo_map1').hide();
                    // INSERT DATOS
                    $('#id_sabor1').val(res.ins_id_sabor);
                    $('#id_color1').val(res.ins_id_color);
                    $('#presentacion1').val(res.ins_peso_presen);
                    $('#id_uni_ins1').val(res.ins_id_uni);
                    // END INSERT DATOS
                    $('#id_tip_env1').val("");
                    $('#id_linea_prod1').val("");
                    $('#id_mercado1').val("");
                    $('#formato1').val("");
                    $('#id_uni1').val("");
                    $('#id_municipio1').val("");
                    $('#id_prod_especifico1').val("");              
                }else if(id_tipins1==2){      
                   $('#tipo_envase1').show();
                   $('#tipo_insumo1').hide();
                   $('#tipo_insumo_map1').hide();
                   // INSERT DATOS
                    $('#id_tip_env1').val(res.ins_id_tip_env);
                    $('#id_linea_prod1').val(res.ins_id_linea_prod);
                    $('#id_mercado1').val(res.ins_id_mercado);
                    $('#formato1').val(res.ins_formato);
                    $('#id_uni1').val(res.ins_id_uni);
                    $('#id_municipio1').val(res.ins_id_municipio);
                    $('#id_prod_especifico1').val(res.ins_id_prod_especi); 
                   // END INSERT DATOS
                   $('#id_sabor1').val("");
                   $('#id_color1').val("");
                   $('#presentacion1').val("");
                   $('#id_uni1').val("");  
                }else if(id_tipins1==3){
                    $('#tipo_insumo1').hide();
                    $('#tipo_envase1').hide();
                    $('#tipo_insumo_map1').show();
                    // INSET DATOS
                    $('#id_uni_ins_map1').val(res.ins_id_uni);
                    // END INSETT DATOS
                    $('#id_tip_env1').val("");
                    $('#id_linea_prod1').val("");
                    $('#id_mercado1').val("");
                    $('#formato1').val("");
                    $('#id_uni1').val("");
                    $('#id_municipio1').val("");
                    $('#id_prod_especifico1').val("");
                }else{
                    $('#tipo_insumo1').show();
                    $('#tipo_envase1').hide();
                    $('#tipo_insumo_map1').hide();
                    // INSERT DATOS
                    $('#id_sabor1').val(res.ins_id_sabor);
                    $('#id_color1').val(res.ins_id_color);
                    $('#presentacion1').val(res.ins_peso_presen);
                    $('#id_uni_ins1').val(res.ins_id_uni);
                    // END INSERT DATOS
                    $('#id_tip_env1').val("");
                    $('#id_linea_prod1').val("");
                    $('#id_mercado1').val("");
                    $('#formato1').val("");
                    $('#id_uni1').val("");
                    $('#id_municipio1').val("");
                    $('#id_prod_especifico1').val("");
                }
                $("#ins_id1").val(res.ins_id);
                $("#codigo1").val(res.ins_codigo);
                $("#id_cat1").val(res.ins_id_cat);
                $("#id_part1").val(res.ins_id_part);
                $("#id_uni1").val(res.ins_id_uni);
                $("#descripcion1").val(res.ins_desc);
                $("#id_tip_ins1").val(res.ins_id_tip_ins);
            });
        }

        $("#actualizarIns").click(function(){
        var value = $("#ins_id1").val();
        var route="/Insumo/"+value+"";
        var token =$("#token").val();
        var unidadmededit;
            if ($('#id_uni1').val()) {
                //console.log("Existe");
                unidadmededit = $('#id_uni1').val();
            }else if($('#id_uni_ins1').val()){
                //console.log("No existe");
                unidadmededit = $('#id_uni_ins1').val();
            }else{
                unidadmededit = $('#id_uni_ins_map1').val();
            }
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',
            dataType: 'json',
            data: {
                //'codigo_insumo':$("#codigo").val(),
                'ins_id_part':$("#ins_id_part1").val(),
                'ins_id_uni':unidadmededit,
                'ins_desc':$("#descripcion1").val(),
                'ins_id_tip_ins':$("#ins_id_tip_ins1").val(),
                'ins_id_tip_env':$("#id_tip_env1").val(),
                'ins_id_linea_prod':$('#id_linea_prod1').val(),
                'ins_id_mercado':$('#id_mercado1').val(),
                'ins_formato':$('#formato1').val(),
                'ins_id_municipio':$('#id_municipio1').val(),
                'ins_id_prod_especi':$('#id_prod_especifico1').val(),
                'ins_id_sabor':$('#id_sabor1').val(),
                'ins_id_color':$('#id_color1').val(),
                'ins_peso_presen':$('#presentacion1').val(), 
                  },
                        success: function(data){
                $("#myUpdateIns").modal('toggle');
                swal("Insumo!", "edicion exitosa!", "success");
                $('#lts-insumo').DataTable().ajax.reload();

            },  error: function(result) {
                    console.log(result);
                    swal("Opss..!", "Edicion rechazada", "error");
            }
        });
        });

        function Eliminar(btn){
        var route="/Insumo/"+btn.value+"";
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
                        $('#lts-insumo').DataTable().ajax.reload();
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
