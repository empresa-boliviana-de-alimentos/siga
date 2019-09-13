<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="modalCanastilloDespacho" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4>
                                    Formulario de envio despacho canastillo :
                                </h4>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12 container-fluit">
                                    <form class="form-horizontal" id="canastillos">
                                        <input type="hidden" name="csrf-token" value="{{ csrf_token() }}" id="token">
                                        <input type="hidden" name="iac_id" id="iac_id">
										<input type="hidden" name="iac_planta_id" id="iac_planta_id">
                                        <div class="col-md-12 text-center">
                                            <label><b>DESPACHO CANASTILLO</b></label><br><br>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3" for="">
                                                Descripcion Canastillo:
                                            </label>
                                            <div class="col-md-9">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                     <input type="text" class="form-control" name="ctl_descripcion" id="ctl_descripcion" readonly>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-search">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3" for="">
                                                Fecha Ingreso:
                                            </label>
                                            <div class="col-md-9">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                     <input type="text" class="form-control" name="iac_fecha_ingreso" id="iac_fecha_ingreso" readonly>
                                                     <div class="input-group-addon">
                                                        <span class="fa fa-calendar">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3">
                                                <font style="color:red">Destino:*</font>
                                            </label>
                                            <div class="col-md-9">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    {!! Form::select('iac_de_id', $despacho, null,['class'=>'form-control','name'=>'iac_de_id', 'id'=>'iac_de_id']) !!}
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-play">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                        	 <label class="col-md-3">
                                                Fecha despacho:
                                            </label>
                                           <div class="col-md-9">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    <input class="form-control" id="iac_fecha_despacho" name="iac_fecha_despacho"  type="text" readonly/>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-calendar">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-5">
                                                <font style="color:green">Cantidad a despachar canastillos:</font>
                                            </label>
                                            <div class="col-md-7">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    <input class="form-control" id="iac_cantidad" name="iac_cantidad"  type="text" readonly/>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-hourglass-end">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" type="button">
                    Cerrar
                </button>
                <button class="btn btn-success" onclick="registrarCanastilla();" type="button">
                    Guardar
                </button>
            </div>
        </div>
    </div>
</div>
@push('scripts')

@endpush
