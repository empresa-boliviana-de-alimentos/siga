<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myUpdateSol" tabindex="-5">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    ×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    EDITAR SOLICITUD
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                    <hr>
                        {!! Form::open(['id'=>'proveedor'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="sol_id2" name="sol_id2" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    MONTO:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('sol_monto2', null, array('placeholder' => 'ingrese Monto ','maxlength'=>'150','class' => 'form-control','id'=>'sol_monto2')) !!}
                                                </span>
                                                <label>
                                                    DETALLE:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('sol_detalle2', null, array('placeholder' => 'Ingrese detalle','maxlength'=>'150','class' => 'form-control','id'=>'sol_detalle2','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>
                                                <label>
                                                   OBSERVACION:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('apellido_materno', null, array('placeholder' => 'Obs...','maxlength'=>'150','class' => 'form-control','id'=>'apellido_materno1','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
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
                <button class="btn btn-default" data-dismiss="modal" style="background:#A5A5B2" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Actualizar', $attributes=['id'=>'actualizarSol','class'=>'btn btn-primary','style'=>'background:#57BC90'], $secure=null)!!}
                {!! Form::close() !!}
           </div>
        </div>
    </div>
</div>
