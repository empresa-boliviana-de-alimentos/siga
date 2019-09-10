<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myUpdateProducto" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    ×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    PRODUCTO
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                        {!! Form::open(['id'=>'productos'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="prod_id" name="prod_id" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nombre Producto:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('nombre_producto', null, array('maxlength'=>'200','class' => 'form-control','id'=>'nombre_producto','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();','readonly'=>'true')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Código Producto:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('codigo_producto', null, array('maxlength'=>'200','class' => 'form-control','id'=>'codigo_producto','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Linea:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('linea_produccion', null, array('placeholder' => 'DESCRIPCION TIPO PUNTO DE VENTA','class' => 'form-control','id'=>'linea_produccion','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();', 'readonly'=>'true')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Codigo Produccion:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('codigo_produccion', null, array('placeholder' => 'DESCRIPCION TIPO PUNTO DE VENTA','class' => 'form-control','id'=>'codigo_produccion','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();','readonly'=>'true')) !!}
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
                {!!link_to('#',$title='Modificar', $attributes=['id'=>'actualizarProducto','class'=>'btn btn-success','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
