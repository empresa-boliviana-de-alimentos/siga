@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.acopio.acopio_miel.acopio.partials.modalCreateRespRecep')
<div class="row">
    <div class="col-md-12">
        <div class="container col-lg-12" style="background: white;">        
            <?php $now = new DateTime('America/La_Paz'); ?>
            <div class="text-center">
                <h4>Registro de Acopio por Fondos en Avance</h4> 
            </div>                             
        
            <form action="{{ url('RegistrarAcopioFA') }}" method="GET">
                <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                <input id="fecha_resgistro" name="fecha_resgistro" type="hidden" value="<?php echo $now->format('d-m-Y H:i:s'); ?>">
                <input type="hidden" name="nro_acopio" id="nro_acopio" value="">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="text-center">                                                
                                    <img src="" width="150" height="150" id="foto" name="img">
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
                                    <option value="0" disabled selected>Seleccione</option>
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
                                    
                    <div id="dvOcultar" style="display: none;">
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
                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="">
                                        <button class="btn btn-info waves-effect" type="button" id="add_item"
                                                href="javascript:void(0)">AÑADIR BALDES
                                        </button>
                                    </div>
                                    <div class="form-group">
                                        <table id="invoice_items" class="table">
                                            <tbody>
                                            <tr>
                                                <th style="text-align: center;">Nro</th>
                                                <th style="text-align: center;">% Humedad</th>
                                                <th style="text-align: center;">Peso Bruto</th>
                                                <th style="text-align: center;">Peso Tara</th>
                                                <th style="text-align: center;">Peso Neto</th>
                                                <th style="text-align: center;">Estado</th>                                    
                                                <th></th>
                                            </tr>
                                            </tbody>
                                            <tbody id="items_panel">
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th class="text-left text-primary"
                                                    style="padding-right: 10px">
                                                    TOTALES:&nbsp;&nbsp;&nbsp;
                                                </th>
                                                <th style="text-align: center"><span id="spTotalHumedad"
                                                                                    class="text-primary">0.00</span>
                                                </th>
                                                <th style="text-align: center"><span id="spTotalBruto"
                                                                                    class="text-primary">0.00</span>
                                                </th>
                                                <th style="text-align: center"><span id="spTotalTara"
                                                                                    class="text-primary">0.00</span>
                                                </th>
                                                <th style="text-align: center"><span id="spTotalNeto"
                                                                                    class="text-primary">0.00</span>
                                                </th>
                                            </tr>
                                            </tfoot>
                                        </table>   

                                    </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Total % Hum:
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::number('humedad', null, array('placeholder' => 'Humedad % ','maxlength'=>'10','class' => 'form-control','id'=>'humedad', 'required', 'min'=>"0.01", 'step'=>"0.01", 'placeholder'=>"0.00", 'readonly' => 'readonly')) !!}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Total Peso Tara:
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::text('peso_tara', null, array('placeholder' => 'Peso Tara','placeholder'=>"0.00", 'class' => 'form-control','id'=>'peso_tara','readonly' => 'readonly')) !!}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Total Peso Bruto:
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::number('peso_bruto', null, array('placeholder' => 'Peso Bruto ','class' => 'form-control','id'=>'peso_bruto', 'min'=>"0.01", 'step'=>"0.01", 'placeholder'=>"0.00",'readonly' => 'readonly')) !!}
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
                                        Total Peso Neto:
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::text('peso_neto', null, array('placeholder' => '0.00','class' => 'form-control','id'=>'peso_neto','readonly' => 'readonly')) !!}
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
                                        Total Cantidad Baldes:
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::number('cantidad', null, array('placeholder' => 'Cantidad de Baldes','class' => 'form-control','id'=>'cantidad', 'placeholder'=>"0", 'readonly'=>'readonly')) !!}
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
                                        {!! Form::text('total', null, array('placeholder' => 'Consto Compra','class' => 'form-control','id'=>'total','readonly' => 'readonly','onkeyup'=>'costo_total();')) !!}
                                    </span>
                                </div>
                            </div>
                        </div>    
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                                
                                    {!!Form::label('Destino','Destino: ')!!}
                                    <select name="id_destino" class="form-control" id="id_destino" style="width: 100%" required></select>
                                </div>
                            </div>
                        </div>                     
                    </div>
                    <div class="row">                          
                        <div class="col-md-5">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Responsabe de Recepción:
                                    </label>
                                    <span class="block input-icon input-icon-right">
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
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-right">
                            <a class="btn btn-danger btn-lg" href="{{ url('AcopioMiel') }}" type="button">
                            Cerrar
                            </a>
                            <!-- {!!link_to('#',$title='Registrar', $attributes=['id'=>'registro','class'=>'btn btn-success'], $secure=null)!!} -->
                            <input type="submit"  value="Registrar" class="btn btn-success btn-lg">
                            </div>
                        </div>
                    </div>
                
            </form>
            
        </div>
    </div>
