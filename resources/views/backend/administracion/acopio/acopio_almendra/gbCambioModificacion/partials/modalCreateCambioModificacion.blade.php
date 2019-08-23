<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myCreateCambioModificacion" tabindex="-5">
	<div class="modal-dialog modal-lg" role="document">
       <div class="modal-content">
       		<div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel">
                    SOLICITUD DE CAMBIO Y/O MODIFICACIONES
                </h4>
            </div>
            <div class="modal-body" background-color="#f3f7f9">
            	<div class="row">
	            	<div class="text-center"><h5><strong>DATOS DEL COMPRADOR</strong></h5></div>
	            	<div class="col-md-6 text-center">
	            		<strong>NOMBRE:</strong> {{$comprador->prs_nombres.' '.$comprador->prs_paterno.' '.$comprador->prs_materno}}
	            	</div>
	            	<div class="col-md-6 text-center">
	            		<strong>ZONA:</strong> {{ $comprador->zona_nombre }}
	            	</div>
            	</div>
            	
            	<div class="row">     	
	            	<div class="text-center"><h5><strong>DATOS MODIFICACIÓN</strong></h5></div>
	            	<div class="col-md-3">
	            		<div class="list-group">
	            			<p class="list-group-item active text-center">
	            				TIPO SOLICITUD
	            			</p>
	            			<p class="list-group-item"><input type="radio" name="cantidad" id="checkCantidad" onchange="javascript:showContent()" value="1" checked="true"> POR CANTIDAD </p>
	            			<p class="list-group-item"><input type="radio" name="cantidad" id="checkPeso" onchange="javascript:showContent()" value="2"> POR PESO</p>
	            			<p class="list-group-item"><input type="radio" name="cantidad" id="checkNroRecibo" onchange="javascript:showContent()" value="3"> POR NRO RECIBO</p>
	            			<p class="list-group-item"><input type="radio" name="cantidad" id="checkEliminacion" onchange="javascript:showContent()" value="4"> ELIMINACION</p>
	 						<p class="list-group-item"><input type="radio" name="cantidad" id="checkPrecio" onchange="javascript:showContent()" value="5"> POR PRECIO</p>
           			
	            		</div>
            		</div>
            		<div class="col-md-9">
            			{!! Form::open(['id'=>'acopio'])!!}
		            	<input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
		            	<input type="hidden" name="id_comprador" id="id_comprador" value="{{$comprador->usr_id}}">
		            	<input type="hidden" name="id_zona" value="{{$comprador->zona_id}}">
		            	<input type="hidden" name="id_acopio" id="id_acopio">		            	
		            	
		            		<div id="opcionCantidad">
		            			<div class="text-center"><strong>SOLICITUD POR CANTIDAD</strong></div>
		            			<div class="col-md-12">
		            				<div class="form-group">
				            			<label>NRO RECIBO:</label>
					            		<select name="acopioRealizado" id="buscarAcopio" class="form-control" style="width: 100%"></select>
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>CANTIDAD ACTUAL:</label>
					            		<input type="text" name="cantidad" class="form-control" id="cantidadActual" readonly="true">
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>CAMBIAR CANTIDAD A:</label>
					            		<input type="number" name="cantidad" class="form-control" id="cantidadCambio" onkeyup="totacopio()" min="0.01" step="0.01" placeholder="0.00">
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>COSTO UNITARIO:</label>
					            		<input type="text" name="cantidad" class="form-control" id="costoUnitario" readonly="true" onkeyup="totacopio()">
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>COSTO TOTAL:</label>
					            		<input type="text" name="cantidad" class="form-control" id="costoTotal" readonly="true" onkeyup="totacopio()">
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>PESO CAJA:</label>
					            		<input type="text" name="cantidad" class="form-control" id="pesoCaja" readonly="true">
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>NRO RECIBO:</label>
					            		<input type="text" name="cantidad" class="form-control" id="nroRecibo" readonly="true">
					            	</div>
				            	</div>
				            	<div class="col-md-12">
				            		<div class="form-group">
				            			<label>PROVEEDOR:</label>
					            		<input type="text" name="cantidad" class="form-control" id="proveedor" readonly="true">
					            	</div>
				            	</div>
			            	</div>
			            	<div id="opcionPeso" style="display: none;">
			            		<div class="text-center"><strong>SOLICITUD POR PESO</strong></div>
			            		<div class="col-md-12">
				            		<div class="form-group">
					            			<label>NRO RECIBO:</label>
						            		<select name="acopioRealizado" id="buscarAcopio1" class="form-control" style="width: 100%"></select>
						            	</div>
					            </div>
				            	
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>PESO CAJA:</label>
					            		<input type="text" name="cantidad" class="form-control" id="pesoActual1" readonly="true">
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>CAMBIAR PESO CAJA A:</label>
					            		<input type="text" name="cantidad" class="form-control" id="pesoCambio1">
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>CANTIDAD :</label>
					            		<input type="text" name="cantidad" class="form-control" id="cantidad1" readonly="true">
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>COSTO UNITARIO:</label>
					            		<input type="text" name="cantidad" class="form-control" id="costoUnitario1" readonly="true">
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>COSTO TOTAL:</label>
					            		<input type="text" name="cantidad" class="form-control" id="costoTotal1" readonly="true">
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>NRO RECIBO:</label>
					            		<input type="text" name="cantidad" class="form-control" id="nroRecibo1" readonly="true">
					            	</div>
				            	</div>
				            	<div class="col-md-12">
				            		<div class="form-group">
				            			<label>PROVEEDOR:</label>
					            		<input type="text" name="cantidad" class="form-control" id="proveedor1" readonly="true">
					            	</div>
				            	</div>
			            	</div>
							<div id="opcionNroRecibo" style="display: none;">
								<div class="text-center"><strong>SOLICITUD POR NRO DE RECIBO</strong></div>
								<div class="col-md-12">
		            				<div class="form-group">
				            			<label>NRO RECIBO:</label>
					            		<select name="acopioRealizado" id="buscarAcopio2" class="form-control" style="width: 100%"></select>
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>NRO RECIBO ACTUAL:</label>
					            		<input type="text" name="cantidad" class="form-control" id="nroReciboActual2" readonly="true">
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>CAMBIAR NRO RECIBO A:</label>
					            		<input type="text" name="cantidad" class="form-control" id="nroReciboNuevo">
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>CANTIDAD :</label>
					            		<input type="text" name="cantidad" class="form-control" id="cantidad2" readonly="true">
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>COSTO UNITARIO:</label>
					            		<input type="text" name="cantidad" class="form-control" id="costoUnitario2" readonly="true">
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>COSTO TOTAL:</label>
					            		<input type="text" name="cantidad" class="form-control" id="costoTotal2" readonly="true">
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>PESO CAJA:</label>
					            		<input type="text" name="cantidad" class="form-control" id="pesoCaja2" readonly="true">
					            	</div>
				            	</div>
				            	<div class="col-md-12">
				            		<div class="form-group">
				            			<label>PROVEEDOR:</label>
					            		<input type="text" name="cantidad" class="form-control" id="proveedor2" readonly="true">
					            	</div>
				            	</div>			            	
				            </div>
							<div id="opcionEliminacion" style="display: none;">
								<div class="text-center"><strong>SOLICITUD POR ELIMINACIÓN</strong></div>
								<div class="col-md-12">
		            				<div class="form-group">
				            			<label>NRO RECIBO:</label>
					            		<select name="acopioRealizado" id="buscarAcopio3" class="form-control" style="width: 100%"></select>
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>NRO RECIBO:</label>
					            		<input type="text" name="cantidad" class="form-control" id="nroRecibo3" readonly="true">
					            	</div>
				            	</div>				            	
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>CANTIDAD:</label>
					            		<input type="text" name="cantidad" class="form-control" id="cantidad3" readonly="true">
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>COSTO UNITARIO:</label>
					            		<input type="text" name="cantidad" class="form-control" id="costoUnitario3" readonly="true">
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>COSTO TOTAL:</label>
					            		<input type="text" name="cantidad" class="form-control" id="costoTotal3" readonly="true">
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>PESO CAJA:</label>
					            		<input type="text" name="cantidad" class="form-control" id="pesoCaja3" readonly="true">
					            	</div>
				            	</div>
				            	<div class="col-md-12">
				            		<div class="form-group">
				            			<label>PROVEEDOR:</label>
					            		<input type="text" name="cantidad" class="form-control" id="proveedor3" readonly="true">
					            	</div>
				            	</div>
			            	</div>
							<div id="opcionPrecio" style="display: none;">
								<div class="text-center"><strong>SOLICITUD POR PRECIO</strong></div>
								<div class="col-md-12">
		            				<div class="form-group">
				            			<label>NRO RECIBO:</label>
					            		<select name="acopioRealizado" id="buscarAcopio4" class="form-control" style="width: 100%"></select>
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>COSTO U. ACTUAL:</label>
					            		<input type="text" name="cantidad" class="form-control" id="costoUnitarioActual4" readonly="true">
					            	</div>
				            	</div>				            	
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>COSTO U. CAMBIAR A:</label>
					            		<input type="text" name="cantidad" class="form-control" id="costoUnitarioNuevo" min="0.01" step="0.01" placeholder="0.00" onkeyup="totacopio2()">
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>CANTIDAD:</label>
					            		<input type="text" name="cantidad" class="form-control" id="cantidad4" readonly="true" onkeyup="totacopio2()">
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>COSTO TOTAL:</label>
					            		<input type="text" name="cantidad" class="form-control" id="costoTotal4" readonly="true" onkeyup="totacopio2()">
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>PESO CAJA:</label>
					            		<input type="text" name="cantidad" class="form-control" id="pesoCaja4" readonly="true">
					            	</div>
				            	</div>
				            	<div class="col-md-4">
				            		<div class="form-group">
				            			<label>NRO RECIBO:</label>
					            		<input type="text" name="cantidad" class="form-control" id="nroRecibo4" readonly="true">
					            	</div>
				            	</div>
				            	<div class="col-md-12">
				            		<div class="form-group">
				            			<label>PROVEEDOR:</label>
					            		<input type="text" name="cantidad" class="form-control" id="proveedor4" readonly="true">
					            	</div>
				            	</div>
			            	</div>
			            </div>
		          
		            	
		            	
            		</div>
	            	
            </div>
            <div class="row">
				<div class="col-md-3">
					<strong>DESCRIPCIÓN SOLICITUD: </strong>
				</div>
				<div class="col-md-9">
					<textarea name="" id="observacion_sol" rows="3" class="form-control"></textarea>
				</div>
			</div>
			<div class="modal-footer">
	            <button class="btn btn-danger" data-dismiss="modal" type="button">
	                Cerrar
	            </button>
	            {!!link_to('#',$title='Solicitar', $attributes=['id'=>'registroSolCam','class'=>'btn btn-primary','style'=>'background:#57BC90'], $secure=null)!!}
	            {!! Form::close() !!}
            </div>
        </div>
            
    </div>
