

     <div class="modal fade bs-example-modal-md in" id="nuevoDestino" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Nuevo Destino</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['id'=>'destino1'])!!}
                    <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                    <input id="id" name="id_municipio" type="hidden" value="">
                        <fieldset>
                            <div class="row">
                                <div class="form-group">
                                    <label class="col-md-3 control-label text-right" for="name">Nombre del destino:</label>
                                    <div class="col-md-9">
                                        {!! Form::text('destino', null, array('placeholder' => 'Ingrese destino','maxlength'=>'50','class' => 'form-control','id'=>'destino')) !!}
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
                    {!!link_to('#',$title='Registrar', $attributes=['id'=>'registroDestino','class'=>'btn btn-primary','style'=>'background:#57BC90'], $secure=null)!!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>