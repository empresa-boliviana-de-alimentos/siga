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
@include('backend.administracion.insumo.insumo_registro.servicios.partials.modalCreate')
@include('backend.administracion.insumo.insumo_registro.servicios.partials.modalUpdate')
<div class="panel panel-primary">
    <div class="panel-heading" style="background-color: #202040">
        <div class="row">
            <div class="col-md-2">                
            </div>
            <div class="col-md-7 text-center">
                <p class="panel-title">LISTA DE SERVICIOS</p>
            </div>
            <div class="col-md-3 text-right">
                <button class="btn pull-right btn-default" style="background: #616A6B"  data-target="#myCreateServ" data-toggle="modal"><h6 style="color: white">+&nbsp;NUEVO REGISTRO</h6></button>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-servicio">
            <thead class="cf">
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        Operaciones
                    </th>
                    <th>
                        Servicio
                    </th>
                    <th>
                        Costo
                    </th>
                    <th>
                        Empresa
                    </th>
                    <th>
                        Mes
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
    var t = $('#lts-servicio').DataTable( {
      
         "processing": true,
            "serverSide": true,
            "ajax": "/ServicioInsumo/create/",
            "columns":[
                {data: 'serv_id'},
                {data: 'acciones',orderable: false, searchable: false},
                {data: 'serv_nom'},
                {data: 'serv_costo'},
                {data: 'serv_emp'},
                {data: 'mes'},
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
        $("#nombre").val("");
        $("#empresa").val(""); 
        $("#nit").val("");
        $("#factura").val(""); 
        $("#costo").val("");
        $("#mes").val(""); 
      }

        $("#registroServ").click(function(){
            var route="/ServicioInsumo";
            var token =$("#token").val();
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: {
                'nombre_servicio':$("#nombre").val(),
                'empresa_servicio':$("#empresa").val(),
                'nit':$("#nit").val(),
                'nro_factura':$("#factura").val(),
                'costo_servicio':$("#costo").val(),
                'mes_servicio':$("#mes").val(),
                'planta':$("#planta").val(),
                'fecha_pago':$("#fecha_pago").val(),
                'observacion':$("#observacion").val()
                },
                success: function(data){
                    $("#myCreateServ").modal('toggle');Limpiar();
                    swal("Servicio!", "registro correcto","success");
                    $('#lts-servicio').DataTable().ajax.reload();
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

        function MostrarServ(btn){
            var route = "/ServicioInsumo/"+btn.value+"/edit";
            $.get(route, function(res){
                $("#serv_id1").val(res.serv_id);
                $("#serv_nom1").val(res.serv_nom);
                $("#serv_emp1").val(res.serv_emp);
                $("#serv_nit1").val(res.serv_nit);
                $("#serv_nfact1").val(res.serv_nfact);
                $("#serv_costo1").val(res.serv_costo);
                $("#serv_id_mes1").val(res.serv_id_mes);
            });
        }

        $("#actualizarServ").click(function(){
        var value = $("#serv_id1").val();
        var route="/ServicioInsumo/"+value+"";
        var token =$("#token").val();
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',
            dataType: 'json',
            data: {
                    'serv_nom':$("#serv_nom1").val(),
                    'serv_emp':$("#serv_emp1").val(),
                    'serv_nit':$("#serv_nit1").val(),
                    'serv_nfact':$("#serv_nfact1").val(),
                    'serv_costo':$("#serv_costo1").val(),
                    'serv_id_mes':$("#serv_id_mes1").val(),
                  },
                        success: function(data){
                $("#myUpdateServ").modal('toggle');
                swal("Servicio!", "edicion exitosa!", "success");
                $('#lts-servicio').DataTable().ajax.reload();

            },  error: function(result) {
                  console.log(result);
                 swal("Opss..!", "Edicion rechazada", "error")
            }
        });
        });

        function Eliminar(btn){
        var route="/ServicioInsumo/"+btn.value+"";
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
                        $('#lts-servicio').DataTable().ajax.reload();
                        swal("Acceso!", "El registro fue dado de baja!", "success");
                    },
                        error: function(result) {
                            swal("Opss..!", "error al procesar la solicitud", "error")
                    }
                });
        });
        }
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
@endpush
