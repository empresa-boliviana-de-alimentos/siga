<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myUpdateProdEsp" tabindex="-5">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #202040">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    <span style="color: white">x</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Modificar Registro Producto Especifico
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                        {!! Form::open(['id'=>'proveedor'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="idespe" name="idespe" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nombre Producto Especifico:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('nomprodesp', null, array('placeholder' => 'Nombre Producto','maxlength'=>'250','class' => 'form-control','id'=>'nomprodesp','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
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
                 <button class="btn btn-danger" data-dismiss="modal" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Actualizar', $attributes=['id'=>'modificarProdEsp','class'=>'btn btn-success','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
