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
    tbody td {
      background-color: #EEEEEE;
    }
</style>
@section('main-content')
@include('backend.administracion.insumo.insumo_devolucion.devolucion_insumos.partials.modalCreate')
<div class="panel panel-primary">

<div class="panel-heading">
    <div class="row">
        <div class="col-md-2">
            <a type="button" class="btn btn-danger fa fa-arrow-left" href="{{ url('DevolucionRegistrosMenu') }}"></span><h7 style="color:#ffffff">&nbsp;&nbsp;VOLVER</h7></a>
        </div>
        <div class="col-md-7 text-center">
            <p class="panel-title">DEVOLUCIÓN INSUMO SOBRANTE</p>
        </div>
        <div class="col-md-3 text-right">
            <a href="{{url('RegistroDevolucionSobrante')}}" class="btn btn-default btn-xs" style="background: #616A6B;">
                <h6 style="color: white;"><i class="fa fa-plus">
                </i>&nbsp;REALIZAR NUEVA DEVOLUCION</h6>
            </a>
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
                                        NRO. ORP
                                    </th>
                                    <th>
                                        FECHA SOLICITUD
                                    </th>
                                    <th>
                                        NRO. SALIDA
                                    </th>
                                    <th>
                                        FECHA DEVOLUCION
                                    </th>                                    
                                    <th>
                                        PRODUCTO PRODUCIR
                                    </th>
                                    <th>
                                        CANTIDAD PRODUCIR
                                    </th>
                                    <th>
                                        SOLICITANTE
                                    </th>
                                    <th>
                                        OPCIONES
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
            "ajax": "/DevolucionInsumo/create/",
            "columns":[
                {data: 'devo_id'},
                {data: 'devo_nro_orden'},
                {data: 'devo_registrado'},
                {data: 'devo_nro_salida'},
                {data: 'devo_modificado'},
                {data: 'nombreReceta'},
                {data: 'orprod_cantidad'},
                //{data: 'devo_registrado'},
                {data: 'nombreSol'},
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


