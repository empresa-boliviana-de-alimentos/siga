<div class="modal fade bs-example-modal-sm in" data-backdrop="static" data-keyboard="false" id="acopioConvenio" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                    <h4 class="modal-title">Registro de Acopio por Convenio</h4>
                </div>
                <div class="overlay">
  <i class="fa fa-refresh fa-spin"></i>
</div>
            <div class="modal-body">
                <div class="caption">
                    <?php $now = new \DateTime('America/La_Paz'); ?>
                    
                        {!! Form::open(['id'=>'acopio'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            
                            <input id="fecha_resgistro" name="fecha_resgistro" type="hidden" value="<?php echo $now->format('d-m-Y H:i:s'); ?>">
                            <input type="hidden" name="nro_acopio_conv" id="nro_acopio_conv" value="">
                            <input type="hidden" name="nro_boleta_conv" id="nro_boleta_conv" value="">
                            <input type="hidden" name="contrato_id" id="contrato_id" value="">
                                 <div class="row">                              
                                    <h5 class="text-center"><strong>Datos Contrato No: <span id="numeroContrato"></span> - No. Boleta: <span id="nro_boleta"></span></strong></h5>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="text-center">                                                   
                                                    <img src="" width="100px" height="100px" id="fotoConvenio" name="img">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Fecha y Hora:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('fecha_acopio', $now->format('d-m-Y H:i:s'), array('placeholder' => 'Fecha y Hora ', 'class'=>'form-control','maxlength'=>'40','id'=>'fecha_acopio', 'readonly' => 'readonly')) !!}
                                                   
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Proveedor:
                                                </label>                                                
                                                
                                                <select name="id_proveedorConvenio" class="form-control" id="id_proveedorConvenio" style="width: 100%"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                
                                                {!!Form::label('Contrato','Contrato: ')!!}
                                                
                                                <select name="id_contrato_conv" class="form-control" id="id_contrato_conv" style="width: 100%"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Cod Prov:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('acta_entrega_conv', null, array('placeholder' =>'Nro. Contrato ','maxlength'=>'20','class' => 'form-control','id'=>'acta_entrega_conv','readonly' => 'reaconly')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>                                 
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Rau:
                                                </label>
                                                <span class="block input-icon input-icon-right">  
                                                   <!--  {!! Form::text('costoConvenio', '0.00', array('placeholder' => 'SI/NO','class' => 'form-control','id'=>'costoConvenio','readonly' => 'readonly', 'onkeyup'=>'calculos()')) !!} -->
                                                   <select name="costoConvenio" id="costoConvenio" class="form-control">
                                                       <option value="SI">SI</option>
                                                       <option value="NO">NO</option>
                                                   </select>
                                                </span>
                                                
                                            </div>
                                        </div>
                                    </div>                         
                                    
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        P. Contrato:
                                                    </label>
                                                    <span class="block input-icon input-icon-right">
                                                        {!! Form::text('preciocontrato', null, array('placeholder' => 'Ingrese nro de Recibo','class' => 'form-control','id'=>'preciocontrato','readonly' => 'readonly')) !!}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                    Precio Pago:
                                                    </label>
                                                    <span class="block input-icon input-icon-right">
                                                   
                                                        {!! Form::text('deudacontrato', null, array('placeholder' => 'Rau','maxlength'=>'10','class' => 'form-control','id'=>'deudacontrato','readonly' => 'readonly', 'onkeyup'=>'calculos()', 'min'=>'0.01', 'step'=>'0.01', 'placeholder'=>'0.00')) !!}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                    Deuda Anterior:
                                                    </label>
                                                    <span class="block input-icon input-icon-right">
                                                   
                                                        {!! Form::text('deudacontratoActual', null, array('maxlength'=>'10','class' => 'form-control','id'=>'deudacontratoActual','readonly', 'min'=>'0.01', 'step'=>'0.01', 'placeholder'=>'0.00')) !!}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                    Pago Actual:
                                                    </label>
                                                    <span class="block input-icon input-icon-right">
                                                   
                                                        {!! Form::text('pagoActual', null, array('maxlength'=>'10','class' => 'form-control','id'=>'pagoActual','readonly' => 'readonly', 'min'=>'0.01', 'step'=>'0.01', 'placeholder'=>'0.00')) !!}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                    Deuda Actual:
                                                    </label>
                                                    <span class="block input-icon input-icon-right">
                                                   
                                                        {!! Form::text('deudaActual', null, array('maxlength'=>'10','class' => 'form-control','id'=>'deudaActual','readonly' => 'readonly', 'min'=>'0.01', 'step'=>'0.01', 'placeholder'=>'0.00')) !!}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Central:
                                                    </label>
                                                    <span class="block input-icon input-icon-right">
                                                       {!! Form::text('comunidad', null, array('placeholder' =>'Central ','maxlength'=>'10','class' => 'form-control','id'=>'comunidad','readonly' => 'reaconly')) !!}
                                                    </span>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Municipio:
                                                    </label>
                                                    <span class="block input-icon input-icon-right">
                                                {!! Form::text('municipio', null, array('placeholder' =>'Municipio','maxlength'=>'10','class' => 'form-control','id'=>'municipio','readonly' => 'readonly')) !!}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Sindicato:
                                                    </label>
                                                    <span class="block input-icon input-icon-right">
                                                {!! Form::text('sindicato', null, array('placeholder' =>'Sindicato','maxlength'=>'40','class' => 'form-control','id'=>'sindicato','readonly' => 'readonly')) !!}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="row">                              
                                    <h5 class="text-center"><strong>Datos Acopio Nro: <span id="numero_acopio_conv"></span></strong></h5>
                                </div>                                
                               
                                <div class="row">
                                    <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Peso Bruto:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('peso_brutoConv', null, array('maxlength'=>'10','class' => 'form-control','id'=>'peso_brutoConv', 'onkeyup'=>'calculos()', 'min'=>'0.01', 'step'=>'0.01', 'placeholder'=>'0.00')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Peso Tara:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('peso_taraConv', '1.200', array('placeholder' => 'Ingrese Peso Tara','maxlength'=>'10','class' => 'form-control','id'=>'peso_taraConv','readonly' => 'readonly', 'onkeyup'=>'calculos()', 'min'=>'0.01', 'step'=>'0.01', 'placeholder'=>'0.00')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Tipo de Materia Prima
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    <select name="tipo_matp" id="tipo_matp" class="form-control" onkeyup="calculos();">
                                                        <option value="0">Seleccione..</option>
                                                        <option value="1">Miel</option>
                                                        <option value="2">Polen</option>
                                                        <option value="3">Prop&oacute;leo</option>
                                                        <option value="4">Cera</option>
                                                        <option value="5">Panales</option>
                                                    </select>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Peso Neto:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('peso_netoConv', null, array('maxlength'=>'10','class' => 'form-control','id'=>'peso_netoConv', 'onkeyup'=>'calculos()', 'min'=>'0.01', 'step'=>'0.01', 'placeholder'=>'0.00')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Precio Unitario:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('precio_unitario_matp', null, array('maxlength'=>'10','class' => 'form-control','id'=>'precio_unitario_matp', 'onkeyup'=>'calculos()', 'min'=>'0.01', 'step'=>'0.01', 'placeholder'=>'0.00','readonly' => 'readonly')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Valor Total:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                   
                                                    {!! Form::text('valorTotalConv', null, array('placeholder' => 'Total','maxlength'=>'10','class' => 'form-control','id'=>'valorTotalConv','readonly' => 'readonly', 'onkeyup'=>'calculos()', 'min'=>'0.01', 'step'=>'0.01', 'placeholder'=>'0.00')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>   
                                </div>
                                <div class="row">                              
                                    <h5 class="text-center"><strong>Datos del Pago</strong></h5>
                                </div>  

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Saldo Anterior:
                                                </label>                                                
                                                {!! Form::text('saldoAnterior', null, array('class' => 'form-control','id'=>'saldoAnterior','readonly' => 'readonly', 'onkeyup'=>'calculos()', 'min'=>'0.01', 'step'=>'0.01', 'placeholder'=>'0.00')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Cuota:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('cuota', null, array('class' => 'form-control','id'=>'cuota','readonly' => 'readonly', 'onkeyup'=>'calculos()', 'min'=>'0.01', 'step'=>'0.01', 'placeholder'=>'0.00')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Pago:
                                                </label>
                                                {!! Form::text('pago', null, array('class' => 'form-control','id'=>'pago','readonly' => 'readonly', 'min'=>'0.01', 'step'=>'0.01', 'placeholder'=>'0.00')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Saldo Actual:
                                                </label>
                                                {!! Form::text('saldo', null, array('class' => 'form-control','id'=>'saldo','readonly' => 'readonly', 'min'=>'0.01', 'step'=>'0.01', 'placeholder'=>'0.00')) !!}
                                            </div>
                                        </div>
                                    </div>  -->                                        
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    RAU-IUE (5%):
                                                </label>                                                
                                                {!! Form::text('rau_iue', null, array('class' => 'form-control','id'=>'rau_iue','readonly' => 'readonly', 'onkeyup'=>'calculos()', 'min'=>'0.01', 'step'=>'0.01', 'placeholder'=>'0.00')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    RAU-TI (3%):
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('rau_ti', null, array('class' => 'form-control','id'=>'rau_ti','readonly' => 'readonly', 'onkeyup'=>'calculos()', 'min'=>'0.01', 'step'=>'0.01', 'placeholder'=>'0.00')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    LIQUIDO PAGABLE:
                                                </label>
                                                {!! Form::text('liq_pagable', null, array('class' => 'form-control','id'=>'liq_pagable','readonly' => 'readonly', 'min'=>'0.01', 'step'=>'0.01', 'placeholder'=>'0.00')) !!}
                                            </div>
                                        </div>
                                    </div>                                        
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Saldo Actual:
                                                </label>
                                                {!! Form::text('saldo', null, array('class' => 'form-control','id'=>'saldo','readonly' => 'readonly', 'min'=>'0.01', 'step'=>'0.01', 'placeholder'=>'0.00')) !!}
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                
                            </input>
                        </input>
                    </hr>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registro1','class'=>'btn btn-success'], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript">
    // BUSQUEDAS ASINCRONAS          
$('#id_proveedorConvenio').select2({
    dropdownParent: $('#acopioConvenio'),
    placeholder: "Selecciona Proveedor",
    proveedor: true,
    tokenSeparators: [','],
    ajax: {
        dataType: 'json',
        url: '{{ url("obtenerProveedorConv") }}',
        delay: 250,
        data: function(params) {
            return {
                term: params.term
            }
        },
        processResults: function (data, page) {
            return {
            results: data
            };
        },
    },
    language: "es",
});
$('#id_proveedorConvenio').on('change', function(e){
    console.log(e);
    var prov_id = e.target.value;
    var rutaImagen= "imagenes/proveedores/miel/";
    $.get('/ajax-contratos?prov_id='+prov_id, function(data){
        console.log(data[0].prov_foto);
        $("#fotoConvenio").attr("src",rutaImagen+data[0].prov_foto);
        $('#id_contrato_conv').empty();
        $('#id_contrato_conv').append('<option value="0">Selec. Cotrato</option>');
        $.each(data, function(index, contratoObj){
            $('#id_contrato_conv').append('<option value="'+contratoObj.contrato_id+'">'+contratoObj.contrato_nro+'</option>');
        });
    });
});
// COLOCANDO DATOS AL FORMULARIO SEGUN EL Contrato
$('#id_contrato_conv').on('change', function(e){
    // var rutaImagen= "imagenes/proveedores/miel/";
    var prov_id = e.target.value;
    $.get('/ajax-proveedor?prov_id='+prov_id, function(data){
      if (data[0].totalpago == null) {
            var totalpago = 0;
            var deuda = data[0].contrato_precio - totalpago;
        }else {
            var totalpago = data[0].totalpago;
            var deuda = data[0].contrato_precio - totalpago;
        }
      if (deuda > 1.2 ) {
        
        console.log("DEUDA ACTUAL: "+deuda);
        // $("#fotoConvenio").attr("src",rutaImagen+data[0].prov_foto);
        $("#sindicato").val(data[0].aso_nombre);
        $("#municipio").val(data[0].mun_nombre);
        $("#comunidad").val(data[0].com_nombre);
        $("#contrato").val(data[0].contrato_nro);
        $("#contrato_id").val(data[0].contrato_id);
        $("#preciocontrato").val(Number(data[0].contrato_precio).toFixed(2));
        $("#deudacontrato").val(Number(data[0].contrato_deuda).toFixed(2));
        $("#deudacontratoActual").val(Number(deuda).toFixed(2));

        
        if (data[0].prov_rau == 1) {
            $("#costoConvenio").val('SI');
            // $("#costoConvenio").val(parseFloat(29.44));
        }else{
            $("#costoConvenio").val('NO');
            // $("#costoConvenio").val(parseFloat(32.00));
        }
        console.log('Proveedor Convenio: '+data[0].contrato_nro);
        document.getElementById("numeroContrato").innerHTML = data[0].contrato_nro;
        var numactaconv = zfill(data[0].prov_id,4);
        if(data[0].nroaco == null) {
            //console.log("Es NAN");
            var aconumacoconv = 1;
            console.log(aconumacoconv);
            }else {
                
                var aconumacoconv = parseInt(data[0].nroaco)+1;
                console.log(aconumacoconv);
            }
        $("#nro_acopio_conv").val(aconumacoconv);
        document.getElementById("numero_acopio_conv").innerHTML = aconumacoconv;
        $("#acta_entrega_conv").val(numactaconv);
        var nroboletaconv =  zfill(data[0].prov_id,4)+'/'+zfill(aconumacoconv,3)
        document.getElementById("nro_boleta").innerHTML = nroboletaconv;
        $("#nro_boleta_conv").val(nroboletaconv);
        $.get('/ajax-calculaSaldo?contrato_id='+data[0].contrato_id, function(data){
            $("#saldoAnterior").val(Number(data).toFixed(2));
            console.log("el saldo es: "+data);
        });
      } else {
        swal('El proveedor ya pago este contrato','su deuda es de: '+Number(deuda).toFixed(2)+', Elija otro contrato o caso contrario cree uno nuevo');
      }
        
    });
});

function zfill(number, width) {
    var numberOutput = Math.abs(number); /* Valor absoluto del número */
    var length = number.toString().length; /* Largo del número */ 
    var zero = "0"; /* String de cero */  
    
    if (width <= length) {
        if (number < 0) {
             return ("-" + numberOutput.toString()); 
        } else {
             return numberOutput.toString(); 
        }
    } else {
        if (number < 0) {
            return ("-" + (zero.repeat(width - length)) + numberOutput.toString()); 
        } else {
            return ((zero.repeat(width - length)) + numberOutput.toString()); 
        }
    }
}
function calculos() {
                 
    console.log('Cambio');
    if ($("#tipo_matp").val() == 1) {
        var valorTotalAcopio = 32*$('#peso_netoConv').val();
        $("#precio_unitario_matp").val(Number(32).toFixed(2));
    }else if($("#tipo_matp").val() == 2){
        var valorTotalAcopio = 150*$('#peso_netoConv').val();
        $("#precio_unitario_matp").val(Number(150).toFixed(2));
    }else if($("#tipo_matp").val() == 3){
        var valorTotalAcopio = 300*$('#peso_netoConv').val();
        $("#precio_unitario_matp").val(Number(300).toFixed(2));
    }else if($("#tipo_matp").val() == 4){
        var valorTotalAcopio = 80*$('#peso_netoConv').val();
        $("#precio_unitario_matp").val(Number(80).toFixed(2));
    }else if($("#tipo_matp").val() == 5){
        var valorTotalAcopio = 60*$('#peso_netoConv').val();
        $("#precio_unitario_matp").val(Number(60).toFixed(2));
    }
    var precioUnitario = 32;
    // var valorTotalAcopio = 32*$('#peso_netoConv').val();
    $('#valorTotalConv').val(Number(valorTotalAcopio).toFixed(2));
    $('#pago').val(Number(valorTotalAcopio).toFixed(2));

    var cuota = parseFloat($('#deudacontrato').val());
    var saldoAnterior = parseFloat($('#saldoAnterior').val());
    var totalCuota = cuota + saldoAnterior; 
    $("#cuota").val(Number(totalCuota).toFixed(2));
    
    var pagodeuda = $("#pagoActual").val();
    var deudaAnterior = $("#deudacontratoActual").val();
    var preciodeudaActual = deudaAnterior - pagodeuda;

    $("#deudaActual").val(Number(preciodeudaActual).toFixed(2));
    console.log("Precio de la deuda Actual: "+preciodeudaActual);
    // RAU-IUE, RAU-TI Y LIQUIDO PAGABLE
    if($('#costoConvenio').val() == 'SI'){
        var rauiue = 0.00;
        var rauti = 0.00;
        var liqpagable = valorTotalAcopio - rauiue - rauti;
        $("#rau_iue").val(Number(rauiue).toFixed(2));
        $("#rau_ti").val(Number(rauti).toFixed(2));
        $("#liq_pagable").val(Number(liqpagable).toFixed(2));
        $('#saldo').val(Number(totalCuota-liqpagable).toFixed(2));
        $("#pagoActual").val(Number(liqpagable).toFixed(2));
    } else{
        var rauiue = valorTotalAcopio*5/100;
        var rauti = valorTotalAcopio*3/100;
        var liqpagable = valorTotalAcopio - rauiue - rauti;
        $("#rau_iue").val(Number(rauiue).toFixed(2));
        $("#rau_ti").val(Number(rauti).toFixed(2));
        $("#liq_pagable").val(Number(liqpagable).toFixed(2));
        $('#saldo').val(Number(totalCuota-liqpagable).toFixed(2));
        $("#pagoActual").val(Number(liqpagable).toFixed(2));
    }
    if (deudaAnterior < liqpagable) {
        swal("ADVERTENCIA!","El Liquido pagable: "+Number(liqpagable).toFixed(2)+" sobrepasa a la deuda: "+Number(deudaAnterior).toFixed(2),"error");
    }

}


</script>
@endpush