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
@include('backend.administracion.comercial.datos.productos.modalUpdate')
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-2">
                <a type="button" class="btn btn-danger fa fa-arrow-left" href="{{ url('DatosComercial') }}"></span><h7 style="color:#ffffff">&nbsp;&nbsp;VOLVER</h7></a>
            </div>
            <div class="col-md-7 text-center">
                <p class="panel-title">LISTADO DE TODOS LOS PRODUCTOS EBA</p>
            </div>
            <div class="col-md-3 text-right">
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border"></div>
                        <div class="box-body">
                            <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-producto">
                                <thead class="cf">
                                    <tr>
                                        <th class="text-center">
                                            #
                                        </th>
                                        <th class="text-center">
                                            CODIGO
                                        </th>
                                        <th class="text-center">
                                            NOMBRE
                                        </th>
                                        <th class="text-center">
                                            LINEA
                                        </th>
                                        <th class="text-center">
                                            OPCIONES
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $nro=0; ?>
                                	@foreach($productos as $producto)
                                        <?php $nro=$nro+1; ?>
                                        <tr>
                                            <td class="text-center">{{$nro}}</td>
                                            <td class="text-center">{{$producto->prod_codigo}}</td>
                                            <td class="text-center">
                                            @if($producto->sab_id == 1)
                                                {{$producto->rece_nombre}} {{$producto->rece_presentacion}}
                                            @else
                                                {{$producto->rece_nombre}} {{$producto->sab_nombre}} {{$producto->rece_presentacion}}
                                            @endif
                                            </td>
                                            <td class="text-center">{{linea($producto->rece_lineaprod_id)}}</td>
                                            <td class="text-center"><button value="{{$producto->prod_id}}" class="btncirculo btn-xs btn-warning" onClick="MostrarProducto(this);" data-toggle="modal" data-target="#myUpdateTipoPv"><i class="fa fa-pencil-square"></i></button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">
                                            #
                                        </th>
                                        <th class="text-center">
                                            CODIGO
                                        </th>
                                        <th class="text-center">
                                            NOMBRE
                                        </th>
                                        <th class="text-center">
                                            LINEA
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
<?php 
    function linea($id)
    {
        if ($id == 1) {
            return "LACTEOS";
        }elseif($id == 2){
            return "ALMENDRA";
        }elseif($id == 3){
            return "MIEL";
        }elseif($id == 4){
            return "FRUTOS";
        }elseif($id == 5){
            return "DERIVADOS";
        }
    }
 ?>
@endsection
@push('scripts')
<script>    
$('#lts-producto').DataTable( {
        "responsive": true,
        "order": [[ 0, "desc" ]],
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

    });

/*$('#lts-producto').DataTable({
         scrollCollapse: true,
         scrollX: true,
         paging: false,
         ordering: false,
         searching: true,
          "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[5 , 25, 50, -1], [10, 25, 50, "All"]],
    });*/

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
function MostrarProducto(btn){
    var route = "MostrarProductoC/"+btn.value;
    $.get(route, function(res){
        console.log(res);
        if (res.sab_id === 1) {
            $("#nombre_producto").val(res.rece_nombre+' '+res.rece_presentacion);
        }else{
            $("#nombre_producto").val(res.rece_nombre+' '+res.sab_nombre+' '+res.rece_presentacion);
        }        
        $("#codigo_producto").val(res.prod_codigo);
        if(res.rece_lineaprod_id === 1){
            $("#linea_produccion").val("LACTEOS");
        }else if(res.rece_lineaprod_id === 2){
            $("#linea_produccion").val("ALMENDRA");
        }else if(res.rece_lineaprod_id === 3){
            $("#linea_produccion").val("MIEL");
        }else if(res.rece_lineaprod_id === 4){
            $("#linea_produccion").val("FRUTOS");
        }else if(res.rece_lineaprod_id === 5){
            $("#linea_produccion").val("DERIVADOS");
        }
        $("#codigo_produccion").val(res.rece_codigo);
        /*$("#nombre1").val(res.tipopv_nombre);
        $("#descripcion1").val(res.tipopv_descripcion);*/
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

