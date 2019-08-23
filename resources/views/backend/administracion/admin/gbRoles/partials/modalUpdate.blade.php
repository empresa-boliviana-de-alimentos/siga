<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="myUpdate" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
              <div class="row">
                <div class="col-xs-12 container-fluit">
                 <div class="panel panel-warning">
                     <div class="panel-heading">
                       <h4>
                           Actualizar Rol
                       </h4>
                   </div>
                   <div class="panel-body">
                    <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                    <input id="id" type="hidden">
                    
                    <div class="form-group">
                        {!!Form::label('rol', 'Rol:')!!}
                        {!! Form::text('rls_rol', null, ['placeholder' => 'Ingrese el nombre de Rol','class'=>'form-control','id'=>'rol']) !!}
                    </div>
		    <div class="form-group">
                      <div class="col-sm-12">
                        <label>
                            Area Produccion:
                        </label>
                        <select class="form-control" id="lineatrabajo1" name="lineatrabajo1" required>
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
    <button class="btn btn-default" data-dismiss="modal" type="button">
        Cerrar
    </button>
    {!!link_to('#',$title='Actualizar', $attributes=['id'=>'actualizar','class'=>'btn btn-warning'], $secure=null)!!}
</div>
</div>
</div>
</div>