</div>

@push('scripts')
<script>
// POR CANTIDAD
$('#buscarAcopio').select2({
    dropdownParent: $('#myCreateCambioModificacion'),
    placeholder: "Buscar nro de Acopio",
    comunidad: true,
    tokenSeparators: [','],
    ajax: {
        dataType: 'json',
        url: '{{ url("obtenerAcopioAlmendra") }}',
        delay: 250,
        data: function(params) {
        	console.log(params);
            return {
                term: params.term
            }
        },
        processResults: function (data, page) {
        	console.log(data);
            return {
            results: data
            };
        },
    },
    language: "es",
});
// POR PESO
$('#buscarAcopio1').select2({
    dropdownParent: $('#myCreateCambioModificacion'),
    placeholder: "Buscar nro de Acopio",
    comunidad: true,
    tokenSeparators: [','],
    ajax: {
        dataType: 'json',
        url: '{{ url("obtenerAcopioAlmendra") }}',
        delay: 250,
        data: function(params) {
        	console.log(params);
            return {
                term: params.term
            }
        },
        processResults: function (data, page) {
        	console.log(data);
            return {
            results: data
            };
        },
    },
    language: "es",
});
// POR NRO RECIBO
$('#buscarAcopio2').select2({
    dropdownParent: $('#myCreateCambioModificacion'),
    placeholder: "Buscar nro de Acopio",
    comunidad: true,
    tokenSeparators: [','],
    ajax: {
        dataType: 'json',
        url: '{{ url("obtenerAcopioAlmendra") }}',
        delay: 250,
        data: function(params) {
        	console.log(params);
            return {
                term: params.term
            }
        },
        processResults: function (data, page) {
        	console.log(data);
            return {
            results: data
            };
        },
    },
    language: "es",
});
// POR ELIMINACION
$('#buscarAcopio3').select2({
    dropdownParent: $('#myCreateCambioModificacion'),
    placeholder: "Buscar nro de Acopio",
    comunidad: true,
    tokenSeparators: [','],
    ajax: {
        dataType: 'json',
        url: '{{ url("obtenerAcopioAlmendra") }}',
        delay: 250,
        data: function(params) {
        	console.log(params);
            return {
                term: params.term
            }
        },
        processResults: function (data, page) {
        	console.log(data);
            return {
            results: data
            };
        },
    },
    language: "es",
});
// POR PRECIO
$('#buscarAcopio4').select2({
    dropdownParent: $('#myCreateCambioModificacion'),
    placeholder: "Buscar nro de Acopio",
    comunidad: true,
    tokenSeparators: [','],
    ajax: {
        dataType: 'json',
        url: '{{ url("obtenerAcopioAlmendra") }}',
        delay: 250,
        data: function(params) {
        	console.log(params);
            return {
                term: params.term
            }
        },
        processResults: function (data, page) {
        	console.log(data);
            return {
            results: data
            };
        },
    },
    language: "es",
});
// OCULTAR CAMPOS
function showContent() {
    elementCantidad = document.getElementById("opcionCantidad");
    checkCantidad = document.getElementById("checkCantidad");
    elemenPeso = document.getElementById("opcionPeso");
    checPeso = document.getElementById("checkPeso");
    elementNroRecibo = document.getElementById("opcionNroRecibo");
    checkNroRecibo = document.getElementById("checkNroRecibo");
    elementEliminacion = document.getElementById("opcionEliminacion");
    checkEliminacion = document.getElementById("checkEliminacion");
    elementPrecio = document.getElementById("opcionPrecio");
    checkPrecio = document.getElementById("checkPrecio");
    if (checkCantidad.checked) {
        elementCantidad.style.display='block';
        elemenPeso.style.display='none';
        elementNroRecibo.style.display='none';
        elementEliminacion.style.display='none';
    }
    else if(checkPeso.checked) {
    	elementCantidad.style.display='none';
        elemenPeso.style.display='block';
        elementNroRecibo.style.display='none';
        elementEliminacion.style.display='none';
        elementPrecio.style.display= 'none';
    }else if(checkNroRecibo.checked){
    	elementCantidad.style.display='none';
        elemenPeso.style.display='none';
        elementNroRecibo.style.display='block';
        elementEliminacion.style.display='none';
        elementPrecio.style.display = 'none';
    }else if(checkEliminacion.checked){
    	elementCantidad.style.display='none';
        elemenPeso.style.display='none';
        elementNroRecibo.style.display='none';
        elementEliminacion.style.display='block';
        elementPrecio.style.display='none';
    }else if(checkPrecio.checked){
    	elementCantidad.style.display='none';
        elemenPeso.style.display='none';
        elementNroRecibo.style.display='none';
        elementEliminacion.style.display='none';
        elementPrecio.style.display='block';
    }
}
// COLOCANDO DATOS DE ACOPIO SELECCIONADO
$('#buscarAcopio').on('change', function(e){
    var acopio_id = e.target.value;
    console.log(acopio_id);
    $.get('traerAcopioAlmendra?acopio_id='+acopio_id, function(data){
    	console.log(data);
    	$("#id_acopio").val(data.aco_id)
    	$("#cantidadActual").val(data.aco_cantidad);
    	$("#costoUnitario").val(data.aco_cos_un);
    	$("#costoTotal").val(data.aco_cos_total);
    	$("#pesoCaja").val(data.aco_peso_neto);
    	$("#nroRecibo").val(data.aco_num_rec);
    	$("#proveedor").val(data.prov_nombre+' '+data.prov_ap+' '+data.prov_am+' , CI: '+data.prov_ci);                   
    });
});
// COLOCANDO DATOS DE ACOPIO SELECCIONADO
$('#buscarAcopio1').on('change', function(e){
    var acopio_id = e.target.value;
    console.log(acopio_id);
    $.get('traerAcopioAlmendra?acopio_id='+acopio_id, function(data){
    	console.log(data);
    	$("#id_acopio").val(data.aco_id)
    	$("#pesoActual1").val(data.aco_peso_neto);
    	$("#cantidad1").val(data.aco_cantidad);
    	$("#costoUnitario1").val(data.aco_cos_un);
    	$("#costoTotal1").val(data.aco_cos_total);
    	$("#nroRecibo1").val(data.aco_num_rec);
    	$("#proveedor1").val(data.prov_nombre+' '+data.prov_ap+' '+data.prov_am+' , CI: '+data.prov_ci);                   
    });
});
// COLOCANDO DATOS DE ACOPIO SELECCIONADO
$('#buscarAcopio2').on('change', function(e){
    var acopio_id = e.target.value;
    console.log(acopio_id);
    $.get('traerAcopioAlmendra?acopio_id='+acopio_id, function(data){
    	console.log(data);
    	$("#id_acopio").val(data.aco_id)
    	$("#nroReciboActual2").val(data.aco_num_rec);
    	$("#cantidad2").val(data.aco_cantidad);
    	$("#costoUnitario2").val(data.aco_cos_un);
    	$("#costoTotal2").val(data.aco_cos_total);
    	$("#pesoCaja2").val(data.aco_peso_neto);
    	$("#proveedor2").val(data.prov_nombre+' '+data.prov_ap+' '+data.prov_am+' , CI: '+data.prov_ci);                   
    });
});
// COLOCANDO DATOS DE ACOPIO SELECCIONADO
$('#buscarAcopio3').on('change', function(e){
    var acopio_id = e.target.value;
    console.log(acopio_id);
    $.get('traerAcopioAlmendra?acopio_id='+acopio_id, function(data){
    	console.log(data);
    	$("#id_acopio").val(data.aco_id)
    	$("#nroRecibo3").val(data.aco_num_rec);
    	$("#cantidad3").val(data.aco_cantidad);
    	$("#costoUnitario3").val(data.aco_cos_un);
    	$("#costoTotal3").val(data.aco_cos_total);
    	$("#pesoCaja3").val(data.aco_peso_neto);
    	$("#proveedor3").val(data.prov_nombre+' '+data.prov_ap+' '+data.prov_am+' , CI: '+data.prov_ci);                   
    });
});
// COLOCANDO DATOS DE ACOPIO SELECCIONADO
$('#buscarAcopio4').on('change', function(e){
    var acopio_id = e.target.value;
    console.log(acopio_id);
    $.get('traerAcopioAlmendra?acopio_id='+acopio_id, function(data){
    	console.log(data);
    	$("#id_acopio").val(data.aco_id)
    	$("#costoUnitarioActual4").val(data.aco_cos_un);
    	$("#cantidad4").val(data.aco_cantidad);
    	$("#costoTotal4").val(data.aco_cos_total);
    	$("#pesoCaja4").val(data.aco_peso_neto);
    	$("#nroRecibo4").val(data.aco_num_rec);
    	$("#proveedor4").val(data.prov_nombre+' '+data.prov_ap+' '+data.prov_am+' , CI: '+data.prov_ci);                   
    });
});
// NUMBER FORMAT
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
// CALCULOS PARA CANTIDAD
function totacopio(){
    var cant= document.getElementById("cantidadCambio").value;
    console.log(cant);
    var costo= document.getElementById("costoUnitario").value;
    console.log(costo);
    var total =  cant * costo;
    var total =  number_format(total,2,'.','');
    document.getElementById("costoTotal").value= total;    
}
// CALCULOS PARA PRECIO
function totacopio2(){
    var cant= document.getElementById("cantidad4").value;
    console.log(cant);
    var costo= document.getElementById("costoUnitarioNuevo").value;
    console.log(costo);
    var total =  cant * costo;
    var total =  number_format(total,2,'.','');
    document.getElementById("costoTotal4").value= total;    
}

</script>
@endpush