<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="myUserUpdate" tabindex="-5">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
      <div class="row">
         <div class="col-xs-12 container-fluit">
             <div class="panel panel-warning">
                <div class="panel-heading">
                    <h4>
                    Modificar Usuario
                    </h4>
                    </div>
                    <div class="panel-body">
                <div class="caption">
                    <hr>
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                           {!! Form::text('usr_id', null, array('name'=>'usr_usuario','id'=>'usr_id','class'=>'form-control','disabled'=>'true')) !!}
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Usuario:
                                                </label>
                                                {!! Form::text('usr_usuario', null, array('placeholder' => 'Nombre de Opcion','class' => 'form-control','name'=>'usr_usuario','id'=>'usuario1')) !!}
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Contraseña Actual:
                                                </label>
                                                {!! Form::text('usr_clave1', null, array('placeholder' => 'Ingrese la Contraseña','class' => 'form-control','name'=>'usr_clave1','id'=>'usr_clave1','disabled'=>'true')) !!}
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Contraseña Nueva:
                                                </label>
                                                {!! Form::text('usr_clave', null, array('placeholder' => 'Ingrese la Contraseña','class' => 'form-control','name'=>'usr_clave','id'=>'clave1')) !!}
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    Grupo:
                                                </label>
                                                {!! Form::Label('item','Personas:')!!}
                                         {!! Form::select('prs_id', $persona, null,['class'=>'form-control','name'=>'usr_prs_id', 'id'=>'usr_prs_id1','disabled'=>'true']) !!}
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                    TURNO:
                                                </label>                                    
                                                <select name="usr_id_turno1" id="usr_id_turno1" class="form-control">
                                                    <option value=""></option>
                                                    <option value="1">MAÑANA</option>
                                                    <option value="2">TARDE</option>
                                                </select>
                                           </div>

                                        </input>
                                    </div>
                                </div>
                            </input>
                        </input>
                    </hr>
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
</div>