<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="myCreate" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 container-fluit">
                        <div class="panel panel-warning">
                           <div class="panel-heading">
                            <h4>
                               Registrar Opcion
                           </h4>
                       </div>
                       <div class="panel-body">
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                        <div class="form-group">
                            {!!Form::label('Opcion','grp_id: ')!!}
                            {!! Form::select('grp_id', $grupos, null,['class'=>'form-control','name'=>'opc_grp_id', 'id'=>'grpid']) !!}
                        </div>
                        <div class="form-group">
                            {!!Form::label('Opcion','opcion:')!!}
                            {!! Form::text('opc_opcion', null, array('placeholder' => 'Nombre de la opcion','class' => 'form-control','id'=>'opcopcion')) !!}
                        </div>
                        <div class="form-group">
                            {!!Form::label('Opcion','contenido:')!!}
                            {!! Form::text('opc_contenido', null, array('placeholder' => 'Contenido Detalle','class' => 'form-control','id'=>'opccontenido')) !!}
                        </div>
                    </input>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-default" data-dismiss="modal" type="button">
        Cerrar
    </button>
    {!!link_to('#',$title='Registrar', $attributes=['id'=>'registro','class'=>'btn btn-warning'], $secure=null)!!}
</div>
</div>
</div>
</div>