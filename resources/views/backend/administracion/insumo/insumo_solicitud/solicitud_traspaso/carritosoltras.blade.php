@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.insumo.insumo_solicitud.solicitud_traspaso.partials.modalCreateSolTras')
<div class="panel panel-primary">
    <div class="panel-heading" style="background-color: #202040">
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
                    <label>
                        Selecione Planta
                    </label>
                    <select class="form-control" id="planta_id">
                        @foreach($plantas as $planta)
                            <option value="{{$planta->id_planta}}/{{$planta->nombre_planta}}">{{$planta->nombre_planta}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="box-header with-border"></div>
                    <div class="body table-responsive">
                        <table id="lts-soltraspaso" class="table table_carr table-condensed" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Cod. Insumo</th>
                                    <th>Insumo</th>
                                    <th>U. Medida</th>
                                    <th>Stock</th>
                                    <th>Cantidad</th>
                                    <th>Acciones</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="almacen">
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Cod. Insumo</th>
                                    <th>Insumo</th>
                                    <th>U. Medida</th>
                                    <th>Stock</th>
                                    <th>Cantidad</th>
                                    <th>Acciones</th>
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
                            <input id="ins_id2" name="ins_id2" type="hidden" value="">
                            <input id="ins_desc1" name="ins_desc1" type="hidden" value="">
                            <input id="ins_cod1" name="ins_cod1" type="hidden" value="">
                            <div><button value="" class="btn btn-primary" onClick="MostrarCarritoConfirm();" data-toggle="modal" data-target="#myCreateSolTraspaso"><span class="glyphicon glyphicon-shopping-cart"></span> Solicitar</button>
                            <button class="btn btn-danger" onclick="eliminarTodos()" name="borrar" id="borrar" value="Borrar todo"><span class="glyphicon glyphicon-remove-sign"></span> Cancelar</button> </div>
                            <table id="lts-carrito" class="table table-condensed" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Cod. Insumo</th>
                                        <th>Insumo</th>
                                        <th>Cantidad</th>
                                        <th>Accion</th>
                                        <th></th>
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
$('#planta_id').on('change', function() {
  eliminarTodos();
  var id_planta = this.value;
  var separa = id_planta.split("/");
  var id_pl = separa[0];
  var t = $('#lts-soltraspaso').DataTable( {
  			"responsive": true,
            "processing": true,
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax":{
               url : "/ListarInsumosPlanta/"+id_pl,
               type: "GET",
               data: {"planta_id": id_planta}
             },
            "columns":[
                {data: 'ins_id', className: "id_insumo"},
                {data: 'ins_codigo'},
                {data: 'ins_desc'},
                {data: 'umed_nombre'},
                {data: 'stock_cantidad'},
                {data: 'solicitud_cantidad'},
                {data: 'acciones'},
                {data: 'id_insumo'}
        ],

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
    /*t.rows().eq(0).each( function ( index ) {
        var row = table.row( index );
        var data = row.data();
        // ... do something with data(), or row.node(), etc
        console.log(data);
    } );*/

});
/*$('#lts-soltraspaso').on('click', '#buttonsol', function (e) {
    e.preventDefault();
    var currentRow = $(this).closest("tr");
    var nro_insumo = currentRow.find('td:eq(0)').text();
    var codigo_insumo  = currentRow.find('td:eq(1)').text();
    var insumo = currentRow.find('td:eq(2)').text();
    var umed = currentRow.find('td:eq(3)').text();
    var stock = currentRow.find('td:eq(4)').text();
    var cantidad = currentRow.find('td:eq(5) input').val();
    var id_insumo = currentRow.find('td:eq(7) input').val();
    //alert('insumo: '+insumo+', cantidad: '+cantidad+', id_insumo: '+id_insumo);
});*/
var datos_carrito_confirm = [];
function MostrarCarrito(){
   var datos_carrito = [];
   $('#lts-soltraspaso tr').each(function(){
        var nro_insumo = $(this).find('td:eq(0)').text();
        var codigo_insumo  = $(this).find('td:eq(1)').text();
        var insumo = $(this).find('td:eq(2)').text();
        var umed = $(this).find('td:eq(3)').text();
        var stock = $(this).find('td:eq(4)').text();
        var cantidad = $(this).find('td:eq(5) input').val();
        var id_insumo = $(this).find('td:eq(7) input').val();
        //console.log(nro_insumo);
        if (id_insumo === undefined) {
            console.log("Es null");
        }else if(cantidad > null){
            datos_carrito.push({"codigo_insumo":codigo_insumo,"umed_nombre":umed,"id_insumo":id_insumo,"insumo":insumo,"cantidad_solicitud":cantidad});
        }
   });
   var dataSet = JSON.stringify(datos_carrito);
   var d;
   for (var i = 0; i < datos_carrito.length; i++) {
        d+= '<tr id="items">'+
            '<td>'+datos_carrito[i].codigo_insumo+'</td>'+
            '<td>'+datos_carrito[i].insumo+'</td>'+
            '<td>'+datos_carrito[i].cantidad_solicitud+'</td>'+
            '<td><div class="text-center"><a href="javascript:void(0);"  class="removeItem btncirculo btn-md btn-danger"><i class="glyphicon glyphicon-remove"></i></a></div></td>'+
            '<td><input type="hidden" value="'+datos_carrito[i].id_insumo+'"></td>'+
            '<td><input type="hidden" value="'+datos_carrito[i].umed_nombre+'"></td>'+
        '</tr>';
        console.log(datos_carrito[i].cantidad_solicitud);
        datos_carrito_confirm.push({"codigo_insumot":datos_carrito[i].id_insumo,"umed_nombre":datos_carrito[i].umed_nombre,"cantidad_solicitud":datos_carrito[i].cantidad_solicitud});
    }
    $("#lts-carrito").append(d);
    $('#lts-soltraspaso').DataTable().ajax.reload();
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
    //console.log(datos_carrito_confirm);
    datos_carrito_confirm = [];
    $('#lts-carrito tr').each(function () {
        var codigo_insumo_sol = $(this).find("td").eq(0).html();
        var insumo_sol = $(this).find("td").eq(1).html();
        var cantidad_sol = $(this).find("td").eq(2).html();
        var id_insumo_sol = $(this).find('td:eq(4) input').val();
        var umed_nombre = $(this).find('td:eq(5) input').val();
        if (id_insumo_sol === undefined) {

        } else {
            datos_carrito_confirm.push({"codigo_insumo_sol":codigo_insumo_sol,"umed_nombre":umed_nombre,"id_insumo_sol":id_insumo_sol,"insumo_sol":insumo_sol,"cantidad_sol":cantidad_sol});
        }
    });
    console.log(datos_carrito_confirm);
    var planta_id = $("#planta_id").val();
    var separa = planta_id.split("/");
    var nom_pl = separa[1];
    var id_plant = separa[0];
    $("#nombre_planta_confirm").val(nom_pl);
    $("#id_planta_confirm").val(id_plant);

    //LLENANDO AL MODAL SOLICITUD
    var dsol;
    for (var i = 0; i < datos_carrito_confirm.length; i++) {
        dsol+= '<tr>'+
            '<td class="text-center">'+datos_carrito_confirm[i].codigo_insumo_sol+'</td>'+
            '<td class="text-center">'+datos_carrito_confirm[i].insumo_sol+'</td>'+
            '<td class="text-center">'+datos_carrito_confirm[i].umed_nombre+'</td>'+
            '<td class="text-center">'+datos_carrito_confirm[i].cantidad_sol+'</td>'+
            '<td class="text-center"><input type="hidden" value="'+datos_carrito_confirm[i].id_insumo_sol+'"></input></td>'+
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
</script>
@endpush