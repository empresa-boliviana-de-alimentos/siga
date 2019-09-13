<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="myCreateCanastillo" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4>
                                    Formulario de Registro (Canastillo):
                                </h4>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12 container-fluit">
                                    <form class="form-horizontal" id="canastillos">
                                        <input type="hidden" name="csrf-token" value="{{ csrf_token() }}" id="token">
                                        <div class="form-group">
                                            <label class="col-md-2" for="">
                                                Descripción:
                                            </label>
                                            <div class="col-md-10">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                     <input type="text" class="form-control" name="ctl_descripcion" id="ctl_descripcion">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-home">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2" for="">
                                                Codigo:
                                            </label>
                                            <div class="col-md-4">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="ctl_codigo" id="ctl_codigo">
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-home">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-md-2" for="">
                                                Productos a transportar:
                                            </label>
                                            <div class="col-md-4">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    {!! Form::select('ctl_rece_id', $receta, null,['class'=>'form-control','name'=>'ctl_rece_id', 'id'=>'ctl_rece_id']) !!}
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-home">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-4 text-center">
                                                <label><b>Especificaciones</b></label>
                                                <div class="form-group">
                                                    <label class="col-md-3" for="">
                                                        Altura:
                                                    </label>
                                                    <div class="col-md-9">
                                                        <span class="block input-icon input-icon-right">
                                                        </span>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="ctl_altura" id="ctl_altura">
                                                            <div class="input-group-addon">
                                                                <span class="fa fa-balance-scale">
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3" for="">
                                                        Ancho:
                                                    </label>
                                                    <div class="col-md-9">
                                                        <span class="block input-icon input-icon-right">
                                                        </span>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="ctl_ancho" id="ctl_ancho">
                                                            <div class="input-group-addon">
                                                                <span class="fa fa-balance-scale">
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3" for="">
                                                        Largo:
                                                    </label>
                                                    <div class="col-md-9">
                                                        <span class="block input-icon input-icon-right">
                                                        </span>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="ctl_largo" id="ctl_largo">
                                                            <div class="input-group-addon">
                                                                <span class="fa fa-balance-scale">
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3" for="">
                                                        Peso:
                                                    </label>
                                                    <div class="col-md-9">
                                                        <span class="block input-icon input-icon-right">
                                                        </span>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="ctl_peso" id="ctl_peso">
                                                            <div class="input-group-addon">
                                                                <span class="fa fa-balance-scale">
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <label><b>Formulación</b></label>
                                                <div class="form-group">
                                                    <label class="col-md-3" for="">
                                                        Material:
                                                    </label>
                                                    <div class="col-md-9">
                                                        <span class="block input-icon input-icon-right">
                                                        </span>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="ctl_material" id="ctl_material">
                                                            <div class="input-group-addon">
                                                                <span class="fa fa-balance-scale">
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3" for="">
                                                        Observacion:
                                                    </label>
                                                    <div class="col-md-9">
                                                        <span class="block input-icon input-icon-right">
                                                        </span>
                                                        <div class="input-group">
                                                            <textarea name="ctl_observacion" id="ctl_observacion" id="textarea" class="form-control" rows="3" required="required"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3" for="">
                                                        C/Logo:
                                                    </label>
                                                    <div class="col-md-9">
                                                        <span class="block input-icon input-icon-right">
                                                        </span>
                                                        <div class="input-group">
                                                            <select name="ctl_logo" id="ctl_logo" class="form-control" required="required">
                                                                <option value="SI">SI</option>
                                                                <option value="NO">NO</option>
                                                            </select>
                                                            <div class="input-group-addon">
                                                                <span class="fa fa-balance-scale">
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <label><b>Presentación</b></label>
                                                <div class="form-group">
                                                    <label class="col-md-2" for="">
                                                        Foto/Adjunto:
                                                    </label><br>
                                                    <div class="col-md-12">
                                                        <div class="fileinput fileinput-new" id="img-canastillo" data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail" style="width: 170px; height: 120px;">
                                                                </div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 120px; max-height: 120px;"></div>
                                                            <div>
                                                                <span class="btn btn-theme03 btn-block btn-file">
                                                                    <span class="fileinput-new">Seleccione Fotografía</span>
                                                                    <span class="fileinput-exists">Cambiar</span>
                                                                    <input type="file" name="ctl_foto_canastillo"></span>
                                                                <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2" for="">
                                                Almacenamiento:
                                            </label>
                                            <div class="col-md-10">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    <input class="form-control" id="ctl_almacenamiento" name="ctl_almacenamiento"  type="text"/>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-globe">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2" for="">
                                                Transporte:
                                            </label>
                                            <div class="col-md-10">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    <input class="form-control datepicker" id="ctl_transporte" name="ctl_transporte"  type="text"/>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-file-text-o">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2" for="">
                                                Aplicacion:
                                            </label>
                                            <div class="col-md-10">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    <input class="form-control" id="ctl_aplicacion" name="ctl_aplicacion"  type="text"/>
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
