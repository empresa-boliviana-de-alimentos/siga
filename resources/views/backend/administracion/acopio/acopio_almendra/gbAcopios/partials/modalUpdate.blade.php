<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myUpdate" tabindex="-5">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    ×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Modificar Proveedor
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                    <hr>
                        {!! Form::open(['id'=>'proveedor'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id1" name="provid1" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nombre:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('nombres', null, array('placeholder' => 'ingrese Nombre(s) ','maxlength'=>'20','class' => 'form-control','id'=>'nombres1')) !!}
                                                </span>
                                                <label>
                                                    Apellido Paterno:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('apellido_paterno', null, array('placeholder' => 'Ingrese Apellido Paterno','maxlength'=>'15','class' => 'form-control','id'=>'apellido_paterno1')) !!}
                                                </span>
                                                <label>
                                                   Apellido Materno:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('apellido_materno', null, array('placeholder' => 'Ingrese Apellido Materno','maxlength'=>'15','class' => 'form-control','id'=>'apellido_materno1')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <img src="" class="rounded" alt="Cinque Terre" width="200" height="150">
                                            </div>
                                            <div class="form-group">
                                                <input id="img" type="file" class="file" readonly=true>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    C.I.:
                                                </label>
                                                {!! Form::text('ci', null, array('placeholder' => 'Ingrese C.I.','maxlength'=>'15','class' => 'form-control','id'=>'ci1')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Expedido:
                                                </label> 
                                                <select class="form-control" id="exp1" name="exp" placeholder="Ingrese Expedido" value="">
                                                   <option value="1">CH</option>
                                                   <option value="2">LP</option>
                                                   <option value="3">CB</option>
                                                   <option value="4">OR</option>
                                                   <option value="5">PT</option>
                                                   <option value="5">TJ</option>
                                                   <option value="5">SC</option>
                                                   <option value="5">BN</option>
                                                   <option value="5">PA</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                   Telefono:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('telefono', null, array('placeholder' => 'Ingrese Telefono','maxlength'=>'15','class' => 'form-control','id'=>'telefono1')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Tipo proveedor:
                                                </label> 
                                                <select class="form-control" id="id_tipo_prov1" name="id_tipo_prov" placeholder="Ingrese Expedido" value="">
                                                    <option>Seleccione..</option>
                                                    <option value="1">Comunario</option>
                                                    <option value="2">Rescatista</option>
                                                    <option value="3">Barraquero</option>
                                                    <option value="4">Campesino</option>
                                                    <option value="5">Indigena</option>
                                                    <option value="5">Privado</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Convenio:
                                                </label> 
                                                <select class="form-control" id="id_convenio1" name="id_convenio" placeholder="Ingrese Expedido" value="">
                                                    <option>Seleccione...</option>
                                                    <option value="1">NO</option>
                                                    <option value="2">SI</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Departamento:
                                                </label> 
                                                <select class="form-control" id="id_departamento1" name="id_departamento" placeholder="Ingrese Expedido" value="">
                                                    <option>Seleccione Departamento...</option>
                                                    <option value="1">Beni</option>
                                                    <option value="2">La Paz</option>
                                                    <option value="2">Pando</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Municipio:
                                                </label> 
                                                <select class="form-control" id="id_municipio1" name="id_municipio" placeholder="Ingrese Expedido" value="">
                                                    <option>Seleccione Municipio...</option>
                                                    <option value="1">aaaaa</option>
                                                    <option value="2">bbbb</option>
                                                    <option value="2">cccc</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Comunidad:
                                                </label> 
                                                <select class="form-control" id="id_comunidad1" name="id_comunidad" placeholder="Ingrese Expedido" value="">
                                                    <option>Seleccione Comunidad...</option>
                                                    <option value="1">aaaaa</option>
                                                    <option value="2">bbbb</option>
                                                    <option value="2">cccc</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Asociacion:
                                                </label> 
                                                <select class="form-control" id="id_asociacion1" name="id_asociacion" placeholder="Ingrese Expedido" value="">
                                                    <option>Seleccione Asociacion...</option>
                                                    <option value="1">aaaaa</option>
                                                    <option value="2">bbbb</option>
                                                    <option value="2">cccc</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                            </input>
                        </input>
                    </hr>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" style="background:#A5A5B2" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Actualizar', $attributes=['id'=>'actualizar','class'=>'btn btn-primary','style'=>'background:#57BC90'], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
