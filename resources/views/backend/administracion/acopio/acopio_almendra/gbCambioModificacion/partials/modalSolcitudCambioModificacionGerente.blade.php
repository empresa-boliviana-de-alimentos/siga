<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="modalSolicitudGerente" tabindex="-5">
	<div class="modal-dialog modal-lg" role="document">
       <div class="modal-content">
       		<div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel">
                    MOSTRAR SOLICITUD DE CAMBIO Y/O MODIFICACIONES GERENTE
                </h4>
            </div>
            <div class="modal-body" background-color="#f3f7f9">
            	<div class="row">
            		<div class="col-md-12">
	            		<div class="text-center"><h5><strong>DATOS DEL COMPRADOR</strong></h5></div>
		            	<div class="col-md-6">
		            		<strong>NOMBRE: </strong><span id="nombreComprador"></span> 
		            	</div>
		            	<div class="col-md-6 text-center">
		            		<strong>ZONA: </strong><span id="nombreZona"></span> 
		            	</div>
	            	</div>
            	</div>            	
            		<div class="row">     	
	            		<div class="text-center"><h5><strong>DATOS MODIFICACIÓN</strong></h5></div>
	            		<div class="row">
	            			<div class="col-md-12">
			            		<div class="col-md-6">
			            			<strong>TIPO SOLICITUD: </strong><span id="tipoSolicitud"></span>
			            		</div>
		            		</div>
		            	</div>
		            	
            			<div class="col-md-12" style="background: rgb(7,221,93,0.5)">
            				{!! Form::open(['id'=>'acopio'])!!}
		            		<input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
		            		<input type="hidden" name="solcam_id" id="solcam_id" value="">
		            		<input type="hidden" name="id_zona" value="">
		            		<input type="hidden" name="solcam_id_acopio" id="solcam_id_acopio">
		            		<input type="hidden" name="apsoljefe_id" id="apsoljefe_id">
		            		<div class="text-center"><h5><strong>DATOS ACTUALES DEL ACOPIO</strong></h5></div>   	  			
				            <div class="col-md-3">
				            	<div class="form-group">
				            		<label>CANTIDAD:</label>
					            	<input type="text" name="cantidad" class="form-control" id="cantidadActual" readonly="true">
					            </div>
				            </div>
				            <div class="col-md-3">
				            	<div class="form-group">
				            		<label>COSTO UNITARIO:</label>
					            	<input type="text" name="cantidad" class="form-control" id="costoUnitarioActual" readonly="true" onkeyup="totacopio()">
					            </div>
				            </div>
				            <div class="col-md-3">
				            	<div class="form-group">
				            		<label>COSTO TOTAL:</label>
					            	<input type="text" name="cantidad" class="form-control" id="costoTotalActual" readonly="true" onkeyup="totacopio()">
					            </div>
				            </div>
				            <div class="col-md-3">
				            	<div class="form-group">
				            		<label>PESO CAJA:</label>
					            	<input type="text" name="cantidad" class="form-control" id="pesoCajaActual" readonly="true">
					            </div>
				            </div>
				            <div class="col-md-3">
				            	<div class="form-group">
				            		<label>NRO RECIBO:</label>
					            	<input type="text" name="cantidad" class="form-control" id="nroReciboActual" readonly="true">
					            </div>
				            </div>
				            <div class="col-md-9">
				            	<div class="form-group">
				            		<label>PROVEEDOR:</label>
					            	<input type="text" name="cantidad" class="form-control" id="proveedor" readonly="true">
					            </div>
				            </div>				            		            								
			            </div>
			            <div class="col-md-12" style="background: rgb(231,76,60,0.5)">
            				{!! Form::open(['id'=>'acopio'])!!}
		            		<input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
		            		<input type="hidden" name="id_comprador" id="id_comprador" value="">
		            		<input type="hidden" name="id_zona" value="">
		            		<input type="hidden" name="id_acopio" id="id_acopio">
		            		<div class="text-center"><h5><strong>DATOS A MODIFICAR</strong></h5></div>   	  			
				            <div class="col-md-3">
				            	<div class="form-group">
				            		<label>CANTIDAD:</label>
					            	<input type="text" name="cantidad" class="form-control" id="cantidadModificar" readonly="true">
					            </div>
				            </div>
				            <div class="col-md-3">
				            	<div class="form-group">
				            		<label>COSTO UNITARIO:</label>
					            	<input type="text" name="cantidad" class="form-control" id="costoUnitarioModificar" readonly="true" onkeyup="totacopio()">
					            </div>
				            </div>
				            <div class="col-md-3">
				            	<div class="form-group">
				            		<label>COSTO TOTAL:</label>
					            	<input type="text" name="cantidad" class="form-control" id="costoTotalModificar" readonly="true" onkeyup="totacopio()">
					            </div>
				            </div>
				            <div class="col-md-3">
				            	<div class="form-group">
				            		<label>PESO CAJA:</label>
					            	<input type="text" name="cantidad" class="form-control" id="pesoCajaModificar" readonly="true">
					            </div>
				            </div>
				            <div class="col-md-3">
				            	<div class="form-group">
				            		<label>NRO RECIBO:</label>
					            	<input type="text" name="cantidad" class="form-control" id="nroReciboModificar" readonly="true">
					            </div>
				            </div>
				            <div class="col-md-9">
				            	<div class="form-group">
				            		<label>DESCRIPCION SOLICITUD:</label>
					            	<input type="text" name="cantidad" class="form-control" id="solcam_observacion" readonly="true">
					            </div>
				            </div>				            		            								
			            </div>   	
            		</div>
            		<div class="row">
						<div class="col-md-3">
							<strong>DESCRIPCIÓN REVISIÓN: </strong>
						</div>
						<div class="col-md-9">
							<textarea name="" id="observacion_aprobacion_soljefe" rows="3" class="form-control" readonly="true"></textarea>
						</div>
					</div>
	            	
            </div>
            <div class="row">
				
			</div>
			<div class="modal-footer">	            
	            {!!link_to('#',$title='Aprobar', $attributes=['id'=>'registroApSolGerente','class'=>'btn btn-primary','style'=>'background:#57BC90'], $secure=null)!!}
	            {!!link_to('#',$title='Rechazar', $attributes=['id'=>'rechazarApSolGerente','class'=>'btn btn-danger'], $secure=null)!!}
	            {!! Form::close() !!}            
	            
            </div>
        </div>
            
    </div>
</div>

@push('scripts')
<script>


</script>
@endpush