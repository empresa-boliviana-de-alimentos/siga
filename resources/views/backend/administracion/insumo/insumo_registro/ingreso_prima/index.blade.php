@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.insumo.insumo_registro.ingreso_prima.partials.modalCreate')
<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <div class="col-md-12"  id="contenido">
                    <div class="col-md-1">
                        <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('IngresosInsumo') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
                    </div>
                    <div class="col-md-8">
                         <h4><label for="box-title">LISTA MATERIA PRIMA</label></h4>
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
                        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-prima">
                            <thead class="cf">
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        Operaciones
                                    </th>
                                    <th>
                                        Nombre
                                    </th>
                                    <th>
                                        Fecha
                                    </th>
                                    <th>
                                        Estado
                                    </th>
                                </tr>
                            </thead>
                    </table>
                </div>    
            </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    var t = $('#lts-prima').DataTable( {
         "processing": true,
            "serverSide": true,
            "ajax": "/IngresoPrima/create/",
            "columns":[
                {data: 'enval_id'},
                {data: 'acciones',orderable: false, searchable: false},
                {data: 'codigo'},
                {data: 'enval_registrado'},
                {data: 'enval_estado'},
        ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
         "order": [[ 0, "desc" ]],
     });
    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
     function MostrarEnvio(btn){
            var route = "/IngresoPrima/"+btn.value+"/edit";
            $.get(route, function(res){
                $("#envid").val(res.enval_id);
                $("#nombre_env").val(res.prs_nombres+' '+res.prs_paterno+' '+res.prs_materno);
                $("#cant_env").val(res.enval_cant_total);
            });
        }

    $("#registroMatAprob").click(function(){
            var route="/IngresoPrima";
            var token =$("#token").val();
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: {
                    'id_enval':$("#envid").val(),
                    'cant_enval':$("#cant_env").val(),
                    'unidad':$("#env_uni").val(),
                    'insumo':$("#ins_id").val(),
                    'cantidad':$("#cantidad").val(),
                    'costo':$("#costo").val(),
                    //'insumo':$("#env_insumo").val(),
                   // 'cantidad':$("#cantidad").val(),
                    'obs':$("#env_obs").val(),
                },
                success: function(data){
                    console.log(data);
                    $("#myCreatePrima").modal('toggle');Limpiar();
                    window.open('/ReportePrima/'+data.ing_id,'_blank');
                    swal("Envio de Materia Prima!", "Correcto","success");
                    $('#lts-prima').DataTable().ajax.reload();
                  //  location.reload('/UfvInsumo');
                    
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









     function Limpiar(){
        $("#cantidad").val("");
      }

        

       

        $("#actualizarUfv").click(function(){
        var value = $("#ufv_id1").val();
        var route="/UfvInsumo/"+value+"";
        var token =$("#token").val();
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',
            dataType: 'json',
            data: {
                    'ufv_cant':$("#ufv_cant1").val(),
                  },
                        success: function(data){
                $("#myUpdateUfv").modal('toggle');
                swal("Ufv!", "edicion exitosa!", "success");
                $('#lts-ufv').DataTable().ajax.reload();

            },  error: function(result) {
                  console.log(result);
                 swal("Opss..!", "Edicion rechazada", "error")
            }
        });
        });

        function Eliminar(btn){
        var route="/UfvInsumo/"+btn.value+"";
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
                        $('#lts-ufv').DataTable().ajax.reload();
                        swal("Ufv!", "El registro fue dado de baja!", "success");
                    },
                        error: function(result) {
                            swal("Opss..!", "error al procesar la solicitud", "error")
                    }
                });
        });
        }

        // $(document).ready(function() {
        //     var refreshId =  setInterval( function(){
        //     $('#contenido').load('backend.administracion.insumo.insumo_registro.ufv.index.blade.php');//actualizas el div
        //    }, 1000 );
        // });

</script>
@endpush
