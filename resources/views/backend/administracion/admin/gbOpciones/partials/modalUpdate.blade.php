<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="myUpdate" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 container-fluit">
                        <div class="panel panel-warning">
                           <div class="panel-heading">
                            <h4>
                               Actualizar Opcion
                           </h4>
                       </div>
                       <div class="panel-body">
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                        <input id="id" type="hidden">
                        <div class="form-group">
                            {!!Form::label('Opcion', 'grp_id:')!!}
                            {!! Form::select('grp_id', $grupos, null,['class'=>'form-control','name'=>'opc_grp_id', 'id'=>'grp_id']) !!}
                        </div>
                        <div class="form-group">
                            {!!Form::label('Opcion', 'opcion:')!!}
                            {!! Form::text('opc_opcion', null, ['placeholder' => 'Opcion','class'=>'form-control','id'=>'opc_opcion']) !!}
                        </div>
                        <div class="form-group">
                            {!!Form::label('Opcion', 'contenido:')!!}
                            {!! Form::text('opc_contenido', null, ['placeholder' => 'Ingrese el contenido','class'=>'form-control','id'=>'opc_contenido']) !!}
                        </div>
                        
                        <div class="form-group">
                            {!!Form::label('opc_estado', 'opc_estado:')!!}
                            {!! Form::text('opc_estado', null, ['placeholder' => 'Ingrese el estado','class'=>'form-control','id'=>'opc_estado']) !!}
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