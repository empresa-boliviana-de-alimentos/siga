@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.acopio.acopio_miel.acopio.partials.modalCreateFondos')
@include('backend.administracion.acopio.acopio_miel.acopio.partials.modalCreateConvenio')
@include('backend.administracion.acopio.acopio_miel.acopio.partials.modalCreateProductor')
@include('backend.administracion.acopio.acopio_miel.acopio.partials.modalUpdateFondos')
@include('backend.administracion.acopio.acopio_miel.acopio.partials.modalCreateDestino')
@include('backend.administracion.acopio.acopio_miel.acopio.partials.modalCreateRespRecep')
<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-1">
                <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('AcopioMielMenu') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
                </div>
                <div class="col-md-8">
                     <h4><label for="box-title">ACOPIO CONVENIO</label></h4>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-2">
                <a class="btn btn-default"  onclick="LimpiarDatosConvenio();" data-href="#acopioConvenio" href="#acopioConvenio" data-toggle="modal" style="background: #616A6B"><h6 style="color: white;"><i class="fa fa-plus">
                    </i> &nbsp;NUEVO ACOPIO POR CONVENIO</h6>
                </a> 
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<!-- <div align="right" class="page-header">
    <td>
        <i class="fa fa-list-alt">
        </i>
        Acopio Convenio
        <a class="btn btn-primary" role="button" data-toggle="modal" data-href="#acopioConvenio" href="#acopioConvenio">
            <i class="fa fa-plus">
            </i> REGISTRAR ACOPIO POR CONVENIO
        </a>
        <button class="btn btn-primary"  onclick="LimpiarDatosConvenio();" data-href="#acopioConvenio" href="#acopioConvenio" data-toggle="modal"><i class="fa fa-plus">
                    </i> &nbsp;NUEVO ACOPIO POR CONVENIO
        </button> 
	</td>
