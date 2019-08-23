<div class="modal fade modal-fade-in-scale-up" data-backdrop="static" data-keyboard="false" id="myCreateFru" tabindex="-5">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    X
                </button>
                <h4 class="modal-title" id="modalLabelfade">
                    <center>REGISTRO DE NUEVA FRUTA</center>
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                       {!! Form::open(['id'=>'acopio'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id" name="prsid" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nombre Fruta.:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                {!! Form::text('nombre_fru', null, array('placeholder' => 'Nombre fruta','maxlength'=>'50','class' => 'form-control','id'=>'nombre_fru','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </input>
                        </input>
                    </hr>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" type="button">
                    Cancelar
                </button>
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registrofru','class'=>'btn btn-success'], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>



