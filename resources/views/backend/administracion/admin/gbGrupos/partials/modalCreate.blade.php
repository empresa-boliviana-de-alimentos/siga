<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="myCreate" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                <div class="col-xs-12 container-fluit">
                <div class="panel panel-warning">
                <div class="panel-heading">
                    <h4>
                    Registrar Grupo
                    </h4>
                    </div>
                    <div class="panel-body">
                <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                    <div class="form-group">
                        {!!Form::label('Grupo','Nombre: ')!!}
					 {!! Form::text('grp_grupo', null, array('placeholder' => 'Nombre de Grupo','class' => 'form-control','id'=>'nombrereg')) !!}
                    </div>
                    <div class="form-group">
                        {!!Form::label('Grupo','Imagen:')!!}
					{!! Form::text('grp_imagen', null, array('placeholder' => 'Nombre de la ruta','class' => 'form-control','id'=>'imagenreg')) !!}
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
                <button class="btn btn-warning" data-dismiss="modal" type="button" onclick="registrar();">
                    Registrar
                </button>
            </div>
        </div>
    </div>
</div>