</div> -->
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border"></div>
                <div class="box-body">
                    <div id="no-more-tables">
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        NRO CONTRATO:
                                    </label>
                                    <input type="text" name="buscarcontrato" id="buscarcontrato" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        BUSQUEDA POR NOMBRES:
                                    </label>
                                    <input type="text" name="buscarnom" id="buscarnom" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        BUSQUEDA POR AP PATERNO:
                                    </label>
                                    <input type="text" name="buscarpat" id="buscarpat" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        BUSQUEDA POR AP MATERNO:
                                    </label>
                                    <input type="text" name="buscarmat" id="buscarmat" class="form-control" onkeyup="javascript:this.value=this.value.toUpperCase();">
                                </div>
                            </div>
                        </div>
                        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-acopio-convenio">
                            <thead class="cf">
                                
                                <tr>
                                    <th>
                                        Acciones
                                    </th>
                                    <th>
                                        Nro Contrato
                                    </th>
                                    <th>
                                        Nro Acopio
                                    </th>    
                                    <th>
                                        Nombre Proveedor
                                    </th>
                                    <th>
                                        Ap. Paterno Prov.
                                    </th>
                                    <th>
                                        Ap. Materno Prov.
                                    </th>
                                    <!-- <th>
                                        Peso Bruto
                                    </th> -->
                                    <th>
                                        Peso Neto
                                    </th>
                                    <th>
                                        Total Bs
                                    </th>
                                    <th>
                                        Fecha
                                    </th>
                                </tr>
                            </thead>
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
    var tablaConvenio = $('#lts-acopio-convenio').DataTable( {
      
         "processing": true,
            "serverSide": true,
            "ajax": "/AcopioMielConvenio/create",
            "columns":[
                {data: 'acciones',orderable: false, searchable: false},
                {data: 'contrato_nro'},
                {data: 'aco_numaco'},
                {data: 'prov_nombre'},
                {data: 'prov_ap'},
                {data: 'prov_am'},
                // {data: 'prom_peso_bruto'},
                {data: 'prom_peso_neto'},               
                {data: 'prom_total'},
                {data: 'aco_fecha_reg'}
                //{data: 'acciones',orderable: false, searchable: false},
                
        ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
       
    });
    $('#buscarcontrato').on( 'keyup', function () {
    tablaConvenio
        .columns( 1 )
        .search( this.value )
        .draw();
    } );
    $('#buscarnom').on( 'keyup', function () {
    tablaConvenio
        .columns( 3 )
        .search( this.value )
        .draw();
    } );

    $('#buscarpat').on( 'keyup', function () {
    tablaConvenio
        .columns( 4 )
        .search( this.value )
        .draw();
    } );

    $('#buscarmat').on( 'keyup', function () {
    tablaConvenio
        .columns( 5 )
        .search( this.value )
        .draw();
    } );
    
    $("#registro1").click(function(){
        var route="/AcopioMielConvenio";
        var token =$("#token").val();
        //$('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');
        var liqpagable2 = parseFloat($('#liq_pagable').val());
        var deudaAnterior2 = parseFloat($('#deudacontratoActual').val());
        if (deudaAnterior2 < liqpagable2) {
            swal("ADVERTENCIA!","El Liquido pagable: "+Number(liqpagable2).toFixed(2)+" sobrepasa a la deuda: "+Number(deudaAnterior2).toFixed(2),"error");
        }else{
            $.ajax({
                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: { 'proveedor':$("#id_proveedorConvenio").val(),                    
                        'fecha_acopio':$('#fecha_acopio').val(),
                        'fecha_registro':$('#fecha_resgistro').val(),                                     
                        // 'peso_bruto_convenio':$('#peso_brutoConv').val(),
                        // 'peso_taraConv': $('#peso_taraConv').val(),
                        'peso_bruto_convenio': 0,
                        'peso_taraConv': 0,
                        'peso_netoConv': $('#peso_netoConv').val(),
                        'valorTotalConv':$('#valorTotalConv').val(),
                        'contrato': $('#contrato_id').val(),
                        'totalDeuda': $('#totalDeuda').val(),
                        'nroBoletaConv': $('#nro_boleta_conv').val(),
                        'nroAcopioConv' : $('#nro_acopio_conv').val(),
                        'saldoActual' :$('#saldo').val(),
                        'deudaContratoActual' : $('#deudacontratoActual').val(),
                        'cuota' : $('#cuota').val(),
                        'saldo' : $('#saldo').val(),
                        'pago' : $('#pago').val(),

                        'rau_iue' : $('#rau_iue').val(),
                        'rau_ti' : $('#rau_ti').val(),
                        'liq_pagable' : $('#liq_pagable').val(),
                        'tipo_materia_prima' : $('#tipo_matp').val(),
                        'precio_matp' : $('#precio_unitario_matp').val()
                    },
                        
                    success: function(data){
                        $("#acopioConvenio").modal('toggle');
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
                        var errorCompleto='Tiene los siguientes errores: ';
                        $.each(result.responseJSON.errors,function(indice,valor){
                           errorCompleto = errorCompleto + valor+' ' ;                       
                        });
                        swal("Opss..., Hubo un error!",errorCompleto,"error");
                    }
            });
        }
    });
    function LimpiarDatosConvenio()
    {
        $("#id_proveedorConvenio").empty();
        $("#id_contrato_conv").empty();
        $("#acta_entrega_conv").val("");
        $("#costoConvenio").val("");
        $("#preciocontrato").val("");
        $("#deudacontrato").val("");
        $("#deudacontratoActual").val("");
        $("#pagoActual").val("");
        $("#deudaActual").val("");
        $("#comunidad").val("");
        $("#municipio").val("");
        $("#sindicato").val("");
        $("#peso_brutoConv").val("");
        $("#peso_netoConv").val("");
        $("#valorTotalConv").val("");
        $("#saldoAnterior").val("");
        $("#cuota").val("");
        $("#pago").val("");
        $("#rau_iue").val("");
        $("#rau_ti").val("");
        $("#liq_pagable").val("");
        $("#saldo").val("");       
    }
</script>
@endpush