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
@include('backend.administracion.insumo.insumo_registro.ufv.partials.modalCreate')
@include('backend.administracion.insumo.insumo_registro.ufv.partials.modalUpdate')
<div class="panel panel-primary">
    <div class="panel-heading" style="background-color: #202040">
        <div class="row">
            <div class="col-md-2">
                <a type="button" class="btn btn-danger fa fa-arrow-left" href="{{ url('InsumoRegistrosMenu') }}"></span><h7 style="color:#ffffff">&nbsp;&nbsp;VOLVER</h7></a>
            </div>
            <div class="col-md-7 text-center">
                <p class="panel-title">LISTA DE REGISTRO UFV</p>
            </div>
            
            <div class="col-md-3 text-right">
                <a href="{{ url('ReporteUfvExcel') }}" class="btn pull-right btn-success" data-target="" data-toggle="modal"><h6 style="color: white;"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp;EXPORTAR EXCEL</h6></a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <table class="col-md-12 table-bordered responsive table-striped table-condensed cf" id="lts-ufv" style="width:100%">
            <thead class="cf">
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        FECHA
                    </th>
                    <th>
                        VALOR UFV
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
    var t = $('#lts-ufv').DataTable( {
      
         "processing": true,
            "serverSide": true,
            "ajax": "/UfvInsumo/create/",
            "columns":[
                {data: 'ufv_id'},
                //{data: 'acciones',orderable: false, searchable: false},
                {data: 'ufv_registrado'},
                {data: 'ufv_cant'},
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

    function Limpiar(){
        $("#cantidad").val("");
    }

    $("#registroUfv").click(function(){
        var route="/UfvInsumo";
        var token =$("#token").val();
        $.ajax({
            url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: {
                //'ufv_registrado':$("#fechareg").val(),
                'ufv':$("#cantidad").val(),
                },
                success: function(data){
                    $("#myCreateUfv").modal('toggle');Limpiar();
                    swal("Ufv!", "registro correcto","success");
                    $('#lts-ufv').DataTable().ajax.reload();
                    location.reload('/UfvInsumo');
                    
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

        function MostrarUfv(btn){
            var route = "/UfvInsumo/"+btn.value+"/edit";
            $.get(route, function(res){
                $("#ufv_id1").val(res.ufv_id);
                $("#ufv_cant1").val(res.ufv_cant);
                $("#ufv_registrado1").val(res.ufv_registrado);
            });
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
