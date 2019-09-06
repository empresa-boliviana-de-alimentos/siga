@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.comercial.ingreso_punto_venta.modalConfirmacionIngresoPv')
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-2">
                <a type="button" class="btn btn-danger fa fa-arrow-left" href="{{ url('solTraspaso') }}"></span><h7 style="color:#ffffff">&nbsp;&nbsp;VOLVER</h7></a>
            </div>
            <div class="col-md-7 text-center">
                <p class="panel-title">SOLICITUD INSUMO POR TRASPASO</p>
            </div>
            <div class="col-md-3 text-right">
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
        <div class="col-md-8">
            <div class="box">
                <div class="row">
                  <div class="col-md-6">
                  </div>
                </div>
                <div class="box-header with-border"></div>
                    <div class="body table-responsive">
                        <table id="lts-solProducto" class="table table_carr table-condensed cell-border" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">#</th>
                                    <th width="20%" class="text-center">CODIGO</th>
                                    <th width="25%" class="text-center">PRODUCTO</th>
                                    <th width="10%" class="text-center">CANTIDAD</th>
                                    <th width="10%" class="text-center">COSTO</th>
                                    <th width="10%" class="text-center">LOTE</th>
                                    <th width="10%" class="text-center">F. VENC.</th>
                                    <th width="10%" class="text-center">OPCIÓN</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="almacen">
                                <?php $nro = 0; ?>
                                @foreach($recetas as $receta)
                                    <?php $nro =$nro+1; ?>
                                    <tr>
                                        <td width="5%" class="text-center">{{$nro}}</td>
                                        <td width="20%" class="text-center">{{$receta->rece_codigo}}</td>
                                    @if($receta->sab_id == 1)
                                        <td width="25%" class="text-center">{{$receta->rece_nombre}} {{$receta->rece_presentacion}}</td>
                                    @else
                                        <td width="10%" class="text-center">{{$receta->rece_nombre}} {{$receta->sab_nombre}} {{$receta->rece_presentacion}}</td>
                                    @endif
                                        <td width="10%" class="text-center"><input style="width: 105px" type="number" name="" class="form-control"></td>
                                        <td width="10%" class="text-center"><input style="width: 95px" type="number" name="" class="form-control"></td>
                                        <td width="10%" class="text-center"><input style="width: 130px" type="text" name="" class="form-control"></td>
                                        <td width="10%" class="text-center"><input style="width: 100px" type="" name="" class="form-control datepicker"></td>
                                        <td width="10%" class="text-center"><button class="btncirculo btn-success btn-xs" onClick="MostrarCarrito()">+</button></td>
                                        <td><input type="hidden" name="" value="{{$receta->rece_id}}"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th width="5%" class="text-center">#</th>
                                    <th width="20%" class="text-center">Cod. Producto</th>
                                    <th width="25%" class="text-center">Producto</th>
                                    <th width="10%" class="text-center">Cantidad</th>
                                    <th width="10%" class="text-center">Costo</th>
                                    <th width="10%" class="text-center">Lote</th>
                                    <th width="10%" class="text-center">Fecha Vencimiento</th>
                                    <th width="10%" class="text-center">Acciones</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="box-footer clearfix"></div>
            </div>
        </div>
        <div class="col-md-4" id="frm">
            <div class="card">
                <div class="panel">
                    <div class="panel-body">
                        <div class="body table-responsive">
                            <div><button value="" class="btn btn-primary" onClick="MostrarCarritoConfirm();" data-toggle="modal" data-target="#myCreateConfirmacionIngresoPv"><span class="glyphicon glyphicon-shopping-cart"></span> Solicitar</button>
                            <button class="btn btn-danger" onclick="eliminarTodos()" name="borrar" id="borrar" value="Borrar todo"><span class="glyphicon glyphicon-remove-sign"></span> Cancelar</button> </div>
                            <table id="lts-carrito" class="table table-condensed" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>codigo</th>
                                        <th>Producto</th>
                                        <th>Cant.</th>
                                        <th>Costo</th>
                                        <th>Subtotal</th>
                                        <th>Opción</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="box-footer clearfix">
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
    </div>
