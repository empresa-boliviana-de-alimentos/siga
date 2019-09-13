<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="myCreateDestino" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4>
                                    Formulario de Registro (Destino):
                                </h4>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12 container-fluit">
                                    <form class="form-horizontal" id="formid">
                                       <input type="hidden" name="csrf-token" value="{{ csrf_token() }}" id="token">
                                        <div class="form-group">
                                            <label class="col-md-3" for="">
                                                Linea de Trabajo:
                                            </label>
                                            <div class="col-md-9">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    {!! Form::select('de_linea_trabajo', $lineaTrabajo, null,['class'=>'form-control','name'=>'de_linea_trabajo', 'id'=>'de_linea_trabajo']) !!}
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-home">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3" for="">
                                                Planta:
                                            </label>
                                            <div class="col-md-9">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    {!! Form::select('de_planta_id', $planta, null,['class'=>'form-control','name'=>'de_planta_id', 'id'=>'de_planta_id']) !!}
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-home">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3" for="">
                                                Departamento:
                                            </label>
                                            <div class="col-md-9">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    {!! Form::select('de_departamento', $departamento, null,['class'=>'form-control','name'=>'de_departamento', 'id'=>'de_departamento']) !!}
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-globe">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3" for="">
                                                Nombre:
                                            </label>
                                            <div class="col-md-9">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    <input class="form-control datepicker" id="de_nombre" name="de_nombre"  type="text"/>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-file-text-o">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3" for="">
                                                Mercado:
                                            </label>
                                            <div class="col-md-9">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    <input class="form-control" id="de_mercado" name="de_mercado"  type="text"/>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-shopping-cart">
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
                <button class="btn btn-danger" data-dismiss="modal" onclick="limpiarform();" type="button">
                    Cerrar
                </button>
                <button class="btn btn-success" onclick="registrar();" type="button">
                    Guardar
                </button>
            </div>
        </div>
    </div>
</div>
@push('scripts')

@endpush
