@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.insumo.insumo_registro.insumo.partials.modalCreate')
@include('backend.administracion.insumo.insumo_registro.insumo.partials.modalUpdate')
<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-1">
                    <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('InsumoRegistrosMenu') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
                </div>
                <div class="col-md-8">
                     <h4><label for="box-title">LISTA DE INSUMOS</label></h4>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-2">
                <button class="btn pull-right btn-default" style="background: #616A6B" data-target="#myCreateIns" data-toggle="modal"><h6 style="color: white">+&nbsp;NUEVO INSUMO</h6></button>
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
                        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-insumo">
                            <thead class="cf">
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        Operaciones
                                    </th>
                                    <th>
                                        Codigo
                                    </th>
                                    <th>
                                        Tipo
                                    </th>
                                    <th>
                                        Nombre Genérico
                                    </th>
                                    <th>
                                        Partida
                                    </th>
                                    <th>
                                        U. Medida
                                    </th>
                                    <th>
                                        Peso/Formato
                                    </th>
                                    <th>
                                        Estado
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
     var t = $('#lts-insumo').DataTable( {
      
         "processing": true,
            "serverSide": true,
            "ajax": "/Insumo/create/",
            "columns":[
                {data: 'ins_id'},
                {data: 'acciones',orderable: false, searchable: false},
                {data: 'ins_codigo'},
                {data: 'tins_nombre'},
                {data: 'nombre_generico'},
                {data: 'part_nombre'},
                {data: 'umed_nombre'},
                {data: 'peso_formato'},                
                {data: 'ins_estado'}
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
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',
            dataType: 'json',
            data: {
                    'ins_codigo':$("#codigo1").val(),
                    'ins_id_cat':$("#id_cat1").val(),
                    'ins_id_part':$("#id_part1").val(),
                    'ins_id_uni':$("#id_uni1").val(),
                    'ins_desc':$("#descripcion1").val(),
                    'ins_id_tip_ins':$("#id_tip_ins1").val(),
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