</div>
@endsection

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


// BUSQUEDAS ASINCRONAS          
$('#id_proveedor').select2({
    // dropdownParent: $('#AcopioFondoAvance'),
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
    // dropdownParent: $('#AcopioFondoAvance'),
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
    // dropdownParent: $('#AcopioFondoAvance'),
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
            $("#costo").val(Number(32).toFixed(2));
        }else{
            $("#rau").val('NO');
            $("#costo").val(Number(29.44).toFixed(2));
        }
    // var numacta = zfill(data[0].prov_id,4);
 //        $("#acta_entrega").val(numacta);
        var fullDate = new Date()
        console.log(fullDate);
        //Thu May 19 2011 17:25:38 GMT+1000 {}
 
        //convert month to 2 digits
        var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
 
        // var currentDate = fullDate.getDate() + "-" + twoDigitMonth + "-" + fullDate.getFullYear();
        var currentDate = fullDate.getFullYear() + "-" + twoDigitMonth + "-" + fullDate.getDate();
        console.log(currentDate);
        if (data[0].prov_fecha_venrau <= currentDate) {
            swal("ALERTA RAU !!","la fecha de vencimiento del rau es: "+data[0].prov_fecha_venrau+", tomar en cuenta actualizar dato del RAU en el proveedor, para el precio de la compra de acopio.","warning");
        }
        // swal("La fecha actual","es"+currentDate,"error");
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

// REGISTRO DE RESPONSABLE DE RECEPCION
 $("#registroRespRecep").click(function(){
        var route="/RespRecep";
         var token =$("#token").val();
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'rec_nombre':$("#rec_nombre").val(),
                   'rec_ap':$("#rec_ap").val(),
                   'rec_am':$("#rec_am").val(),
                   'rec_ci':$("#rec_ci").val()
                    },
                success: function(data){
                    $("#nuevoRespRecep").modal('toggle');
                    swal("El Recepcionista!", "Se ha registrado correctamente!", "success");
                    // $('#lts-acopio').DataTable().ajax.reload();
                    
                },
                error: function(result) {
                    swal("OpssApo..!", "Succedio un problema al registrar inserte bien los datos!", "error");
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

function costo_total(){
// $(document).on('change', '#cantidad', function () {                    
    // var cantidadBaldes=$('#cantidad').val();
    // var pesoTara = $('#peso_tara').val();
    var pesoNeto=$('#peso_neto').val();
    var precioUnitario = $('#costo').val();
    var costo_compra=pesoNeto*precioUnitario;
    // $('#peso_neto').val(Number(pesoNeto).toFixed(2));
    $('#total').val(Number(costo_compra).toFixed(2));
// });
}
$('#fecha_recibo').datepicker({
        format: "dd/mm/yyyy",        
        language: "es",
}).datepicker("setDate", new Date());



// NUEVO TABLA DINAMICA

 
/**
 * Funcion para eliminar la ultima columna de la tabla.
 * Si unicamente queda una columna, esta no sera eliminada
 */

// TERCERA PRUEBA DE TABLA DINAMICA
$('#addMore').on('click', function() {
    var data = $("#tb tr:eq(1)").clone(true).appendTo("#tb");    
    data.find("input").val('');

    var tamano = $('#tb >tbody >tr').length;
    var tamano_actual =tamano-1;
    console.log(tamano);
    $("#nro_tabla").val(tamano_actual);
});
$(document).on('click', '.remove', function() {
    var trIndex = $(this).closest("tr").index();
    if(trIndex>1) {
        $(this).closest("tr").remove();
    } else {
        swal('Lo siento','No puede borrar el unico item');
    }
});


// TABLA DINAMICA
var indexItems = 0;

$('#add_item').click(function () {
    var tamano1 = $('.table >tbody >tr').length;
    $("#cantidad").val(tamano1);
    var contador = tamano1;
    var itemColumn = $(
        '<tr id="items_' + indexItems + '" index="' + indexItems + '" class="items_colums" >'
             + '<td><input id="item_nro_' + indexItems + '" type="number" class="inputt form-control" value='+contador+' min=1 required readonly name="nro[]"></td>'
             + '<td><input onkeyup="sumarHumedad();" autocomplete="off" list="productos" name="humedad_json[]" id="item_humedad_' + indexItems + '" type="number" step=".01" item_id="" class="humedad inputt form-control show-tick form-line" required placeholder="0.00"></td>'
             + '<td><input onkeyup="sumarBruto();" id="item_bruto_' + indexItems + '" type="number" step=".01" class="bruto inputt form-control" placeholder="0.00" min=1 required value="0" name="peso_bruto_json[]"></td>'
             + '<td><input onkeyup="sumarTara();" autocomplete="off" list="productos" name="peso_tara_json[]" id="item_tara_' + indexItems + '" type="number" step=".01" item_id="" class="tara inputt form-control show-tick form-line" required placeholder="0.00" value="0"></td>'
             + '<td><input onkeyup="sumarNeto();" id="item_neto_' + indexItems + '" type="number" step=".01" class="monto inputt form-control" value="0" min=1 required placeholder="0.00" name="peso_neto_json[]"></td>'
             + '<td><select class="estado_balde inputt form-control" name="estado_json[]" id="item_estado_'+indexItems+'"><option value="Aceptado">Aceptado</option><option value="Rechazado">Rechazado</option></select></td>'
             + '<td style="text-align: center"><a href="javascript:void(0)" class="remove_item"><i class="glyphicon glyphicon-remove-sign" style="color: red" ></i></a></td>'
        + '</tr>');
    $('#items_panel').append(itemColumn);
    indexItems++;
});

$(document).on('click', '.remove_item', function () {
    $('#items_' + $(this).parent().parent().attr('index')).remove();
    // document.getElementById('spTotal').innerHTML = 'vuelva a actualizar Datos';
    var cont_baldes = $("#cantidad").val();
    var cont_baldesmenos = cont_baldes - 1;
    $("#cantidad").val(cont_baldesmenos); 
    // sumarNeto();
    // sumarTara();
    // sumarBruto();
    // sumarHumedad();
    sumaElementos();
    costo_total();
});
function sumarHumedad() {
  var totalHumedad = 0;
  $(".humedad").each(function(indice) {
    
    if ($("#item_estado_"+indice).val() == 'Rechazado') {
      totalHumedad += 0;
    } else {
      
      totalHumedad += parseFloat($(this).val());
    }
  });
  document.getElementById('spTotalHumedad').innerHTML = Number(totalHumedad).toFixed(2);
  $("#humedad").val(Number(totalHumedad).toFixed(2));
  costo_total();
}
function sumarBruto() {
  var totalBruto = 0;
  $(".bruto").each(function(indice) {
    if ($("#item_estado_"+indice).val() == 'Rechazado') {
      totalBruto += 0;
    } else {
      
      totalBruto += parseFloat($(this).val());
    }
  });
  document.getElementById('spTotalBruto').innerHTML = Number(totalBruto).toFixed(2);
  $("#peso_bruto").val(Number(totalBruto).toFixed(2));
  costo_total();
}
function sumarTara() {
  var totalTara = 0;
  $(".tara").each(function(indice) {
    if ($("#item_estado_"+indice).val() == 'Rechazado') {
      totalTara += 0;
    } else {
      
      totalTara += parseFloat($(this).val());
    }
  });
  document.getElementById('spTotalTara').innerHTML = Number(totalTara).toFixed(2);
  $("#peso_tara").val(Number(totalTara).toFixed(2));
  costo_total();
}
function sumarNeto() {
  var total = 0;
  $(".monto").each(function(indice) {
    // console.log("Indice: "+indice);
    if ($("#item_estado_"+indice).val() == 'Rechazado') {
      total += 0;
    } else {
      
      total += parseFloat($(this).val());
    }
  });
  document.getElementById('spTotalNeto').innerHTML = Number(total).toFixed(2);
  $("#peso_neto").val(Number(total).toFixed(2));
  costo_total();
}

$(document).on('change', '.bruto', function () {
    // console.log("Esta entrando");
    $(".bruto").each(function (index, elemento) {
        $(document).on('keyup change', '.humedad', function () {
            // console.log("Esta entrando a tara");
            updateTotalItem($(this).parent().parent().attr('index'));
        });
        $(document).on('keyup change', '.tara', function () {
            // console.log("Esta entrando a tara");
            updateTotalItem($(this).parent().parent().attr('index'));
        });
        $(document).on('keyup change', '.bruto', function () {
            // console.log("Esta entrando a bruto");
            updateTotalItem($(this).parent().parent().attr('index'));
        });
        $(document).on('keyup change', '.estado_balde', function () {
            // console.log("Esta entrando a bruto");
            updateTotalItem($(this).parent().parent().attr('index'));
        });
    })
});

function updateTotalItem(index) {
    // console.log(index);
    var peso_bruto = parseFloat($('#item_bruto_' + index).val());
    var peso_tara = parseFloat($('#item_tara_'+index).val());
    var peso_neto = peso_bruto - peso_tara;
    // console.log(peso_neto);
    $('#item_neto_'+index).val(peso_neto);
    // console.log($('#item_estado_'+index).val());
    
        // sumarNeto();
        // sumarTara();
        // sumarBruto();
        // sumarHumedad();
        sumaElementos();
        costo_total();      
    
}

function sumaElementos()
{
    var total_humedad = 0, total_bruto = 0, total_tara = 0, total_neto = 0, nro_balde = 0;
    $('#items_panel tr').each(function(index, element){
        // console.log("numero de indice: "+index);
        nro_balde += 1;
        $(element).find("input").eq(0).val(nro_balde);
        var humedad = $(element).find("input").eq(1).val();
        var peso_bruto = $(element).find("input").eq(2).val();
        var peso_tara = $(element).find("input").eq(3).val();
        var peso_neto = $(element).find("input").eq(4).val();
        var estado_balde = $(element).find('td:eq(5) select').val();
        // console.log(estado_balde);
        if (estado_balde == 'Rechazado') {
            total_humedad += 0;
            total_bruto += 0;
            total_tara += 0;
            total_neto += 0;
            
        }else{
            total_humedad += parseFloat(humedad);
            total_bruto += parseFloat(peso_bruto);
            total_tara += parseFloat(peso_tara);
            total_neto += parseFloat(peso_neto);
        } 
        
    });
    document.getElementById('spTotalHumedad').innerHTML = Number(total_humedad).toFixed(2);
    $("#humedad").val(Number(total_humedad).toFixed(2));
    document.getElementById('spTotalBruto').innerHTML = Number(total_bruto).toFixed(2);
    $("#peso_bruto").val(Number(total_bruto).toFixed(2));
    document.getElementById('spTotalTara').innerHTML = Number(total_tara).toFixed(2);
    $("#peso_tara").val(Number(total_tara).toFixed(2));
    document.getElementById('spTotalNeto').innerHTML = Number(total_neto).toFixed(2);
    $("#peso_neto").val(Number(total_neto).toFixed(2));
    costo_total();
}


</script>
@endpush