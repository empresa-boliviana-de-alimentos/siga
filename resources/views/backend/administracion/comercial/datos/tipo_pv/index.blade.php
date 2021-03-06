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
    tfoot th {
      background-color:#428bca;
      color: white;
    }
    tbody td {
      background-color: #EEEEEE;
    }
</style>
@section('main-content')
@include('backend.administracion.comercial.datos.tipo_pv.modalCreate')
@include('backend.administracion.comercial.datos.tipo_pv.modalUpdate')
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-2">
                <a type="button" class="btn btn-danger fa fa-arrow-left" href="{{ url('DatosComercial') }}"></span><h7 style="color:#ffffff">&nbsp;&nbsp;VOLVER</h7></a>
            </div>
            <div class="col-md-7 text-center">
                <p class="panel-title">TIPO PUNTO DE VENTA</p>
            </div>
            <div class="col-md-3 text-right">
                <a href="#" data-target="#myCreateTipoPv" data-toggle="modal" onclick="LimpiarTipoPv();" class="btn btn-default btn-xs" style="background: #616A6B;">
                        <h6 style="color: white;"><i class="fa fa-plus">
                    </i>&nbsp;CREAR NUEVO TIPO PUNTO DE VENTA</h6>
                </a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border"></div>
                        <div class="box-body">
                            <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-tipoPv">
                                <thead class="cf">
                                    <tr>
                                        <th class="text-center">
                                            #
                                        </th>
                                        <th class="text-center">
                                            NOMBRE
                                        </th>
                                        <th class="text-center">
                                            DESCRIPCIÓN
                                        </th>
                                        <th class="text-center">
                                            OPCIONES
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                	
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">
                                            #
                                        </th>
                                        <th class="text-center">
                                            NOMBRE
                                        </th>
                                        <th class="text-center">
                                            DESCRIPCIÓN
                                        </th>
                                        <th class="text-center">
                                            OPCIONES
                                        </th>
                                    </tr>
                                </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>    
var t = $('#lts-tipoPv').DataTable( {

         "processing": true,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/TipoPuntoVenta/create",
            "columns":[
                {data: 'tipopv_id'},
                {data: 'tipopv_nombre'},
                {data: 'tipopv_descripcion'},
                {data: 'acciones',orderable: false, searchable: false},
        ],
        "order": [[ 0, "desc" ]],
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

    });

t.on( 'order.dt search.dt', function () {
    t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        cell.innerHTML = i+1;
    } );
} ).draw();

$("#registroTipoPv").click(function(){
    var route="TipoPuntoVenta";
    var token =$("#token").val();
    //$('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {
            'tipopv_nombre':$('#nombre').val(),
            'tipopv_descripcion':$('#descripcion').val(),
        },
            success: function(data){
                $("#myCreateTipoPv").modal('toggle');
                swal("EL TIPO PUNTO DE VENTA!", "Se registrado correctamente!", "success");
                $('#lts-tipoPv').DataTable().ajax.reload();
            },
            error: function(result) {
                swal("Opss..!", "Sucedio un problema al registrar inserte bien los datos!", "error");
            }
        });
});
function MostrarTipoPv(btn){
    var route = "TipoPuntoVenta/"+btn.value+"/edit";
    $.get(route, function(res){
        $("#id_tipopv").val(res.tipopv_id);
        $("#nombre1").val(res.tipopv_nombre);
        $("#descripcion1").val(res.tipopv_descripcion);
    });
}
$("#actualizarTipoPv").click(function(){
    var value =$("#id_tipopv").val();
    var route="TipoPuntoVenta/"+value+"";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'PUT',
        dataType: 'json',
        data: {
            'tipopv_nombre':$("#nombre1").val(),
            'tipopv_descripcion':$("#descripcion1").val(),
        },
        success: function(data){
            $("#myUpdateTipoPv").modal('toggle');
            swal("EL TIPO PUNTO DE VENTA!", "Fue actualizado correctamente!", "success");
            $('#lts-tipoPv').DataTable().ajax.reload();
        },  error: function(result) {
            console.log(result);
            swal("Opss..!", "El tipo punto de venta no se puedo actualizar intente de nuevo!", "error")
        }
    });
});
function Eliminar(btn){
    var route="TipoPuntoVenta/"+btn.value+"";
    var token =$("#token").val();
    swal({   title: "Esta seguro de eliminar el tipo de punto de venta?",
      text: "Presione ok para eliminar el registro de la base de datos!",
      type: "warning",   showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Si, Eliminar!",
      closeOnConfirm: false
    }, function(){
       $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'DELETE',
            dataType: 'json',
            success: function(data){
                $('#lts-tipoPv').DataTable().ajax.reload();
                swal("Tipo Punto de Venta!", "Fue eliminado correctamente!", "success");
            },
            error: function(result) {
                swal("Opss..!", "El Tipo Punto de Venta tiene registros en otras tablas!", "error")
            }
        });
    });
}

function LimpiarTipoPv()
{
    $("#nombre").val("");
    $("#descripcion").val("");
}
</script>
@endpush

