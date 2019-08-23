@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.insumo.insumo_solicitud.solicitud_insumo.partials.modalCreateAdiInsumo')
@include('backend.administracion.insumo.insumo_solicitud.solicitud_insumo.partials.modalBoletaSolAdiInsumo')
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-2">
                <a type="button" class="btn btn-danger fa fa-arrow-left" href="{{ url('InsumoSolicitudesMenu') }}"></span><h7 style="color:#ffffff">&nbsp;&nbsp;VOLVER</h7></a>
            </div>
            <div class="col-md-7 text-center">
                <p class="panel-title">SOLICITUD POR INSUMO ADICIONAL</p>
            </div>
            <div class="col-md-3 text-right">
                <a href="{{url('FormInsumoAdicional')}}" class="btn btn-default btn-xs" style="background: #616A6B;">
                        <h6 style="color: white;"><i class="fa fa-plus">
                    </i>&nbsp;NUEVA SOLICITUD POR INSUMO ADICIONAL</h6>
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
                            <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-adicional">
                                <thead class="cf">
                                    <tr>
                                        <th>
                                            Nro
                                        </th>

                                        <th>
                                            No. ORP
                                        </th>
                                        <th>
                                            No. SOLICITUD
                                        </th>
                                        <th>
                                            Fecha
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
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>
                                            Nro
                                        </th>
                                        <th>
                                            No. ORP
                                        </th>
                                        <th>
                                            No. SOLICITUD
                                        </th>
                                        <th>
                                            Fecha
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
                                </tfoot>
                                <tr>
                                </tr>
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
    var t = $('#lts-adicional').DataTable( {

         "processing": true,
            "serverSide": true,
            "ajax": "/solInsumoAd/create/",
            "columns":[
                {data: 'orprod_id',orderable: false, searchable: false},
                {data: 'orprod_nro_orden'},
                {data: 'orprod_nro_solicitud'},
                {data: 'orprod_registrado'},
                {data: 'rece_nombre'},
                {data: 'orprod_cantidad'},
                {data: 'orprod_estado'}
        ],
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "order": [[ 1, 'desc' ]],
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

     function Limpiar(){
        $("#nombre").val("");
        $("#empresa").val("");
        $("#nit").val("");
        $("#factura").val("");
        $("#costo").val("");
        $("#mes").val("");
      }

        $("#registroSolAdicional").click(function(){
            var route="/solInsumoAd";
            var token =$("#token").val();
            itemSolAdicional = [];
           $('.items_columsSolAdi').each(function(){
                if ($(this).find('td:eq(4) input').val() > 0 ) {
                    itemSolAdicional.push({
                        id_insumo: $(this).find('td:eq(6) input').val(),
                        codigo_insumo: $(this).find('td:eq(0) input').val(),
                        descripcion_insumo: $(this).find('td:eq(1) input').val(),
                        unidad: $(this).find('td:eq(2) input').val(),
                        cantidad: $(this).find('td:eq(3) input').val(),
                        rango_adicional: "0",
                        solicitud_adicional: $(this).find('td:eq(4) input').val(),
                        observaciones: $(this).find('td:eq(5) input').val()
                    });
                }
            });

            itemsSolAdi = JSON.stringify(itemSolAdicional);
            console.log('Json formado: '+itemsSolAdi);
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: {
                // 'nombre_receta':$("#soladi_id_rec").val(),
                // 'soladi_num_lote':$("#soladi_num_lote").val(),
                // 'mercado_solicitud':$("#soladi_id_merc").val(),
                // 'cantidad_solicitud':$("#soladi_cantidad").val(),
                'soladi_id_notasal': $("#aprsol_id").val(),
                'soladi_num_salida':$("#aprsol_cod_solicitud").val(),
                'soladi_data':itemsSolAdi,
                'observacion_general':$("#soladi_obs").val(),
                'sol_rec_id': $("#rec_id").val(),
                'sol_merc_id': $("#merc_id").val(),
                },
                success: function(data){
                    console.log('id del soladi_id: '+data.sol_id);
                    $('#iframeboleta').attr('src', 'boletaSolAdicional/'+data.sol_id);
                    $('#myBoletaSolAdicional').modal('show');
                    $("#myCreateInsumoAd").modal('toggle');
                    $('#lts-adicional').DataTable().ajax.reload();
                },
                error: function(result)
                {
                // swal("Opss..!", "Error al Enviar la solicitud", "error");
                    var errorCompleto='Tiene los siguientes errores: ';
                    $.each(result.responseJSON.errors,function(indice,valor){
                        errorCompleto = errorCompleto + valor+' ' ;
                    });
                    swal("Opss..., Hubo un error!",errorCompleto,"error");
                }
            });
        });
</script>
@endpush

