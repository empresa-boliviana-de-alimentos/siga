<div class="modal" data-backdrop="static" data-keyboard="false" id="myCreate" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    X
                </button>
                <h4 class="modal-titlepanel-title" id="myModalLabel">
                    <center>REGISTRO PROVEEDORES LACTEOS</center>
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                    <hr>
                        {!! Form::open(['id'=>'proveedor'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id" name="prsid" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-sm-12">
                                            <label>  Nombre:    </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('pro_nombres', null, array('placeholder' => 'Ingrese Nombre(s) ','maxlength'=>'20','class' => 'form-control','id'=>'n_nombres')) !!}
                                            </span>
                                        </div>
                                    </div>
                                   <div class="col-md-6">
                                        <div class="col-sm-12">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                                                        </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                                <div>
                                                    <span class="btn btn-default btn-file">
                                                    <span class="fileinput-new">Seleccione Fotografía</span>
                                                    <span class="fileinput-exists">Cambiar</span>
                                                    <input type="file" name="imgProveedorL" id="imgProveedorL"></span>
                                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                                </div>
                                            </div>
                                        </div>
                                   </div>


                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-sm-12">
                                            <label>  Apellido Paterno:    </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('pro_ap', null, array('placeholder' => 'Ingrese Apellido Paterno','maxlength'=>'20','class' => 'form-control','id'=>'n_ap')) !!}
                                            </span>
                                        </div>
                                    </div>                               
                                    <div class="col-md-6">
                                        <div class="col-sm-12">
                                            <label>  Apellido Materno:    </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('pro_am', null, array('placeholder' => 'Ingrese Apellido Materno ','maxlength'=>'20','class' => 'form-control','id'=>'n_am')) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    CI:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('pro_ci', null, array('placeholder' => 'Ingrese CI ','maxlength'=>'20','class' => 'form-control','id'=>'n_ci')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    EXP:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    <select class="form-control" id="n_exp" name="n_exp">
                                                        <option value="1">LP</option>
                                                        <option value="2">OR</option> 
                                                        <option value="3">PT</option> 
                                                        <option value="4">TJ</option> 
                                                        <option value="5">SC</option> 
                                                        <option value="6">CB</option>      
                                                        <option value="7">BN</option>  
                                                        <option value="8">PA</option>  
                                                        <option value="9">CH</option>   
                                                   </select>

                                                </span>
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
                                                    {!! Form::text('pro_tel', null, array('placeholder' => 'Ingrese Telefono ','maxlength'=>'10','class' => 'form-control','id'=>'n_tel')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Departamento:
                                                </label>
                                                <div class="controls">
                                                    <select class="form-control" id="n_dep" name="n_dep">
                                                        <option value="1">La Paz</option>
                                                        <option value="2">Oruro</option> 
                                                        <option value="3">Potosi</option> 
                                                        <option value="4">Tarija</option> 
                                                        <option value="5">Santa Cruz</option> 
                                                        <option value="6">Cochabamba</option>      
                                                        <option value="7">Beni</option>  
                                                        <option value="8">Pando</option>  
                                                        <option value="9">Chuquisaca</option>   
                                                    </select>
                                                    <!--{!! Form::radio('prs_sexo','M', ['class'=>'form-control','id'=>'sexo']) !!} Masculino 
                                                        {!! Form::radio('prs_sexo','F',['class'=>'form-control','id'=>'sexo']) !!} Femenino-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Municipio:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('pro_mun', null, array('placeholder' => 'Ingrese Municipio','maxlength'=>'50','class' => 'form-control','id'=>'n_mun')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Comunidad:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('pro_com', null, array('placeholder' => 'Ingrese Comunidad','class' => 'form-control','id'=>'n_com')) !!}
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
                                                    Lugar Proveedor:
                                                </label>
                                                <select class="form-control" id="n_lugpro" name="n_lugpro">
                                                    <option value="1">Planta</option>
                                                    <option value="2">Centro Acopio</option>       
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Tipo Proveedor:
                                                </label>
                                                <select class="form-control" id="n_tipo" name="n_tipo">
                                                    <option value="1">Proveedor</option>
                                                    <option value="2">Subproveedor</option>       
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
                <button class="btn btn-danger" data-dismiss="modal" style="background:#8A0829" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registro','class'=>'btn btn-primary','style'=>'background:#243B0B'], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
