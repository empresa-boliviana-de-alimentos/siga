<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="modalPTDespacho" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4>
                                    Formulario de envio despacho producto terminado :
                                </h4>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12 container-fluit">
                                    <form class="form-horizontal" id="canastillos">
                                        <input type="hidden" name="csrf-token" value="{{ csrf_token() }}" id="token">
                                        <input type="hidden" name="ipt_id_pt" id="ipt_id_pt">
                                        <input type="hidden" name="ipt_planta_pt" id="ipt_planta_pt">
                                        <input type="hidden" name="idreceta_pt" id="idreceta_pt">
                                        <input type="hidden" name="ipt_orprod_id" id="ipt_orprod_id">
                                        <input type="hidden" name="ipt_costo_unitario" id="ipt_costo_unitario">
                                        <input type="hidden" name="ipt_fecha_vencimiento" id="ipt_fecha_vencimiento">
                                        <input type="hidden" name="ipt_hora_falta" id="ipt_hora_falta">
                                        <input type="hidden" name="ipt_lote" id="ipt_lote">
                                        <div class="col-md-12 text-center">
                                            <label><b>DESPACHO PRODUCTO TERMINADO</b></label><br><br>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3" for="">
                                                Codigo-ORP:
                                            </label>
                                            <div class="col-md-9">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                     <input type="text" class="form-control" name="ctl_codigo_pt" id="ctl_codigo_pt" readonly>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-search">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-md-3" for="">
                                                Producto:
                                            </label>
                                            <div class="col-md-9">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                     <input type="text" class="form-control" name="ctl_producto_pt" id="ctl_producto_pt" readonly>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-home">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3">
                                                Destino:
                                            </label>
                                            <div class="col-md-9">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    {!! Form::select('ipt_despacho_id_pt', $despacho, null,['class'=>'form-control','name'=>'ipt_despacho_id_pt', 'id'=>'ipt_despacho_id_pt']) !!}
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-play">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-md-3">
                                                Fecha despacho:
                                            </label>
                                           <div class="col-md-9">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    <input class="form-control" id="ipt_fecha_despacho_pt" name="ipt_fecha_despacho_pt"  type="text" readonly/>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-calendar">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3">
                                                <font style="color:green">Cantidad sobrantes:</font>
                                            </label>
                                            <div class="col-md-9">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    <input class="form-control" id="ipt_sobrante_pt" name="ipt_sobrante_pt"  type="text" readonly/>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-hourglass-end">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3">
                                                Cantidad a despachar:
                                            </label>
                                            <div class="col-md-9">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    <input class="form-control" type="text" name="" id="ipt_despacho" name="ipt_despacho">
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
                <button class="btn btn-success" onclick="registrarProductoTerminado();" type="button">
                    Guardar
                </button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript">
</script>
@endpush
