<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="myUpdate" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
      <div class="row">
         <div class="col-xs-12 container-fluit">
             <div class="panel panel-warning">
                <div class="panel-heading">
                    <h4>
                    Actualizar Grupo
                    </h4>
                    </div>
                    <div class="panel-body">
                <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                    <input id="id" type="hidden">
                        <div class="form-group">
                            {!!Form::label('nombre', 'Nombre de grupo:')!!}
                  {!! Form::text('grp_grupo', null, ['placeholder' => 'Ingrese el nombre de grupo','class'=>'form-control','id'=>'nombre']) !!}
                        </div>
                        <div class="form-group">
                            {!!Form::label('imagen', 'Ruta Imagen:')!!}
                   {!! Form::text('grp_imagen', null, ['placeholder' => 'Ruta del icono de imagen','class'=>'form-control','id'=>'imagen']) !!}
                        </div>
                        <div class="form-group">
                            {!!Form::label('fecha1', 'fecha registro:')!!}
                  {!! Form::text('grp_registrado', null, ['placeholder' => 'Ingrese el nombre de Opcion','class'=>'form-control','id'=>'fecha1']) !!}
                        </div>
                        <div class="form-group">
                            {!!Form::label('fecha2', 'Fecha edicion:')!!}
                  {!! Form::text('grp_modificado', null, ['placeholder' => 'Ingrese el nombre de Opcion','class'=>'form-control','id'=>'fecha2']) !!}
                        </div>
                        <div class="form-group">
                            {!!Form::label('usuarioId', 'Codigo de usuario:')!!}
                   {!! Form::text('grp_usr_id', null, ['placeholder' => 'Ingrese el nombre de Opcion','class'=>'form-control','id'=>'usuarioId']) !!}
                        </div>
                        <div class="form-group">
                            {!!Form::label('estado', 'Estado:')!!}
                  {!! Form::text('grp_estado', null, ['placeholder' => 'Ingrese el nombre de Opcion','class'=>'form-control','id'=>'estado']) !!}
                        </div>
                    </input>
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
                {!!link_to('#',$title='Actualizar', $attributes=['id'=>'actualizar','class'=>'btn btn-warning'], $secure=null)!!}
            </div>
        </div>
    </div>
</div>