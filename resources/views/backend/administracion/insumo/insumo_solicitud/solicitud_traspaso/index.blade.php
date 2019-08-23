@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.insumo.insumo_solicitud.solicitud_traspaso.partials.modalCreateSolTras')
@include('backend.administracion.insumo.insumo_solicitud.solicitud_traspaso.partials.modalBoletaSolMaq')
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-2">
                <a type="button" class="btn btn-danger fa fa-arrow-left" href="{{ url('InsumoSolicitudesMenu') }}"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
            </div>
            <div class="col-md-7 text-center">
                <p class="panel-title">SOLICITUD POR TRAPASO</p>
            </div>
            <div class="col-md-3 text-right">
                <a class="btn pull-right btn-dark btn-xs" style="background: #616A6B;" href="{{url('CarritoSolTras')}}"><h6 style="color: white;">+&nbsp;NUEVA SOLICITUD POR TRASPASO</h6></a>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
        <div class="col-md-12">

            <div class="box">
                <!--<div class="row">
                    <div class="col-md-6">
                        <label>
                            Seleccione almacen:
                        </label>
                        <select class="form-control" id="id_planta" name="id_planta">
                            <option value="">Seleccione Planta</option>
                            @foreach($plantas as $planta)
                                <option value="{{$planta->id_planta}}">{{$planta->nombre_planta}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>-->
                <div class="box-header with-border"></div>
                    <div class="box-body">
                        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-solMaquila">
                            <thead class="cf">
                                <tr>
                                    <th>
                                        Nro
                                    </th>
                                    <th>
                                        Opciones
                                    </th>
                                    <th>
                                        Fecha
                                    </th>
                                    <th>
                                        Nro Solicitud
                                    </th>
                                    <th>
                                        Solicitante
                                    </th>
                                    <th>
                                        Planta
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
                                        Opciones
                                    </th>
                                    <th>
                                        Fecha
                                    </th>
                                    <th>
                                        Nro Solicitud
                                    </th>
                                    <th>
                                        Solicitante
                                    </th>
                                    <th>
                                        Planta
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
    var t = $('#lts-solMaquila').DataTable( {

         "processing": true,
            "serverSide": true,
            "ajax": "/solTraspaso/create/",
            "columns":[
                {data: 'orprod_id'},
                {data: 'acciones',orderable: false, searchable: false},
                {data: 'orprod_registrado'},
                {data: 'orprod_nro_solicitud'},
                {data: 'nombreSolicitante'},
                {data: 'nombre_planta'},
                {data: 'orprod_estado'},
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

    $("#registroSolTrasp").click(function(){
            var route="/solTraspaso";
            var token =$("#token").val();
            var codigotras = $("#solmaq_insumo").val();
            var itemsTras = [];
            var codIns = codigotras.split("+")[0];
            var descIns = codigotras.split("+")[1];
            var idIns = codigotras.split("+")[2];
            itemsTras.push({
                    // nro: $(this).find('td:eq(0) input').val(),
                    id_insumo: idIns,
                    codigo_insumo: codIns,
                    descripcion_insumo: descIns,
                    unidad: $("#solmaq_unidad").val(),
                    cantidad: $("#solmaq_cant").val(),
                    rango_adicional: "0",
                    solicitud_adicional: "0"
            });
            itemsTrasSol = JSON.stringify(itemsTras);
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: {
                'insumo':idIns,
                'cantidad_traspaso':$("#solmaq_cant").val(),
                'unidad_medida':$("#solmaq_unidad").val(),
                'origen':$("#solmaq_origen").val(),
                'destino':$("#solmaq_destino").val(),
                'observaciones':$("#solmaq_obs").val(),
                'solmaq_data': itemsTrasSol
                },
                success: function(data){
                    // $("#myCreateSolTraspaso").modal('toggle');
                    // swal("Acceso!", "registro correcto","success");
                    // $('#lts-solMaquila').DataTable().ajax.reload();
                    console.log('id del solmaq_id: '+data.sol_id);
                    // $('#idBolRecetaSol').val(data.solrec_id);
                    $('#iframeboleta').attr('src', 'boletaSolMaquila/'+data.sol_id);
                    $('#myBoletaSolMaq').modal('show');
                    $("#myCreateSolTraspaso").modal('toggle');
                    //swal("Solicitud Enviada!", "Enviada con Exito","success");
                    $('#lts-solMaquila').DataTable().ajax.reload();
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