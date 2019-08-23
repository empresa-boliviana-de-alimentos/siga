<div class="modal fade bs-example-modal-sm in" style="overflow-y: scroll;" data-backdrop="static" data-keyboard="false" id="acopioProductor" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">脳</button>
                    <h4 class="modal-title">Registro de Acopio por Productor</h4>
                </div>
            <div class="modal-body">
                <div class="caption">
                    <?php $now = new \DateTime('America/La_Paz'); ?>
                    
                        {!! Form::open(['id'=>'acopio'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            
                            <input id="fecha_resgistro" name="fecha_resgistro" type="hidden" value="<?php echo $now->format('d-m-Y H:i:s'); ?>">
			    <input type="hidden" name="nro_acopio" id="nro_acopio" value="">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <div class="text-center">                                                   
                                                    <img src="" width="100px" height="100px" id="fotoProductor" name="img">
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
                                                <select name="id_proveedor" class="form-control" id="id_proveedorProductor" style="width: 100%"></select>
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
                                                    
                                                    {!! Form::text('acta_entrega', null, array('placeholder' => 'Ingrese el numero de acopio', 'class' => 'form-control','id'=>'acta_entrega', 'readonly')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <strong>Datos del Apiario</strong>
                                    </div>                              
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Departamento:
                                                </label>
                                                
                                                {!! Form::text('departamento', null, array('placeholder' =>'Departamento ','maxlength'=>'10','class' => 'form-control','id'=>'departamento','readonly' => 'readonly')) !!}
                                            </div>
                                        </div>
                                    </div>                         
                                
                                        <div class="col-md-3">
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
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Comunidad:
                                                    </label>
                                                    <span class="block input-icon input-icon-right">
                                                       {!! Form::text('comunidad', null, array('placeholder' =>'Comunidad ','maxlength'=>'10','class' => 'form-control','id'=>'comunidad','readonly' => 'reaconly')) !!}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                </div>
                                <label class="" for="">Ubicaci贸n Geogr谩fica:</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div id="map" style="with:90px;height:90px;">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        {!! Form::label('lat_map','Latitud :',['class'=>'col-sm-2 control-label']) !!}
                                        <div class="col-sm-4">
                                            {!! Form::number('lat_map',null,['id'=>'coordslat','class'=>'form-control','placeholder'=>'Introduzca latitud del mapa','step'=>'any','readonly']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {!! Form::label('lng_map','Longitud :',['class'=>'col-sm-2 control-label']) !!}
                                        <div class="col-sm-4">
                                            {!! Form::number('lng_map',null,['id'=>'coordslng','class'=>'form-control','placeholder'=>'Introduzca longitud del mapa','step'=>'any','readonly']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">                              
                                    <h5 class="text-center"><strong>CODIGO DE LAS COLMENAS</strong></h5>
                                </div>
                                <div class="">
                                        <button class="btn btn-info waves-effect" type="button" id="add_item"
                                                href="javascript:void(0)">A脩ADIR
                                        </button>
                                    </div>
                                    <div class="form-group">
                                        <table id="invoice_items" class="table">
                                            <tbody>
                                            <tr>
                                                <th style="text-align: right">C贸digos</th>
                                                <th style="text-align: right">Numeros de Marcas</th>
                                                
                                                <th></th>
                                            </tr>
                                            </tbody>
                                            <tbody id="items_panel">
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th colspan="1" class="text-right text-primary"
                                                    style="padding-right: 10px">
                                                    TOTAL:
                                                </th>
                                                <th style="text-align: right"><span id="spTotal"
                                                                                    class="text-primary">0.00</span>
                                                </th>
                                            </tr>
                                            </tfoot>
                                        </table>   

                                    </div>
                                <div class="row">                              
                                    <h5 class="text-center"><strong>DATOS ACOPIO Nro: <span id="numacomielProd"></span></strong></h5>
                                </div> 
                               
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    N掳 MARCOS CENTRIFUGADOS:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('nro_marcocentrif', null, array('maxlength'=>'10','class' => 'form-control','id'=>'nro_marcocentrif')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    P. BRUTO BALDES MIEL FILT.:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    <!-- {!! Form::text('br_baldesfilt', null, array('maxlength'=>'10','class' => 'form-control','id'=>'br_baldesfilt')) !!} -->
                                                    <input type="number" class="form-control" id="br_baldesfilt" name="br_baldesfilt" min="0.01" step="0.01" onkeyup="brbaldescentrif()" required>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    P. BRUTO BALDES MIEL CENTRI.:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('br_baldescentrif', null, array('maxlength'=>'10','class' => 'form-control','id'=>'br_baldescentrif','readonly'=>'readonly')) !!}
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
                                                    P. BRUTO BALDES CON IMP.:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                   <!--  {!! Form::text('br_baldesimpu', null, array('maxlength'=>'10','class' => 'form-control','id'=>'br_baldesimpu')) !!} -->
                                                   <input type="number" class="form-control" id="br_baldesimpu" name="br_baldesimpu" min="0.01" step="0.01" onkeyup="brbaldescentrif()" required>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    NUMERO DE BALDES:
                                                </label>
                                                <span class="block input-icon input-icon-right">                          
                                                    <!-- {!! Form::text('cant_baldes', null, array('maxlength'=>'10','class' => 'form-control','id'=>'cant_baldes')) !!} -->
                                                    <input type="number" class="form-control" id="cant_baldes" name="cant_baldes" min="0.01" step="0.01" onkeyup="pesoNetoTotal()" required>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    P. NETO MIEL PRODUCCION PROPIA:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('peso_neto', null, array('class' => 'form-control','id'=>'peso_neto','readonly'=>'readonly')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                
                                                {!!Form::label('Destino','Destino: ')!!}

                                                {!! Form::select('id_destino', $destino, null,['class'=>'form-control','name'=>'id_destino', 'id'=>'id_destino','placeholder'=>'Seleccione']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Acopio de materia prima:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                   <select class="form-control" id="aco_mapri" name="aco_mapri" placeholder="Elija una opcion" value="">
                                                        <!-- <option value="0">Elija una opci贸n</option> -->
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
                                     <div id="dvOcultar">
                                         <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Observaci贸n:
                                                    </label>
                                                    <span class="block input-icon input-icon-right">
                                                        {!! Form::text('observacion', null, array('placeholder' => 'Observacion','class' => 'form-control','id'=>'observacion','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Responsabe de Recepci贸n:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    <!-- {!! Form::select('id_resp_recepcion', $resp_recep, null,['class'=>'form-control','name'=>'id_resp_recepcion', 'id'=>'id_resp_recepcion']) !!} -->
                                                    <select name="id_resp_recepcion" class="form-control" id="id_resp_recepcion" style="width: 100%"></select>
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
                                </div>
                                
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

                <script>
                    var marker;
                    var coords = {};
                    //Funcion principal
                    initMap = function () 
                    {
                        //usamos la API para geolocalizar el usuario
                        navigator.geolocation.getCurrentPosition(
                            function (position){
                                coords = {
                                    lng: position.coords.longitude,
                                    lat: position.coords.latitude
                                };
                            setMapa(coords);//pasamos las coordenadas al metodo para crear mapa

                            }, function(error){console.log(error);});
                    }

                    function setMapa (coordslat, coordslng)
                    {
                        //se crea una nueva instancia del objeto mapa
                        var map = new google.maps.Map(document.getElementById('map'),
                        {
                            zoom: 13,
                            center: new google.maps.LatLng(coords.lat,coords.lng),
                        }); 
                        //Creamos el marcador en el mapa con sus propiedades
                        //para nuestro objetivo tenemos que poner el atributo draggable en true
                        //position pondremos las mismas Coordenadas que obtuvimos en la geolocalizacion
                        marker = new google.maps.Marker({
                            map: map,
                            draggable: true,
                            animation: google.maps.Animation.DROP,
                            position: new google.maps.LatLng(coords.lat,coords.lng),
                        });
                        //agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica 
                        //cuando el usuario a soltado el marcador
                        marker.addListener('click', toggleBounce);
                        marker.addListener('dragend', function(event)
                        {
                            //escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
                            document.getElementById("coordslat").value = this.getPosition().lat();
                            document.getElementById("coordslng").value = this.getPosition().lng();
                        });
                    }

                    //callback al hacer click en el marcador lo que hace es quitar y poner la animacion BOUNCE
                    function toggleBounce(){
                        if (marker.getAnimation() !== null) {
                            marker.setAnimation(null);
                        }else{
                            marker.setAnimation(google.maps.Animation.BOUNCE);
                        }
                    }
                    //Carga de la libreria de google maps
                    </script>
                    <script async defer
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCQ8D5zq8vK9PnanQ36WW9-DpwI8vmtyB0&callback=initMap">
                    </script>
                <!--END MAPA-->

<script type="text/javascript">
$('#dvOcultar').hide();
$(function(){
    $('#aco_mapri').change(function(){
    if($(this).val()==1){
        $('#dvOcultar').hide();
    }else{
        $('#dvOcultar').show();
    }
  
  })

});

// BUSQUEDAS ASINCRONAS          
$('#id_proveedorProductor').select2({
    dropdownParent: $('#acopioProductor'),
    placeholder: "Selec. Proveedor",
    proveedor: true,
    tokenSeparators: [','],
    ajax: {
        dataType: 'json',
        url: '{{ url("obtenerProveedorProd") }}',
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
    //dropdownParent: $('#acopioProductor'),
     minimumResultsForSearch: Infinity,
    placeholder: "Selec. Responsable de Recepci贸n",
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
$('#id_proveedorProductor').on('change', function(e){
    var rutaImagen= "imagenes/proveedores/miel/";
    var prov_id = e.target.value;
    $.get('/ajax-proveedorfaprod?prov_id='+prov_id, function(data){
        console.log(data);
        $("#fotoProductor").attr("src",rutaImagen+data[0].prov_foto);
        $("#departamento").val(data[0].dep_nombre);
        $("#municipio").val(data[0].mun_nombre);
        $("#comunidad").val(data[0].com_nombre);
        $("#central_orgProductor").val(data[0].aso_nombre);
        if (data[0].prov_rau == 1) {
            $("#rauProductor").val('SI');
        }else{
            $("#rauProductor").val('NO');
        }
        // var numacta = zfill(data[0].prov_id,4);
        // $("#acta_entrega").val(numacta);

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
        document.getElementById("numacomielProd").innerHTML = aconumaco;
        // var numacta = zfill(data[0].prov_id,4);
        var numacta = zfill(data[0].prov_id,4)+'/'+zfill(aconumaco,3);
        $("#acta_entrega").val(numacta); 
        
    });
});
function zfill(number, width) {
    var numberOutput = Math.abs(number); /* Valor absoluto del n鷐ero */
    var length = number.toString().length; /* Largo del n鷐ero */ 
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

var indexItems = 0;

$('#add_item').click(function () {
    var itemColumn = $(
        '<tr id="items_' + indexItems + '" index="' + indexItems + '" class="items_colums" >'
             + '<td><input autocomplete="off" list="productos" name="productos" id="item_codigo_' + indexItems + '" type="text" item_id="" class="inputt form-control show-tick form-line" required onkeyup="javascript:this.value=this.value.toUpperCase();"></td>'
             + '<td width="80px"><input onkeyup="sumar();"  id="item_marca_' + indexItems + '" type="number" class="monto inputt form-control" value="1" min=1 required></td>'
             + '<td style="text-align: center"><a href="javascript:void(0)" class="remove_item"><i class="glyphicon glyphicon-remove-sign" style="color: red" ></i></a></td>'
        + '</tr>');
    $('#items_panel').append(itemColumn);
    indexItems++;
});

$(document).on('click', '.remove_item', function () {
    $('#items_' + $(this).parent().parent().attr('index')).remove();
    // document.getElementById('spTotal').innerHTML = 'vuelva a actualizar Datos';
    sumar();
});



function sumar() {

  var total = 0;

  $(".monto").each(function() {

    if (isNaN(parseFloat($(this).val()))) {

      total += 0;

    } else {

      total += parseFloat($(this).val());

    }

  });

  document.getElementById('spTotal').innerHTML = total;

}

function brbaldescentrif(){

    var brbaldesfilt= parseFloat($("#br_baldesfilt").val());
    var brbaldesimpu= parseFloat($("#br_baldesimpu").val());
    var totabaldescent= number_format(brbaldesfilt+brbaldesimpu,2,'.','');
       
    document.getElementById("br_baldescentrif").value= totabaldescent;
    
}

function pesoNetoTotal(){

    var cantBaldes= parseFloat($("#cant_baldes").val());
    var pesoTara= parseFloat(1.200);
    var brbaldescentrif = parseFloat($("#br_baldesfilt").val());
    var pesoNetoTota= number_format((cantBaldes*pesoTara)-brbaldescentrif,2,'.','');
       
    document.getElementById("peso_neto").value= pesoNetoTota;
    
}

  function number_format (number, decimals, dec_point, thousands_sep){
  
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? '' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function (n, prec) 
    {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
     if (s[0].length > 3) 
    {
      s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) 
    {
      s[1] = s[1] || '';
      s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
  }
</script>
@endpush