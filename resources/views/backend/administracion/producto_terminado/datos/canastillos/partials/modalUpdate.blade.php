<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="myUpdateCanastillo" tabindex="-1">
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
                                    <form class="form-horizontal" id="canastillosUpdate">
                                        <input type="hidden" name="csrf-token" value="{{ csrf_token() }}" id="token">
                                        <input type="hidden" name="ctl_id" id="ctl_id">
                                        <input type="hidden" name="imgCapture" id="imgCapture">
                                        <div class="form-group">
                                            <label class="col-md-2" for="">
                                                Descripción:
                                            </label>
                                            <div class="col-md-10">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                     <input type="text" class="form-control" name="ctl_descripcion1" id="ctl_descripcion1">
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
                                                    <input type="text" class="form-control" name="ctl_codigo1" id="ctl_codigo1">
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
                                                    {!! Form::select('ctl_rece_id1', $receta, null,['class'=>'form-control','name'=>'ctl_rece_id1', 'id'=>'ctl_rece_id1']) !!}
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
                                                            <input type="text" class="form-control" name="ctl_altura1" id="ctl_altura1">
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
                                                            <input type="text" class="form-control" name="ctl_ancho1" id="ctl_ancho1">
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
                                                            <input type="text" class="form-control" name="ctl_largo1" id="ctl_largo1">
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
                                                            <input type="text" class="form-control" name="ctl_peso1" id="ctl_peso1">
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
                                                            <input type="text" class="form-control" name="ctl_material1" id="ctl_material1">
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
                                                            <textarea name="ctl_observacion1" id="ctl_observacion1" id="textarea" class="form-control" rows="3" required="required"></textarea>
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
                                                            <select name="ctl_logo1" id="ctl_logo1" class="form-control" required="required">
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
                                                       <div class="fileinput fileinput-new" id="img-prov" data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail" style="width: 170px; height: 120px;"><img id="imagenUpdate" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" /></div>
                                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 120px; max-height: 120px;"></div>
                                                            <div>
                                                                <span class="btn btn-theme03 btn-block btn-file">
                                                                    <span class="fa fa-file-image-o">Seleccione Imagen</span>
                                                                    <!--span class="fileinput-exists">Cambiar</span-->
                                                                    <input type="file" id="uimgCanastillo" name="uimgCanastillo"/></span>
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
                                                    <input class="form-control" id="ctl_almacenamiento1" name="ctl_almacenamiento1"  type="text"/>
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
                                                    <input class="form-control datepicker" id="ctl_transporte1" name="ctl_transporte1"  type="text"/>
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
                                                    <input class="form-control" id="ctl_aplicacion1" name="ctl_aplicacion1"  type="text"/>
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
                <button class="btn btn-danger" data-dismiss="modal" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Modificar', $attributes=['id'=>'actualizar','class'=>'btn btn-success'], $secure=null)!!}
            </div>
        </div>
    </div>
</div>
@push('scripts')

@endpush
