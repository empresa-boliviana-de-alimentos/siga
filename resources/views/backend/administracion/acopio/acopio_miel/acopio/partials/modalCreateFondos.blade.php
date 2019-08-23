<div class="modal fade bs-example-modal-sm in" style="overflow-y: scroll;" data-backdrop="static" data-keyboard="false" id="AcopioFondoAvance" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Registro de Acopio por Fondos en Avance</h4>
                </div>
            <div class="modal-body">
                <div class="caption">
                    <?php $now = new DateTime('America/La_Paz'); ?>
                    
                        {!! Form::open(['id'=>'acopio'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            
                            <input id="fecha_resgistro" name="fecha_resgistro" type="hidden" value="<?php echo $now->format('d-m-Y H:i:s'); ?>">
			    <input type="hidden" name="nro_acopio" id="nro_acopio" value="">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="text-center">                                                   
                                                    <img src="" width="100px" height="100px" id="foto" name="img">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
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
                                                <!-- {!! Form::select('id_proveedor', $proveedor, null,['class'=>'form-control','name'=>'id_proveedor', 'id'=>'id_proveedor']) !!} -->
                                                <select name="id_proveedor" class="form-control" id="id_proveedor" style="width: 100%"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Acta Entrega:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                   
                                                    {!! Form::text('acta_entrega', null, array('placeholder' => 'Ingrese el numero de acopio', 'class' => 'form-control','id'=>'acta_entrega','readonly')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>                                 
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Realiza Pago:
                                                </label>
                                                
                                                <select class="form-control" id="is_pago" name="is_pago" placeholder="Elija una opcion" value="">
                                                    <option value="1">
                                                        SI
                                                    </option>
                                                    <option value="2">
                                                        NO
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>                         
                                    
                                    <div id="dvOcultar">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Nro. Recibo:
                                                    </label>
                                                    <span class="block input-icon input-icon-right">
                                                        {!! Form::text('nro_recibo', '0', array('placeholder' => 'Ingrese nro de Recibo','class' => 'form-control','id'=>'nro_recibo')) !!}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Fecha Recibo:
                                                    </label>
                                                    <span class="block input-icon input-icon-right">
                                                        {!! Form::text('fecha_recibo', $now->format('d-m-Y'), array('placeholder' => 'Fecha y Hora ','maxlength'=>'40','class' => 'form-control','id'=>'fecha_recibo')) !!}
                                                        <!-- <input readonly="readonly"  id="fecha_acopio" name="fecha_registro" type="text" value="<?php echo $now->format('d-m-Y H:i:s'); ?>"> -->
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">                              
                                    <h5 class="text-center"><strong>Datos Acopio Nro:<span id="numacomiel"></span></strong></h5>
                                </div>

                                <div class="row"> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Procedencia:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('centro_acopio', null, array('placeholder' => 'Procedencia ','maxlength'=>'10','class' => 'form-control','id'=>'centro_acopio','readonly' => 'readonly')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>                                
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Central/ORG:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('central_org', null, array('placeholder' => 'Central Org ','maxlength'=>'10','class' => 'form-control','id'=>'central_org','readonly' => 'readonly')) !!}
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
                                                    % Hum:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('humedad', null, array('placeholder' => 'Humedad % ','maxlength'=>'10','class' => 'form-control','id'=>'humedad', 'required', 'min'=>"0.01", 'step'=>"0.01", 'placeholder'=>"0.00")) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Peso Tara:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('peso_tara', '1.200', array('placeholder' => 'Peso Tara','maxlength'=>'10','class' => 'form-control','id'=>'peso_tara','readonly' => 'readonly')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Peso Bruto:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('peso_bruto', null, array('placeholder' => 'Peso Bruto ','maxlength'=>'10','class' => 'form-control','id'=>'peso_bruto', 'min'=>"0.01", 'step'=>"0.01", 'placeholder'=>"0.00")) !!}
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
                                                    Peso Neto:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('peso_neto', '0', array('placeholder' => 'Peso Neto ','maxlength'=>'10','class' => 'form-control','id'=>'peso_neto','readonly' => 'readonly')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Rau:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                   
                                                    {!! Form::text('rau', null, array('placeholder' => 'Rau','maxlength'=>'10','class' => 'form-control','id'=>'rau','readonly' => 'readonly')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Cantidad Baldes:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('cantidad', null, array('placeholder' => 'Cantidad de Baldes','class' => 'form-control','id'=>'cantidad', 'placeholder'=>"0")) !!}
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
                                                    Precio Unitario:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('costo', '0.00', array('placeholder' => 'Precio Unitario','class' => 'form-control','id'=>'costo','readonly' => 'readonly')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Costo Compra:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('total', null, array('placeholder' => 'Consto Compra','class' => 'form-control','id'=>'total','readonly' => 'readonly')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                
                                                {!!Form::label('Destino','Destino: ')!!}
                                                <select name="id_destino" class="form-control" id="id_destino" style="width: 100%"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-1">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Nuevo</label>
                                                <a class="btn btn-success" data-toggle="modal" href="#nuevoDestino">+</a>
                                            </div>
                                        </div>                                        
                                    </div>  -->                       
                                </div>
                                <div class="row">                          
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Responsabe de Recepción:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    <!-- {!! Form::select('id_resp_recepcion', $resp_recep, null,['class'=>'form-control','name'=>'id_resp_recepcion', 'id'=>'id_resp_recepcion']) !!} -->
                                                    <select name="id_resp_recepcion" class="form-control" id="id_resp_recepcion" style="width: 100%" required></select>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Nuevo</label>
                                                <a class="btn btn-success" data-toggle="modal" href="#nuevoRespRecep">+</a>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Acopio de materia prima:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                   <select class="form-control" id="aco_mapri" name="aco_mapri" placeholder="Elija una opcion" value="">
                                                        <option value="1">
                                                            Aceptado
                                                        </option>
                                                        <option value="2">
                                                            Rechazado
                                                        </option>
                                                    </select>
                                                </span>
                                            </div>
                                        </div>
                                    </div>                                     
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Observación:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('observacion', null, array('placeholder' => 'Observacion','class' => 'form-control','id'=>'observacion','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>
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
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registro','class'=>'btn btn-success'], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript">
$(function(){
    $('#is_pago').change(function(){
    if($(this).val()==2){
        $('#dvOcultar').hide();
    }else{
        $('#dvOcultar').show();
    }
  
  })

});

// $(document).on('change', '#cantidad', function () {                    
//     var cantidadBaldes=$('#cantidad').val();
//     var pesoTara = $('#peso_tara').val();
//     var pesoNeto=pesoTara*cantidadBaldes;
//     var precioUnitario = $('#costo').val();
//     var costo_compra=pesoNeto*precioUnitario;
//     $('#peso_neto').val(Number(pesoNeto).toFixed(2));
//      $('#total').val(Number(costoCompra).toFixed(2));
// });

// $(document).on('change', '#costo', function () {                    
//     var pesoNeto=$('#peso_neto').val();
//     var precioUnitario = $('#costo').val();
//     var costoCompra=pesoNeto*precioUnitario;
//     $('#total').val(Number(costoCompra).toFixed(2));
// });

// BUSQUEDAS ASINCRONAS          
$('#id_proveedor').select2({
    dropdownParent: $('#AcopioFondoAvance'),
    placeholder: "Selec. Proveedor",
    proveedor: true,
    tokenSeparators: [','],
    ajax: {
        dataType: 'json',
        url: '{{ url("obtenerProveedorFA") }}',
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
$('#id_destino').select2({
    dropdownParent: $('#AcopioFondoAvance'),
    placeholder: "Selec. Destino",
    proveedor: true,
    tokenSeparators: [','],
    ajax: {
        dataType: 'json',
        url: '{{ url("obtenerDestino") }}',
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
$('#id_resp_recepcion').select2({
    dropdownParent: $('#AcopioFondoAvance'),
    placeholder: "Selec. Responsable de Recepción",
    proveedor: true,
    tokenSeparators: [','],
    ajax: {
        dataType: 'json',
        url: '{{ url("obtenerRespRecep") }}',
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
// COLOCANDO LA FOTO DEL PROVEEEDOR 
$('#id_proveedor').on('change', function(e){
    var rutaImagen= "imagenes/proveedores/miel/";
    var prov_id = e.target.value;
    $.get('/ajax-proveedorfaprod?prov_id='+prov_id, function(data){
        console.log(data);
        $("#foto").attr("src",rutaImagen+data[0].prov_foto);
        $("#centro_acopio").val(data[0].dep_nombre+' - '+data[0].mun_nombre+' - '+data[0].com_nombre);
        $("#central_org").val(data[0].aso_nombre);
        if (data[0].prov_rau == 1) {
            $("#rau").val('SI');
            $("#costo").val(29.44);
        }else{
            $("#rau").val('NO');
            $("#costo").val(32.00);
        }
	// var numacta = zfill(data[0].prov_id,4);
 //        $("#acta_entrega").val(numacta);
        console.log('Numero de Acta: '+numacta);
	console.log('Numero Acopio: '+data[0].nroaco);
        //NUMACO
        if(data[0].nroaco == null) {
            //console.log("Es NAN");
            var aconumaco = 1;
            console.log(aconumaco);
            }else {
                
                var aconumaco = parseInt(data[0].nroaco)+1;
                console.log(aconumaco);
            }
        $("#nro_acopio").val(aconumaco);
        document.getElementById("numacomiel").innerHTML = aconumaco;  
        // var numacta = zfill(data[0].prov_id,4);
        var numacta =  zfill(data[0].prov_id,4)+'/'+zfill(aconumaco,3);
        $("#acta_entrega").val(numacta);
        
    });
});

function zfill(number, width) {
    var numberOutput = Math.abs(number); /* Valor absoluto del n�mero */
    var length = number.toString().length; /* Largo del n�mero */ 
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

$(document).on('change', '#cantidad', function () {                    
    var cantidadBaldes=$('#cantidad').val();
    var pesoTara = $('#peso_tara').val();
    var pesoNeto=pesoTara*cantidadBaldes;
    var precioUnitario = $('#costo').val();
    var costo_compra=pesoNeto*precioUnitario;
    $('#peso_neto').val(Number(pesoNeto).toFixed(2));
    $('#total').val(Number(costo_compra).toFixed(2));
});
</script>
@endpush