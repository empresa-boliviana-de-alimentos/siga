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
<div class="panel panel-primary">
    <div class="panel-heading" style="background-color: #202040">
        <div class="row">
            <div class="col-md-2">
                <a type="button" class="btn btn-danger fa fa-arrow-left" href="{{ url('IngresosInsumo') }}"></span><h7 style="color:#ffffff">&nbsp;&nbsp;VOLVER</h7></a>
            </div>
            <div class="col-md-7 text-center">
                <p class="panel-title">LISTA DE INGRESOS TRASPASO</p>
            </div>
            <div class="col-md-3 text-right">
                
            </div>
        </div>
    </div>
    <div class="panel-body">
        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-prima" style="width: 100%">
            <thead class="cf">
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        FECHA 
                    </th>
                    <th>
                        PLANTA RECEPCION
                    </th>
                    <th>
                        PLANTA QUE ENVIA
                    </th>
                    <th>
                        OPCIONES
                    </th>
                </tr>
            </thead>
            <tbody>
            <?php $nro = 0; ?>
            @foreach($ingreso_traspaso as $ip)
            <?php $nro = $nro + 1 ; ?>
                <tr>
                    <td class="text-center">{{$nro}}</td>
                    <td class="text-center">{{$ip->ing_registrado}}</td>
                    <td class="text-center">{{traePlanta($ip->ing_planta_id)}}</td>
                    <td class="text-center">{{traePlanta($ip->ing_planta_traspaso)}}</td>
                    <td class="text-center">
                    @if ($ip->ing_estado == 'B')
                        <div class="text-center"><a href="verIngresoTraspaso/{{$ip->ing_id}}" class="btn btn-md btn-success"><i class="fa fa-eye"></i></a></div>
                    @else
                        <div class="text-center"><a href="ReporteAlmacen/{{$ip->ing_id}}" target="_blank"><img src="img/pdf_boleta.jpg" width="50px"></a></div>
                    @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<?php 
function traePlanta($id_planta) {
    $planta = \DB::table('public._bp_planta')->where('id_planta', '=', $id_planta)->first();
    return $planta->nombre_planta;
}
?>
@endsection
@push('scripts')
<script>
    /*var t = $('#lts-prima').DataTable( {
         "processing": true,
            "serverSide": true,
            "ajax": "IngresoTraspasoCreate",
            "columns":[
                {data: 'ing_id'},                
                {data: 'ing_registrado'},
                {data: 'planta_recepcion'},
                {data: 'planta_traspaso'},
                {data: 'acciones',orderable: false, searchable: false},
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
    } ).draw();*/
    $('#lts-prima').DataTable( {
        "responsive": true,
        "order": [[ 0, "asc" ]],
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

    });
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
