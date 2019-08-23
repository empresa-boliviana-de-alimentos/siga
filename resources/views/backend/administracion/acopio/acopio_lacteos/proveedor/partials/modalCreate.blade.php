<div class="extended_modals">
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
                                                     <option value="0" disabled selected>--Seleccione--</option>
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
                                                <select class="form-control" id="municipio" name="n_mun">
                                                        <option value="0" disabled selected>--Seleccione--</option>
                                                        <option value="20">Achacachi</option>
                                                        <option value="21">Challapata</option> 
                                                        <option value="22">Puerto Villaroel (Ivirgarzama)</option> 
                                                        <option value="23">San Andres</option> 
                                                        <option value="24">San Lorenzo</option>  
                                                </select>
                                            </div>
                                        </div>
                                    </div>    
                                    
                                   <!-- <div class="col-md-4">
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
                                    </div>-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    RAU:
                                                </label>
                                                <select class="form-control" id="rau" name="rau">
                                                     <option value="0" disabled selected>--Seleccione--</option>
                                                    <option value="1">SI</option>
                                                    <option value="2">NO</option>       
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row ocultar" style="display: none;">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nit:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('nronit', null, array('placeholder' => 'Ingrese numero de nit','maxlength'=>'20','class' => 'form-control','id'=>'nronit')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nro Documento:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('nrocuenta', null, array('placeholder' => 'Ingrese Telefono ','maxlength'=>'20','class' => 'form-control','id'=>'nrocuenta')) !!}
                                                </span>
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

@push('scripts')
<script>
    $(function(){
    $('#rau').change(function(){
    if($(this).val()==2){
        $('.ocultar').hide();
    }else{
        $('.ocultar').show();
    }
  
  })

});
</script>
@endpush