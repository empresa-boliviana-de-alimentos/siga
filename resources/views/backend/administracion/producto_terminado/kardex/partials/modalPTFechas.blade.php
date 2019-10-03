<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="myPTFecha" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4>
                                    Listado de datos por registro de Fechas Vencimiento
                                </h4>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12 container-fluit">
                                    <form class="form-horizontal" id="canastillos">
                                        <input type="hidden" name="csrf-token" value="{{ csrf_token() }}" id="token">
                                        <div class="col-md-12 text-center">
                                            <label><b>DETALLE CANTIDADES POR FECHAS DE VENCIMIENTO</b></label><br><br>
                                        </div>
                                        <div class="box">
                                            <div class="box-body">
                                                <table class="table table-hover table-striped table-condensed" id = "lts-fecha-vencimiento" style="width: 100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Nro</th>
                                                            <!--<th>Producto</th>
                                                            <th>Codigo</th>
                                                            <th>Planta</th>
                                                            <th>Linea</th>-->
                                                            <th>Fecha Vencimiento</th>
                                                            <th>Lote</th>
                                                            <th>Precio Unitario</th>
                                                            <th>Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th colspan="4" style="text-align:right">Total:</th>
                                                            <th></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                            <div class="box-footer clearfix">
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
                <button class="btn btn-danger fa fa-close" data-dismiss="modal" type="button" onclick="limpiarDatos();">
                    Cerrar
                </button>
                <button class="btn btn-success fa fa-file-o" onclick="exportarFechas();" type="button">
                    Exportar
                </button>
            </div>
        </div>
    </div>
</div>
@push('scripts')

@endpush
