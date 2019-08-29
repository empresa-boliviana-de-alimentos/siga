@extends('backend.template.app')
<style type="text/css" media="screen">
    .caja {
        min-width: 0;
        width: 100% !important;
        color:gray;
    }
    th {
        font-size: 10px;
    }
    td {
        font-size: 10px;
    }

</style>
@section('main-content')
@include('backend.administracion.insumo.insumo_registro.ingreso_almacen.partials.modalCreate')
@include('backend.administracion.insumo.insumo_registro.ingreso_almacen.partials.modalReportePreliminar')
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-2">
                <a type="button" class="btn btn-danger fa fa-arrow-left"  href="{{ url('IngresosInsumo') }}"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
            </div>
            <div class="col-md-7 text-center">
                <p class="panel-title">INGRESO ALMACEN</p>
            </div>
            <div class="col-md-3 text-right">

            </div>
        </div>
    </div>
    <div class="panel-body">
       <div class="col-md-8">
                    <div class="body table-responsive">
                        <table id="lts-ingreso" class="table table_carr table-condensed" style="width:100%">
                            <thead>
                                <tr>
                                    <th>+</th>
                                    <th>#</th>
                                    <th>CODIGO</th>
                                    <th>DETALLE</th>
                                    <th>U. MEDIDA</th>
                                    <th>CANTIDAD</th>
                                    <th>COSTO/U.</th>
                                    <th>PROVEEDOR</th>
                                    <th>FECHA VENCIMIENTO</th>
                                    <th></th>
                                    <!--<th>Partida</th>-->
                                </tr>
                            </thead>
                            <tbody id="almacen">
                               @if($ingreso->count())
                               <?php $nro=0; ?>
                                 @foreach($ingreso as $in)
                                 <?php $nro = $nro+1; ?>
                                <tr class="item">
                                <td><button value="{{$in->ins_id}}" id="button" class="btncirculo btn-success btn-xs insumo-get" onClick="MostrarCarrito()" data-toggle="modal" data-target="#myCreateRCA">+</button></td>
                                  <td class="id_insumo" style="display: none">{{$in->ins_id}}</td>
                                  <td class="nro">{{$nro}}</td>
                                  <td class="codigo_insumo">{{$in->ins_codigo}}</td>
                                  <td class="descrip_insumo" style="width: 128px;">@if($in->sab_id == 1){{$in->ins_desc}} {{$in->ins_peso_presen}} @else {{$in->ins_desc}} {{$in->sab_nombre}} {{$in->ins_peso_presen}} @endif</td>
                                  <td class="unidad">{{$in->umed_nombre}}</td>
                                  <td class="cantidad_insumo"><input type="text" id="cant" name="row-1-age" size="6" value="0" placeholder="0"></td>
                                  <td class="costo_insumo"><input type="text" id="costo" name="row-1-age" value="0.00" size="3" value="" placeholder="0.00"></td>
                                  <td class="proveedor_insumo"><select style="width: 108px;" class="form-control" id="prov" name="prov">
                                      <option value="0">Seleccione</option>
                                      @foreach($comboProv as $prov)
                                        <option value="{{$prov->prov_id}}">{{$prov->prov_nom}}</option>
                                      @endforeach</select>
                                  </td>
                                  <td class="fechaven_insumo"><span class="block input-icon input-icon-right">
                                        <div class="input-group">
                                          <input class="form-control datepicker" id="fecha" name="fecha" type="text">
                                            <div class="input-group-addon">
                                              <span class="glyphicon glyphicon-calendar"></span>
                                            </div>
                                          </input>
                                        </div>
                                      </span>
                                  </td>
                                  <!--<td>{{$in->part_nombre}}</td>-->
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="8">No hay registro !!</td>
                                </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>+</th>
                                    <th>#</th>
                                    <th>CODIGO</th>
                                    <th>DETALLE</th>
                                    <th>U. MEDIDA</th>
                                    <th>CANTIDAD</th>
                                    <th>COSTO/U</th>
                                    <th>PROVEEDOR</th>
                                    <th>FECHA VENCIMIENTO</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
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
                            <div><button class="btn btn-danger" onclick="MostrarCarrito()" name="borrar" id="borrar" value="Borrar todo">Mostrar</button> <button value="" class="btn btn-primary" onClick="MostrarCarr(); Limpiar();" data-toggle="modal" data-target="#myCreateIngreso">Confirmar Insumos</button></div>
                            <table id="lts-carrito" class="table table-condensed" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>INSUMO</th>
                                        <th>CANTIDAD</th>
                                        <th>COSTO/U</th>
                                        <th>SUBSTOTAL</th>
                                        <th>OPCIONES</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                <th colspan="3" style="text-align:right">TOTAL:</th>
                                <th></th>
                                <th></th>
                            </tfoot>
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

