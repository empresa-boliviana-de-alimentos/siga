<div class="modal fade modal-default" id="myCreate" data-backdrop="static" data-keyboard="false" tabindex="-1">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
              <div class="row">
                <div class="col-xs-12 container-fluit">
                   <div class="panel panel-warning">
                       <div class="panel-heading">
                     <h4>
                     Registrar Rol
                     </h4>
                     </div>
                     <div class="panel-body">
			
				<input type="hidden" name="csrf-token" value="{{ csrf_token() }}" id="token">
				
				<div class="form-group">
					{!!Form::label('Rol','Nuevo Rol: ')!!}
					 {!! Form::text('res.rls_rol', null, array('placeholder' => 'Nombre de Rol','class' => 'form-control','id'=>'rls_rol')) !!}
				</div>
				<div class="form-group">
                    		    <div class="col-sm-12">
                        		<label>
                            			Area Produccion:
                        		</label>
                        		<select class="form-control" id="lineatrabajo" name="lineatrabajo1" required>
                            		   <option value="">Elija una opcion</option>
                            			@foreach($linea_trabajo as $list)
                            		   	<option value="{{$list->ltra_id}}">
                                			{{$list->ltra_nombre}}
                            			</option>
                            			@endforeach
                        		</select>
                    		   </div>
                		</div>		
			</div>
			</div>
			</div>
			</div>
			</div>
			<div class="modal-footer">
	 			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				{!!link_to('#',$title='Registrar', $attributes=['id'=>'registro','class'=>'btn btn-warning'], $secure=null)!!}
			
			</div>
				
		</div>
	</div>
</div>

