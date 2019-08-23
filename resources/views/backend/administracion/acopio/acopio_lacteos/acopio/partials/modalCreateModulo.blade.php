<div class="extended_modals">
<div class="modal" data-backdrop="static" data-keyboard="false" id="myCreateModulo" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    X
                </button>
                <h4 class="modal-titlepanel-title" id="myModalLabel">
                    <center>REGISTRO DE MODULO/CENTRO DE ACOPIO LACTEOS</center>
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                        {!! Form::open(['id'=>'proveedor'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id" name="prsid" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <div class="col-sm-12">
                                                    <label>  Nombre:    </label>
                                                    <span class="block input-icon input-icon-right">
                                                        {!! Form::text('nombres', null, array('placeholder' => 'Ingrese Nombre(s) ','maxlength'=>'20','class' => 'form-control','id'=>'n_nombres','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                    </span>
                                                </div>
                                            </div>
                                          
                                            <div class="col-md-6">
                                                <div class="col-sm-12">
                                                <label>  Apellido Paterno:    </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('paterno', null, array('placeholder' => 'Ingrese Apellido Paterno','maxlength'=>'20','class' => 'form-control','id'=>'n_ap','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>
                                            </div>
                                            </div>
                                        
                                            <div class="col-md-6">
                                                <div class="col-sm-12">
                                                    <label>  Apellido Materno:    </label>
                                                    <span class="block input-icon input-icon-right">
                                                        {!! Form::text('materno', null, array('placeholder' => 'Ingrese Apellido Materno ','maxlength'=>'20','class' => 'form-control','id'=>'n_am','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                    </span>
                                                 </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-sm-12">
                                                    <label>
                                                        CI:
                                                    </label>
                                                    <span class="block input-icon input-icon-right">
                                                        {!! Form::text('ci', null, array('placeholder' => 'Ingrese CI ','maxlength'=>'20','class' => 'form-control','id'=>'n_ci')) !!}
                                                    </span>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 120px; height: 120px;">
                                                        </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 120px; max-height: 120px;"></div>
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
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Lugar Proveedor:
                                                </label>
                                                <select class="form-control" id="lugar_proveedor" name="n_lugpro">
                                                     <option disabled selected>--Seleccione--</option>
                                                    <option value="1">Planta</option>
                                                    <option value="2">Centro Acopio</option>       
                                                </select>
                                            </div>
                                        </div>
                                    </div>                               
                                    <div class="col-md-5">
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
                                                    Municipio:
                                                </label>
                                                <select class="form-control" id="municipio" name="n_mun">
                                                        <option disabled selected>--Seleccione--</option>
                                                        <option value="20">Achacachi</option>
                                                        <option value="21">Challapata</option> 
                                                        <option value="22">Puerto Villaroel (Ivirgarzama)</option> 
                                                        <option value="23">San Andres</option> 
                                                        <option value="24">San Lorenzo</option>  
                                                </select>
                                            </div>
                                        </div>
                                    </div>    
                                    
                                   
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Tipo Proveedor:
                                                </label>
                                                <select class="form-control" id="tipo_proveedor" name="n_tipo">
                                                     <option disabled selected>--Seleccione--</option>
                                                    <option value="7">Proveedor</option>
                                                    <option value="8">Subproveedor</option>       
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    
                                </div>     
                            </input>
                        </input>
                    </hr>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registro','class'=>'btn btn-success','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>


</div>