@endsection
@push('scripts')
<script  type="text/javascript">

$(document).ready(function() {
    MostrarCarrito();
    console.log('iniciando ');
    var table = $('#lts-ingreso').DataTable({
         scrollCollapse: true,
         scrollX: true,
         paging: false,
         ordering: false,
         searching: true,
         // "processing": true,
         //    "serverSide": true,
         // "ajax": "/IngresoAlmacen/create/",

          //   "defaultContent": "<button>Click!</button>"
          "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[5 , 25, 50, -1], [10, 25, 50, "All"]],
    });

    $('#buscarInsumo').on( 'keyup', function () {
    table
        .columns( 2 )
        .search( this.value )
        .draw();
    } );

    $('#buscarCategoria').on( 'keyup', function () {
    table
        .columns( 6 )
        .search( this.value )
        .draw();
    } );
} );


function Limpiar(){
        $("#carr_ing_rem").val("");
        $("#carr_ing_tiping").val("");
        //$("#carr_ing_fech").val("");
        $("#isFile").val("");
        $("#imgFactura").val("");
        $("#carr_ing_nrofactura").val("");
        $("#carr_ing_nrocontrato").val("");
        //$("#cant").val("");
       // $("#costo").val("");
       // $("#prov").val("");
      }

// COMENTADO PARA CERRAR EL MODAL DE INGRESO CONFIRMACION
/*$(document.body).on('hidden.bs.modal', function () {
    $('#myCreateIngreso').removeData('bs.modal')
});*/

