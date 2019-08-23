

     <div class="modal fade bs-example-modal-md in" id="nuevoRespRecep" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Nuevo Responsable de Recepción</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['id'=>'resprecep1'])!!}
                    <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                    <input id="id" name="id_resp_recep" type="hidden" value="">
                        <fieldset>
                            <div class="row">
                                <div class="form-group">
                                    <label class="col-md-3 control-label text-right" for="name">Nombres:</label>
                                    <div class="col-md-9">
                                        {!! Form::text('rec_nombre', null, array('placeholder' => 'Ingrese Nombre del Recepcionista','maxlength'=>'50','class' => 'form-control','id'=>'rec_nombre')) !!}
                                    </div>
                                </div>                                
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <label class="col-md-3 control-label text-right" for="name">Apellido Paterno:</label>
                                    <div class="col-md-9">
                                        {!! Form::text('rec_ap', null, array('placeholder' => 'Ingrese Apellido Paterno del Recepcionista','maxlength'=>'50','class' => 'form-control','id'=>'rec_ap')) !!}
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <label class="col-md-3 control-label text-right" for="name">Apellido Materno:</label>
                                    <div class="col-md-9">
                                        {!! Form::text('rec_am', null, array('placeholder' => 'Ingrese Apellido Materno del Recepcionista','maxlength'=>'50','class' => 'form-control','id'=>'rec_am')) !!}
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <label class="col-md-3 control-label text-right" for="name">CI:</label>
                                    <div class="col-md-9">
                                        {!! Form::text('rec_ci', null, array('placeholder' => 'Ingrese Cédula de Identidad del Recepcionista','maxlength'=>'50','class' => 'form-control','id'=>'rec_ci')) !!}
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
                    {!!link_to('#',$title='Registrar', $attributes=['id'=>'registroRespRecep','class'=>'btn btn-primary','style'=>'background:#57BC90'], $secure=null)!!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>