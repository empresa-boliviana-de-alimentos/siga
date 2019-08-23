<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myUpdateServ" tabindex="-5">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    ×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Modificar Registro Servicio
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                        {!! Form::open(['id'=>'proveedor'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="serv_id1" name="serv_id1" type="hidden" value="">
                               <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nombre Servicio:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('serv_nom1', null, array('placeholder' => 'Nombre Servicio','maxlength'=>'20','class' => 'form-control','id'=>'serv_nom1')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Empresa del Servicio:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('serv_emp1', null, array('placeholder' => 'Empresa Servicio','maxlength'=>'15','class' => 'form-control','id'=>'serv_emp1')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    NIT:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('serv_nit1', null, array('placeholder' => 'Ingrese Nit','maxlength'=>'15','class' => 'form-control','id'=>'serv_nit1')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    N° Factura:
                                                </label>
                                                {!! Form::text('serv_nfact1', null, array('placeholder' => 'Ingrese N° Factura','maxlength'=>'15','class' => 'form-control','id'=>'serv_nfact1')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Costo:
                                                </label> 
                                                {!! Form::text('serv_costo1', null, array('placeholder' => 'Ingrese Costo','maxlength'=>'15','class' => 'form-control','id'=>'serv_costo1')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                   Mes:
                                                </label>
                                                <select class="form-control" id="serv_id_mes1" name="serv_id_mes1" placeholder="" value="">
                                                    <option>Seleccione...</option>
                                                    <option value="1">Enero</option>
                                                    <option value="2">Febrero</option>
                                                    <option value="3">Marzo</option>
                                                    <option value="4">Abril</option>
                                                    <option value="5">Mayo</option>
                                                    <option value="6">Junio</option>
                                                    <option value="7">Julio</option>
                                                    <option value="8">Agosto</option>
                                                    <option value="9">Septiembre</option>
                                                    <option value="10">Octubre</option>
                                                    <option value="11">Noviembre</option>
                                                    <option value="12">Diciembre</option>
                                                </select> 
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
                {!!link_to('#',$title='Actualizar', $attributes=['id'=>'actualizarServ','class'=>'btn btn-primary','style'=>'background:#57BC90'], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