$(".insumo-get").click(function() {
            var datos_carrito = [];
            $('.table_carr .item').each(function() {
                var id_insumo = $(this).find(".id_insumo").text();
                var descrip_insumo = $(this).find(".descrip_insumo").text();
                var codigo_insumo = $(this).find(".codigo_insumo").text();
                var cantidad_insumo_all = $(this).find(".cantidad_insumo input").val();
                var costo_insumo = $(this).find(".costo_insumo input").val();
                var proveedor_insumo = $(this).find(".proveedor_insumo select").val();
                var fechaven_insumo = $(this).find(".fechaven_insumo input").val();
                //console.log("ID INSUMO: "+id_insumo+", CODIGO INSUMO"+codigo_insumo+", CANTIDAD: "+cantidad_insumo_all+", COSTO: "+costo_insumo+", PROVEEDOR"+proveedor_insumo+", FECHA VENCIMEINTO: "+fechaven_insumo);
                if (cantidad_insumo_all != 0) {
                    datos_carrito.push({"id_insumo":id_insumo,"descrip_insumo":descrip_insumo,"codigo_insumo":codigo_insumo,"cantidad_insum":cantidad_insumo_all,"costo_insumo":costo_insumo,"proveedor_insumo":proveedor_insumo,"fechaven_insumo":fechaven_insumo});
                }


             });
             console.log(datos_carrito);
             var row = $(this).closest("tr");
             id_insumo = row.find(".id_insumo").text();
             descrip_insumo = row.find(".descrip_insumo").text();
             codigo_insumo = row.find(".codigo_insumo").text();
             cantidad_insumo = row.find(".cantidad_insumo input").val();
             costo_insumo = row.find(".costo_insumo input").val();
             proveedor_insumo = row.find(".proveedor_insumo select").val();
             fechaven_insumo = row.find(".fechaven_insumo input").val();
              console.log ("ENVIANDO AL CARRITO: "+cantidad_insumo);
             // console.log ("costo: "+costo_insumo);
             // console.log ("proveedor: "+proveedor_insumo);

             var route="/IngresoAlmacen";
                     var token =$("#token").val();
                     if(cantidad_insumo <= 0 ){
                     swal('La cantidad debe ser mayor a cero');
                        return;
                     }else{
                     $.ajax({
                         url: route,
                         headers: {'X-CSRF-TOKEN': token},
                         type: 'POST',
                         dataType: 'json',
                         data: {
                         'insumo': descrip_insumo,
                         'id_insumo':id_insumo,
                         'cod_insumo':codigo_insumo,
                         'cantidad': cantidad_insumo,
                         'costo': costo_insumo,
                         'proveedor': proveedor_insumo,
                         'ven_insumo': fechaven_insumo,
                         'datos_carrito': datos_carrito
                         },
                         success: function(data){
                            console.log(data);
                             // $("#myCreateProv").modal('toggle');Limpiar();
                            // swal("Proveedor!", "registro correcto","success");
                         //   $('#myCreateIngreso').modal('hide');
                        //     $('#myCreateIngreso').modal({refresh:true});
                             $('#lts-carrito').DataTable().ajax.reload();
                             //$('#lts-ingreso').DataTable().ajax.reload();
                             location.reload();
                         },
                         error: function(result)
                         {
                         swal("ERROR!", "Por favor selecione proveedor", "error");
                         }
                     });
                 }
 });

 function MostrarCarrito(){
      $('#lts-carrito').DataTable( {
            "destroy":true,
            "processing": true,
            "serverSide": true,
            "ajax": "Carrito",
            "columns":[
                {data: 'ins_desc'},
                {data: 'carr_cantidad'},
                {data: 'carr_costo'},
                {data: 'subtotal'},
                {data: 'acciones', orderable: false, searchable: false}
        ],
        "order": [[ 3, "asc" ]],
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[100], [100, "All"]],
         "order": [[ 0, "desc" ]],
         "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Total over this page
            Total = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 3).footer() ).html(
              Number(Total).toFixed(2)
            );
        }
    });
   }

   function MostrarCarr(){
    $('#lts-carrconf').DataTable( {
            paging:         false,
            "destroy":true,
            "processing": true,
            "serverSide": true,
            "ajax": "CarritoSol",
            "columns":[
                {data: 'carr_id'},
                {data: 'ins_desc'},
                {data: 'carr_cantidad'},
                {data: 'carr_costo'},
                {data: 'prov_nom'},
                {data: 'totaluni'},
        ],
        "order": [[ 0, "asc" ]],
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

         "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Total over this page
            pageTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 5 ).footer() ).html(
              Number(pageTotal).toFixed(2)
            );
        }
        });
    }


    function EliminarItem(btn){
      var route="CarritoItemDelete/"+btn.value+"";
      var token =$("#token").val();
      swal({   title: "Eliminacion de item?",
        text: "Uds. esta a punto de eliminar 1 item del carrito",
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
                    $('#lts-carrito').DataTable().ajax.reload();
                    swal("Acceso!", "El item fue eliminidao del carrito!", "success");
                },
                    error: function(result) {
                      console.log('Resultado: '+result);
                        swal("Opss..!", "error al procesar la solicitud", "error")
                }
            });
        });
    }

    $("#registroIngreso").click(function(){
          var route="/CarritoIngreso";
          var token =$("#token").val();
                var rows = [];
                var table = $('#lts-carrconf').DataTable();
                table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                 var data = this.data();
                      rows.push(data);
                });
                  var dato = JSON.stringify(rows);
                  console.log ("este es el data", dato);
        $.ajax({
            url: route,
             headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            async:false,
            processData: false,
            contentType: false,
            data: {//'carr_ing_prov':$("#carr_ing_prov").val(),
                   // 'carr_ing_rem':$("#carr_ing_rem").val(),
                   // 'carr_ing_tiping':$("#carr_ing_tiping").val(),
                   // 'carr_ing_fech':$("#carr_ing_fech").val(),
                   // 'carr_ing_fact':$("#carr_ing_fact").val(),
                   // 'carr_ing_lote':$("#carr_ing_lote").val(),
                   // 'carr_ing_data': dato
                  },
             data:new FormData($("#registro")[0]),
                success: function(data){
                    console.log(data.ing_id);
                    window.open('/ReporteAlmacen/'+data.ing_id,'_blank');
                    $("#myCreateIngreso").modal('toggle');Limpiar();
                    //swal("Los Insumos!", "Fueron ingresados correctamente!", "success");
                    //$('#lts-carrito').DataTable().ajax.reload();
                    //$('#lts-carrconf').DataTable().ajax.reload();
                    //location.reload();
                    swal({
                                title: "INGRESO",
                                text: "Los insumos fueron ingresados correctamente",
                                type: "success"
                                            },
                                function(){
                                        location.reload();
                            });
                },
                error: function(result) {
                        swal("Opss..!", "Succedio un problema al registrar inserte bien los datos!", "error");
                }
        });
    });

    function EliminarCarrito(){
      var route="/CarritoIngreso/";
      var token =$("#token").val();
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'DELETE',
                dataType: 'json',

                success: function(data){
                   $('#lts-carrito').DataTable().ajax.reload();
                  //  swal("Acceso!", "El item fue eliminidao del carrito!", "success");
                },
                //     error: function(result) {
                //       console.log('Resultado: '+result);
                //         swal("Opss..!", "error al procesar la solicitud", "error")
                // }
            });
    }

     $("#registroPreliminar").click(function(){
          var route="/Preliminar";
           var token =$("#token").val();
        $.ajax({
            url: route,
             headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {//'tmpp_id_prov':$("#carr_ing_prov").val(),
                   'nota_de_remision':$("#carr_ing_rem").val(),
                   'tipo_de_ingreso':$("#carr_ing_tiping").val(),
                   'fecha_de_remision':$("#carr_ing_fech").val(),
                   'tmpp_fech':$("#carr_ing_fech").val(),
                   'tmpp_lote':$("#carr_ing_lote").val(),
                   'nro_contrato':$("#carr_ing_nrocontrato").val(),
                   'nro_factura':$("#carr_ing_nrofactura").val(),
                  },
                success: function(data){
                  //  var resJson = JSON.stringify(data);
                    console.log(data.ingpre_id);
                 //   $('#idBolRecetaSol').val(data.tmpp_id);
                    $('#iframeboleta').attr('src', 'ReportPreliminar/'+data.ingpre_id);
                    $('#myRepPreleminar').modal('show');
                    $("#myCreateIngreso");
                   //window.open('/ReportPreliminar','_blank');
                },
                error: function(result) {
                      //  swal("Opss..!", "Succedio un problema al registrar inserte bien los datos!", "error");
                    var errorCompleto='Tiene los siguientes errores: ';
                    $.each(result.responseJSON.errors,function(indice,valor){
                        errorCompleto = errorCompleto + valor+' ' ;
                    });
                    swal("Opss..., Hubo un error!",errorCompleto,"error");
                }
        });
    });

      function EliminarPreliminar(){
      var route="/DeletePreliminar/";
      var token =$("#token").val();
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'DELETE',
                dataType: 'json',

                success: function(data){
                  // $('#lts-carrito').DataTable().ajax.reload();
                  //  swal("Acceso!", "El item fue eliminidao del carrito!", "success");
                },
                //     error: function(result) {
                //       console.log('Resultado: '+result);
                //         swal("Opss..!", "error al procesar la solicitud", "error")
                // }
            });
    }

///ejemplo de json array
    // $("#btn_Table2Json").click(function () {
    //   var  rows = [];
    //    var table =$('#lts-carrconf').DataTable();
    //     table.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
    //       var data = this.data();
    //         rows.push(data);
    //     });
    //     var dato = JSON.stringify(rows);
    //     console.log('datoooo', dato);
    //    // debugger;
    //   // alert(JSON.stringify(rows));

    // });

</script>
<script type="text/javascript">
  $(".datepicker").datepicker({
      format: "dd-mm-yyyy",
      language: "es",
      firstDay: 1
  }).datepicker("setDate", new Date());
</script>
@endpush






