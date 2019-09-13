<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="myCreateAlmacen" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4>
                                    Formulario de Registro (Producto terminado almacen):
                                </h4>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12 container-fluit">
                                    <form class="form-horizontal" id="canastillos">
                                        <input type="hidden" name="csrf-token" value="{{ csrf_token() }}" id="token">
                                        <input type="hidden" name="orprod_id" id="orprod_id">
                                        <input type="hidden" name="planta_id" id="planta_id">
                                        <input type="hidden" name="rece_id" id="rece_id">
                                        <div class="form-group">
                                            <label class="col-md-1" for="">
                                                Codigo-ORP:
                                            </label>
                                            <div class="col-md-5">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                     <input type="text" class="form-control" name="ctl_codigo" id="ctl_codigo" readonly>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-search">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-md-1" for="">
                                                Producto:
                                            </label>
                                            <div class="col-md-5">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                     <input type="text" class="form-control" name="ctl_producto" id="ctl_producto" readonly>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-home">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-6 text-center" for="">
                                                <b>CANTIDAD A PRODUCTIR:</b><br><br>
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <span class="block input-icon input-icon-right">
                                                        </span>
                                                        <div class="input-group">
                                                             <input type="text" class="form-control" name="ctl_cantidad_min" id="ctl_cantidad_min" readonly>
                                                            <div class="input-group-addon">
                                                                <span class="fa fa-balance-scale">
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        A:
                                                    </div>
                                                    <div class="col-md-5">
                                                        <span class="block input-icon input-icon-right">
                                                        </span>
                                                        <div class="input-group">
                                                             <input type="text" class="form-control" name="ctl_cantindad_max" id="ctl_cantindad_max" readonly>
                                                            <div class="input-group-addon">
                                                                <span class="fa fa-balance-scale">
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>

                                            <label class="col-md-6 text-center" for="">
                                                <b>TIEMPO DE PRODUCCIÓN:</b><br><br>
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <label>Tiempo</label>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <span class="block input-icon input-icon-right">
                                                        </span>
                                                        <input type="text" class="form-control" name="ctl_tiempo_literal" id="ctl_tiempo_literal" readonly>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <label style="color:green">Tiempo maximo a producir Horas:</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <span class="block input-icon input-icon-right">
                                                        </span>
                                                        <div class="input-group">
                                                             <input type="text" class="form-control" name="ctl_tiempo_hora" id="ctl_tiempo_hora" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-8">
                                                        <label id="tiempo_hora" style="color:red">Total horas transcurridas: </label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <span class="block input-icon input-icon-right">
                                                        </span>
                                                        <div class="input-group">
                                                             <input type="text" class="form-control" name="ctl_tiempo_falta" id="ctl_tiempo_falta" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-md-12 text-center">
                                            <label><b>DESCRIPCIÓN DEL INGRESO</b></label><br><br>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                Cantidad Producida:
                                            </label>
                                            <div class="col-md-4">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    <input class="form-control" id="ctl_cantidad_producida" name="ctl_cantidad_producida"  type="text"/>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-plus">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-md-2">
                                                Lote:
                                            </label>
                                            <div class="col-md-4">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    <input class="form-control" id="ctl_lote" name="ctl_lote"  type="text"/>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-plus">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                Fecha de vencimiento:
                                            </label>
                                            <div class="col-md-4">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    <input class="form-control datepicker" id="ctl_fecha_vencimiento" name="ctl_fecha_vencimiento"  type="text"/>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-calendar">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-md-2">
                                                Costo unitario:
                                            </label>
                                            <div class="col-md-4">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    <input class="form-control" id="ctl_costo_unitario" name="ctl_costo_unitario"  type="text"/>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-cube">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2">
                                                Observaciones:
                                            </label>
                                            <div class="col-md-10">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    <textarea name="ctl_observaciones" id="ctl_observaciones" class="form-control" rows="3" required="required"></textarea>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-file">
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
                <button class="btn btn-danger" data-dismiss="modal" type="button" onclick="limpiarDatos();">
                    Cerrar
                </button>
                <button class="btn btn-success" onclick="registrarIngreso();" type="button">
                    Guardar
                </button>
            </div>
        </div>
    </div>
</div>
@push('scripts')

@endpush
