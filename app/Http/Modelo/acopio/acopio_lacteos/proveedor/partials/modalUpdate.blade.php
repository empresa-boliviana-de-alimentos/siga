<div class="modal" data-backdrop="static" data-keyboard="false" id="myUpdate" tabindex="-1">
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
                            <input id="id1" name="prsid1" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-sm-12">
                                            <label>  Nombre:    </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('pro_nombres', null, array('placeholder' => 'Ingrese Nombre(s) ','maxlength'=>'20','class' => 'form-control','id'=>'e_nombres')) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-sm-12">
                                            <label>  Apellido Paterno:    </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('pro_ap', null, array('placeholder' => 'Ingrese Apellido Paterno','maxlength'=>'20','class' => 'form-control','id'=>'e_ap')) !!}
                                            </span>
                                        </div>
                                    </div>                               
                                    <div class="col-md-6">
                                        <div class="col-sm-12">
                                            <label>  Apellido Materno:    </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('pro_am', null, array('placeholder' => 'Ingrese Apellido Materno ','maxlength'=>'20','class' => 'form-control','id'=>'e_am')) !!}
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
                                                    {!! Form::text('pro_ci', null, array('placeholder' => 'Ingrese CI ','maxlength'=>'20','class' => 'form-control','id'=>'e_ci')) !!}
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
                                                    <select class="form-control" id="e_exp" name="e_exp">
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
                                                    {!! Form::text('pro_tel', null, array('placeholder' => 'Ingrese Telefono ','maxlength'=>'10','class' => 'form-control','id'=>'e_tel')) !!}
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
                                                    <select class="form-control" id="e_dep" name="e_dep">
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
                                                    {!! Form::text('pro_mun', null, array('placeholder' => 'Ingrese Municipio','maxlength'=>'50','class' => 'form-control','id'=>'e_mun')) !!}
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
                                                    {!! Form::text('pro_com', null, array('placeholder' => 'Ingrese Comunidad','class' => 'form-control','id'=>'e_com')) !!}
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
                                                <select class="form-control" id="n_lugpro" name="e_lugpro">
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
                                                <select class="form-control" id="n_tipo" name="e_tipo">
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
                <button class="btn btn-default" data-dismiss="modal" style="background:#A5A5B2" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Actualizar', $attributes=['id'=>'actualizar','class'=>'btn btn-primary','style'=>'background:#57BC90'], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>