
<div class="modal fade bs-example-modal-sm in" data-backdrop="static" data-keyboard="false" id="myCreateEnvioAlm" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    ×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    ENVIO DE MATERIA PRIMA - ALMACEN
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                    <?php $now = new \DateTime('America/La_Paz'); ?>
                        {!! Form::open(['id'=>'envioalm'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id" name="id_proveedor" type="hidden" value="">
                                <div class="row">
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Cantidad total de Envio:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('enval_cant_total', $cantidad, array('placeholder' => '0','maxlength'=>'40','class' => 'form-control','id'=>'enval_cant_total','onkeyup'=>'javascript:this.value=this.value.toUpperCase();','readonly')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                     Costo Unitario:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('enval_cost_uni', $cantuni,array('placeholder' => '','maxlength'=>'15','class' => 'form-control','id'=>'enval_cost_uni','onkeyup'=>'javascript:this.value=this.value.toUpperCase();','readonly')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                     Costo total de Envio:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('enval_cost_total', $tot,array('placeholder' => '','maxlength'=>'15','class' => 'form-control','id'=>'enval_cost_total','onkeyup'=>'javascript:this.value=this.value.toUpperCase();','readonly')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Fecha de Envio:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('enval_registro', $now->format('d-m-Y'), array('placeholder' => 'Fecha y Hora ', 'class'=>'form-control','maxlength'=>'40','id'=>'enval_registro', 'readonly' => 'readonly')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Planta Destino:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('enval_cost_total', $nomplant,array('placeholder' => 'Ingrese Apellido Paterno','maxlength'=>'15','class' => 'form-control','id'=>'enval_cost_total','onkeyup'=>'javascript:this.value=this.value.toUpperCase();','readonly')) !!}
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
                    Cerrar
                </button>
                {!!link_to('#',$title='ENVIAR', $attributes=['id'=>'envioAlm','class'=>'btn btn-primary','style'=>'background:#57BC90'], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