</div>

@endsection
@push('scripts')
<script>
  var t = $('#lts-solProducto').DataTable( {
         scrollCollapse: true,
         scrollX: false,
         paging: false,
         ordering: false,
         searching: true,
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
    
var datos_carrito_confirm = [];
function MostrarCarrito(){
    //console.log("DATOS HACIA AL CARRITO");
   var datos_carrito = [];
   $('#lts-solProducto tr').each(function(){
        var nro_producto = $(this).find('td:eq(0)').text();
        var codigo_producto  = $(this).find('td:eq(1)').text();
        var producto = $(this).find('td:eq(2)').text();
        var cantidad = $(this).find('td:eq(3) input').val();
        var costo = $(this).find('td:eq(4) input').val();
        var lote = $(this).find('td:eq(5) input').val();
        var fecha_vencimiento = $(this).find('td:eq(6) input').val();
        var receta_id = $(this).find('td:eq(8) input').val();
        //console.log(nro_insumo);
        if (receta_id === undefined) {
            console.log("Es null");
        }else if(cantidad > null){
            datos_carrito.push({"codigo_producto":codigo_producto,"producto":producto,"producto_id":receta_id,"cantidad":cantidad,"costo":costo,"lote":lote,"fecha_vencimiento":fecha_vencimiento});
        }
   });
   var dataSet = JSON.stringify(datos_carrito);
   //console.log(dataSet);
   var d;
   for (var i = 0; i < datos_carrito.length; i++) {
        d+= '<tr id="items">'+
            '<td>'+datos_carrito[i].codigo_producto+'</td>'+
            '<td>'+datos_carrito[i].producto+'</td>'+
            '<td>'+datos_carrito[i].cantidad+'</td>'+
            '<td>'+datos_carrito[i].costo+'</td>'+
            '<td>'+parseFloat(datos_carrito[i].cantidad*datos_carrito[i].costo)+'</td>'+
            '<td><div class="text-center"><a href="javascript:void(0);"  class="removeItem btncirculo btn-md btn-danger"><i class="glyphicon glyphicon-remove"></i></a></div></td>'+
            '<td><input type="hidden" value="'+datos_carrito[i].producto_id+'"></td>'+
            '<td><input type="hidden" value="'+datos_carrito[i].fecha_vencimiento+'"></td>'+
            '<td><input type="hidden" value="'+datos_carrito[i].lote+'"></td>'+
        '</tr>';
        datos_carrito_confirm.push({"codigo_producto":datos_carrito[i].codigo_producto,"producto":datos_carrito[i].producto,"cantidad":datos_carrito[i].cantidad,"costo":datos_carrito[i].costo,"lote":datos_carrito[i].lote,"fecha_vencimiento":datos_carrito[i].fecha_vencimiento,"producto_id":datos_carrito[i].producto_id});
    }
    console.log(JSON.stringify(datos_carrito_confirm));
    $("#lts-carrito").append(d);
    $("#lts-solProducto").table().reload();
}
$(document).on('click', '.removeItem', function() {

    var trIndex = $(this).closest("tr").index();
    if(trIndex=1) {
        $(this).closest("tr").remove();
    }
});

function eliminarTodos()
{
    $("#lts-carrito").find("tr:gt(0)").remove();
}

function MostrarCarritoConfirm()
{
    console.log("ENTRANDO A LA FUNCION DE MOSTRAR CONFIRMACION");
    datos_carrito_confirm = [];
    $('#lts-carrito tr').each(function () {
        var codigo_producto = $(this).find("td").eq(0).html();
        var producto = $(this).find("td").eq(1).html();
        var cantidad = $(this).find("td").eq(2).html();
        var costo = $(this).find("td").eq(3).html();
        var producto_id = $(this).find('td:eq(6) input').val();
        var fecha_vencimiento = $(this).find('td:eq(7) input').val();
        var lote = $(this).find('td:eq(8) input').val();
        if (producto_id === undefined) {
            console.log("NULL NADA");
        } else {
            datos_carrito_confirm.push({"codigo_producto":codigo_producto,"producto":producto,"cantidad":cantidad,"costo":costo,"lote":lote,"fecha_vencimiento":fecha_vencimiento,"producto_id":producto_id});
        }
    });
    console.log(JSON.stringify(datos_carrito_confirm));
    //console.log("TRAENDO DATOS DE LA TABLA CARRITO");
    //LLENANDO AL MODAL SOLICITUD
    var dsol;
    for (var i = 0; i < datos_carrito_confirm.length; i++) {
        dsol+= '<tr>'+
            '<td class="text-center">'+datos_carrito_confirm[i].codigo_producto+'</td>'+
            '<td class="text-center">'+datos_carrito_confirm[i].producto+'</td>'+
            '<td class="text-center">'+datos_carrito_confirm[i].cantidad+'</td>'+
            '<td class="text-center">'+datos_carrito_confirm[i].costo+'</td>'+
            '<td class="text-center">'+datos_carrito_confirm[i].costo*datos_carrito_confirm[i].cantidad+'</td>'+
            '<td class="text-center">'+datos_carrito_confirm[i].lote+'</td>'+
            '<td class="text-center">'+datos_carrito_confirm[i].fecha_vencimiento+'</td>'+
            '<td class="text-center"><input type="hidden" value="'+datos_carrito_confirm[i].producto_id+'"></input></td>'+
        '</tr>';
        //console.log(datos_carrito_confirm[i].cantidad_solicitud);
        //datos_carrito_confirm.push({"codigo_insumot":datos_carrito[i].id_insumo,"cantidad_solicitud":datos_carrito[i].cantidad_solicitud});
    }
    $("#lts-carritosol").append(dsol);
    //eliminarTodosModal();
}
function eliminarTodosModal()
{
    $("#lts-carritosol").find("tr:gt(0)").remove();
}
 $("#registroSolTrasp").click(function(){
        datos_carrito_registro = [];
        $('#lts-carritosol tr').each(function () {
            var codigo_insumo_sol = $(this).find("td").eq(0).html();
            var insumo_sol = $(this).find("td").eq(1).html();
            var cantidad_sol = $(this).find("td").eq(3).html();
            var id_insumo_sol = $(this).find('td:eq(4) input').val();
            if (id_insumo_sol === undefined) {

            } else {
                datos_carrito_registro.push({"codigo_insumo_sol":codigo_insumo_sol,"id_insumo_sol":id_insumo_sol,"insumo_sol":insumo_sol,"cantidad_sol":cantidad_sol});
            }
        });
        //console.log(datos_carrito_registro);
        var datosJson = JSON.stringify(datos_carrito_registro);
        var route="solTraspaso";
        var token =$("#token").val();
        $.ajax({
            url: route,
             headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data:   {
                        'id_planta_traspaso':$("#id_planta_confirm").val(),
                        'datos_json':datosJson,
                        'observacion':$("#soltras_obs").val(),
                    },
                success: function(data){
                    //$('#myCreate').fadeIn(1000).html(data);
                    $("#myCreateSolTraspaso").modal('toggle');
                    //swal("La Persona!", "Se registrado correctamente!", "success");
                    //$('#lts-persona').DataTable().ajax.reload();
                    swal({
                            title: "Exito",
                            text: "Registrado con Exito",
                            type: "success"
                        },
                        function(){
                            location.reload();
                        });

                },
                error: function(result) {
                        swal("Opss..!", "Sucedio un problema al registrar inserte bien los datos!", "error");
                }
        });
    });

$(".datepicker").datepicker({
      format: "dd-mm-yyyy",
      language: "es",
      firstDay: 1
  }).datepicker("setDate", new Date());
</script>
@endpush