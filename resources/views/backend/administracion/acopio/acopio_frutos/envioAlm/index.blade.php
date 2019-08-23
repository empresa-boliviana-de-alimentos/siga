@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.acopio.acopio_frutos.envioAlm.partials.modalCreateEnvio')

<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-1">
                    <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('AcopioFrutosMenu') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
                </div>  
                <div class="col-md-8">
                     <h4><label for="box-title">Envio Almacen</label></h4>
                </div>
                <div class="col-md-2">
                    <?php  
                 date_default_timezone_set('America/New_York');
                 $fechact=date('Y-m-d');
                 //echo $dat;
                // echo $fechact;
                 if($fechact==$fecha)
                 { 
                    echo  '<div class="hidden" id="contenido">';
                    echo'<button class="btn fa fa-plus-square pull-right btn-dark"  data-target="#myCreateEnvioAlm" data-toggle="modal">&nbsp;Nuevo Envio</button>' ;
                    echo '</div>';
                 }
                 else
                 {
                    echo  '<div>';
                    echo'<button class="btn fa fa-plus-square pull-right btn-dark"  data-target="#myCreateEnvioAlm" data-toggle="modal">&nbsp;Nuevo Envio</button>' ;
                    echo '</div>';
                 }
                ?> 
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border"></div>
                    <div class="box-body">
                        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-enviosalmacenfru" style="width:100%">
                            <thead class="cf">
                                <tr>
                                    <th>
                                        Operaciones
                                    </th>
                                    <th>
                                        Nota de Envio
                                    </th>
                                    <th>
                                        Cantidad Envio
                                    </th>
                                    <th>
                                        Costo total de Envio
                                    </th>
                                    <th>
                                        Planta Destino
                                    </th>
                                    <th>
                                        Estado de Envio
                                    </th>
                                </tr>
                            </thead>
                            <tr>
                            </tr>
                    </table>
                </div>    
            </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    var table = $('#lts-enviosalmacenfru').DataTable( {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/AcopioFrutosEnvioAlm/create/",
            "columns":[
                {data: 'acciones',orderable: false, searchable: false},
                {data: 'enval_nro_env'},
                {data: 'enval_cant_total'},
                {data: 'enval_cost_total'},
                {data: 'nombre_planta'},
                {data: 'enval_estado'},
        ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
       
    });

    // $('#buscarpat').on( 'keyup', function () {
    // table
    //     .columns( 1 )
    //     .search( this.value )
    //     .draw();
    // } );

    // $('#buscarmat').on( 'keyup', function () {
    // table
    //     .columns( 2 )
    //     .search( this.value )
    //     .draw();
    // } );

    // $('#buscarnom').on( 'keyup', function () {
    // table
    //     .columns( 3 )
    //     .search( this.value )
    //     .draw();
    // } );
});

        $("#envioAlm").click(function(){
            var route="/AcopioFrutosEnvioAlm";
            var token =$("#token").val();
            swal({   title: "Confirmacion de envio a Almacen?",
              text: "Usted esta seguro de enviar los totales a Almacen",
              type: "warning",   
              showCancelButton: true,
              confirmButtonColor: "#28A345",
              confirmButtonText: "Enviar!",
              closeOnConfirm: true
            },function(){
                $.ajax({
                    url: route,
                    headers: {'X-CSRF-TOKEN': token},
                    type: 'POST',
                    dataType: 'json',
                    data: {
                    'enval_cant_total':$("#enval_cant_total").val(),
                    'enval_cost_total':$("#enval_cost_total").val(),
                    'enval_registro':$("#enval_registro").val(),
                    'planta_destino':$("#enval_destino").val(),         
                    },
                    success: function(data){
                        // $("#myCreateEnvioAlm").modal('toggle');
                        // swal("Acceso!", "registro correcto","success");
                        // $('#lts-enviosalmacen').DataTable().ajax.reload();

                        console.log('id del envio_alm: '+data.enval_id);
                        $('#idBolEnvioAlm').val(data.enval_id);
                        $('#iframeboletaEnvioAlm').attr('src', 'boletaEnvioAlm/'+data.enval_id);
                        $('#myBoletaEnvioAlm').modal('show'); 
                        $("#myCreateEnvioAlm").modal('toggle');
                        $('#lts-enviosalmacenlac').DataTable().ajax.reload();
                        location.reload('/AcopioLacteosEnvioAlm');
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
        });

 


</script>


@endpush