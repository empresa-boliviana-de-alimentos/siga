@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.insumo.insumo_devolucion.devolucion_insumos.partials.modalCreate')
<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-1">
                    <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('DevolucionRegistrosMenu') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
                </div>
                <div class="col-md-8">
                     <h4><label for="box-title">DEVOLUCIÓN POR INSUMO DEFECTUOSO</label></h4>
                </div>
                <div class="col-md-3">
                    <a href="{{url('RegistroDevolucionDefec')}}" class="btn btn-default" style="background: #616A6B;">  
                        <h6 style="color: white;"><i class="fa fa-plus">
                    </i>&nbsp;REALIZAR NUEVA DEVOLUCION</h6>
                    </a>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<br>

<div class="row">
        
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border"></div>
                    <div class="box-body">
                        
                        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-devolucion">
                            <thead class="cf">
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>
                                        N° ORP
                                    </th>
                                    <th>
                                        Feha
                                    </th>
                                    
                                    <th>
                                        Producto
                                    </th>
                                    <th>
                                        Cantidad
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
$(document).ready(function() {
      var table =$('#lts-devolucion').DataTable( {
         "processing": true,
            "serverSide": true,
            "ajax": "/DevolucionDefectuoso/create/",
            "columns":[
                {data: 'devo_id'},
                {data: 'devo_nro_dev'},
                {data: 'devo_registrado'},
                //{data: 'devo_registrado'},
                {data: 'rece_nombre'},
                {data: 'devo_estado'},
                {data: 'acciones'},
            ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
         "order": [[ 0, "desc" ]]
    });
    table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
    $('#buscanumsalida').on( 'keyup', function () {
    table
        .columns( 2 )
        .search( this.value )
        .draw();
    });

    $('#buscalote').on( 'keyup', function () {
    table
        .columns( 3 )
        .search( this.value )
        .draw();
    });
});

          

  function MostrarDataDev(btn){  
    var dat=btn.value;
    console.log(dat);
    $('#lts-devolucionDetalle').DataTable( {
            //scrollY:        "160px",
            // scrollX:        true,
            // scrollCollapse: true,
            // paging:         false,
            "destroy":true,
            "processing": true,
            "serverSide": true,
            "ajax": "DevolucionDetalle/"+dat,
            "columns":[
                {data: 'id_insumo'},
                {data: 'descripcion_insumo'},
                {data: 'unidad'},
                {data: 'cantidad'},
                {data: 'rango_adicional'},
                {data: 'adicion'},
                {data: 'devolucion'},
        ],
        "order": [[ 0, "asc" ]],
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        });
    }

    $("#registroDev").click(function(){
           var rows = [];
            $('#lts-devolucionDetalle tbody tr').each(function(){
                 rows.push({
                     id:$(this).find("td").eq(0).html(),
                     insumo:$(this).find("td").eq(1).html(),
                     unidad:$(this).find("td").eq(2).html(),
                     cantidad:$(this).find("td").eq(3).html(),
                     rango:$(this).find("td").eq(4).html(),
                     adicion:$(this).find('td:eq(5) input').val(),
                     devolucion:$(this).find('td:eq(6) input').val(),
                    });
                });
            itemsDevoluciones = JSON.stringify(rows);
            console.log('Json Table devolucion: ', itemsDevoluciones);

            var route="/DevolucionInsumo";
                     var token =$("#token").val();
                     $.ajax({
                         url: route,
                         headers: {'X-CSRF-TOKEN': token},
                         type: 'POST',
                         dataType: 'json',
                         data: {
                         'id_aprsol':$("#aprsol_id").val(),
                         'num_sal':$("#num_saldia").val(),
                         'nom_rec':$("#dev_nombre").val(),
                         'data':itemsDevoluciones,
                         'obs':$("#obs").val(),
                         },
                         success: function(data){
                            // $('#lts-carrito').DataTable().ajax.reload();
                             swal("Devoluciones!", "registrado correctamente","success");
                             $("#myCreateDevolucion").modal('toggle');Limpiar();
                         },
                         error: function(result)
                         {
                         swal("Opss..!", "Error al registrar el dato", "error");
                         }
                     });
 });
   
    function MostrarDevolucion(btn){
      var route = "/DevolucionInsumo/"+btn.value+"/edit";
      $.get(route, function(res){
        $("#aprsol_id").val(res.aprsol_id);
        $("#num_saldia").val(res.aprsol_cod_solicitud+'/'+res.aprsol_gestion)
        $("#dev_nombre").val(res.rec_nombre);
      });
    }
</script>
@endpush


