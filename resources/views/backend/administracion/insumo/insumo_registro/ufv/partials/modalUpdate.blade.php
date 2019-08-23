<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myUpdateUfv" tabindex="-5">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel">
                    Modificar UFV Insumo
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                        {!! Form::open(['id'=>'proveedor'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="ufv_id1" name="ufv_id1" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Fecha:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                {!! Form::text('ufv_registrado1', null, array('placeholder' => 'Ingrese UFV','class' => 'form-control','id'=>'ufv_registrado1','disabled'=>'true')) !!}
                                                </span>   
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    UFV:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('ufv_cant1', null, array('placeholder' => 'Ingrese UFV','class' => 'form-control','id'=>'ufv_cant1')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </input>
                        </input>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" style="background:#A5A5B2" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Actualizar', $attributes=['id'=>'actualizarUfv','class'=>'btn btn-primary','style'=>'background:#57BC90'], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
