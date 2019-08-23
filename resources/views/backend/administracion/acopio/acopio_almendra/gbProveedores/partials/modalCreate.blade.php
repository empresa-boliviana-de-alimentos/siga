<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myCreate" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel">
                    Registrar Proveedor
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                        {!! Form::open(['id'=>'proveedor'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id" name="provid" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nombre:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('nombres', null, array('placeholder' => 'ingrese Nombre(s) ','maxlength'=>'40','class' => 'form-control','id'=>'nombres','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>
                                                <label>
                                                    Apellido Paterno:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('apellido_paterno', null, array('placeholder' => 'Ingrese Apellido Paterno','maxlength'=>'40','class' => 'form-control','id'=>'apellido_paterno','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>
                                                <label>
                                                   Apellido Materno:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('apellido_materno', null, array('placeholder' => 'Ingrese Apellido Materno','maxlength'=>'40','class' => 'form-control','id'=>'apellido_materno','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 150px; height: 150px;">
                                                        </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                                    <div>
                                                        <span class="btn btn-default btn-file">
                                                            <span class="fileinput-new">Seleccione Fotografía</span>
                                                            <span class="fileinput-exists">Cambiar</span>
                                                            <input type="file" name="imgProveedor"></span>
                                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    C.I.:
                                                </label>
                                                {!! Form::text('ci', null, array('placeholder' => 'Ingrese C.I.','maxlength'=>'20','class' => 'form-control','id'=>'ci')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Expedido:
                                                </label> 
                                                <select class="form-control" id="exp" name="exp" placeholder="Ingrese Expedido" value="">
                                                   @foreach($dataExp as $exp)
                                                    <option value="{{$exp->dep_id}}">{{$exp->dep_exp}}</option>
                                                   @endforeach
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
                                                    {!! Form::text('telefono', null, array('placeholder' => 'Ingrese Telefono','maxlength'=>'20','class' => 'form-control','id'=>'telefono')) !!}
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
                                                <select class="form-control" id="id_tipo_prov" name="id_tipo_prov" placeholder="Ingrese Expedido" value="">
                                                    <option>Seleccione..</option>
                                                    @foreach($dataTipoProv as $tipo)
                                                    <option value="{{$tipo->tprov_id}}">{{$tipo->tprov_tipo}}</option>
                                                    @endforeach
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
                                                <select class="form-control" id="id_convenio" name="id_convenio" placeholder="Ingrese Expedido" value="">
                                                    <option>Seleccione...</option>
                                                    <option value="SI">SI</option>
                                                    <option value="NO">NO</option>
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
                                                <select class="form-control" id="id_departamento" name="id_departamento" placeholder="Ingrese Expedido" value="">
                                                    <option>Seleccione Departamento...</option>
                                                    @foreach($dataDep as $dep)
                                                        <option value="{{$dep->dep_id}}">{{$dep->dep_nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Municipio:
                                                </label> 
                                                <select class="form-control" id="id_municipio" name="id_municipio" placeholder="Ingrese Expedido" value="">
                                                    <!-- <option>Seleccione Municipio...</option>
                                                    @foreach($dataMuni as $muni)
                                                    <option value="{{$muni->mun_id}}">{{$muni->mun_nombre}}</option>
                                                    @endforeach -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <br>
                                                <label class="col-sm-6 col-form-label">
                                                    Nuevo Municipio...
                                                </label>
                                                <i href="#" class="btn btn-success" role="button" data-toggle="modal" data-target="#myCreateMunicipio"><span class="glyphicon glyphicon-plus-sign"></span></i> 
                                            </br>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Comunidad:
                                                </label> 
                                                <select class="form-control" id="id_comunidad" name="id_comunidad" placeholder="Ingrese Expedido" value="">
                                                    <!-- <option>Seleccione Comunidad...</option>
                                                    @foreach($dataComu as $comu)
                                                    <option value="{{$comu->com_id}}">{{$comu->com_nombre}}</option>
                                                    @endforeach -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <br>
                                                <label class="col-sm-6 col-form-label">
                                                    Nuevo Comunidad...
                                                </label>
                                                <i href="#" class="btn btn-success" role="button" data-toggle="modal" data-target="#myCreateComunidad"><span class="glyphicon glyphicon-plus-sign"></span></i> 
                                            </br>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Asociacion:
                                                </label> 
                                                <select class="form-control" id="id_asociacion" name="id_asociacion" placeholder="Ingrese Expedido" value="">
                                                    <!-- <option>Seleccione Asociacion...</option>
                                                    @foreach($dataSoc as $asoc)
                                                    <option value="{{$asoc->aso_id}}">{{$asoc->aso_nombre}}</option>
                                                    @endforeach -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <br>
                                                <label class="col-sm-6 col-form-label">
                                                    Nuevo Asociacion...
                                                </label>
                                                <i href="#" class="btn btn-success" role="button" data-toggle="modal" data-target="#myCreateAsociacion"><span class="glyphicon glyphicon-plus-sign"></span></i> 
                                            </br>
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

 <!-- ******************* MODAL NUEVO MUNICIPIO *************************** -->

<div class="modal fade modal-primary" id="myCreateMunicipio" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Nuevo Municipio</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{ csrf_token() }}" id="token">
                <div class="form-group">
                    {!!Form::label('Nombre','Nombre del Municipio: ')!!}
                    {!! Form::text('res.m_departamento', null, array('placeholder' => 'Ingrese Nombre de Municipio','class' => 'form-control','id'=>'m_municipio','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                    <label>
                        Departamento:
                    </label> 
                    <select class="form-control" id="m_departamento" name="m_departamento" placeholder="" value="">
                        <option>Seleccione Departamento...</option>
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
                </div>     
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registroMunicipio','class'=>'btn btn-primary'], $secure=null)!!}     
            </div>         
        </div>
    </div>
</div>

 <!-- ******************* MODAL NUEVA COMUNIDAD *************************** -->

<div class="modal fade modal-primary" id="myCreateComunidad" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Nueva Comunidad</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{ csrf_token() }}" id="token">
                <div class="form-group">
                    {!!Form::label('Comunidad','Nombre de la Comunidad: ')!!}
                     {!! Form::text('res.com_comunidad', null, array('placeholder' => 'Ingrese Nombre de la Comunidad','class' => 'form-control','id'=>'com_comunidad','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                </div>
                <label>
                    Departamento
                </label>
                <select class="form-control" id="mu_departamento" name="mu_departamento" placeholder="" value="">
                        <option>Seleccione Departamento...</option>
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
                <label>
                    Municipio:
                </label> 
                <select class="form-control" id="com_municipio" name="com_municipio" placeholder="" value="">
                    <!-- <option>Seleccione Municipio...</option>
                    @foreach($dataMuni as $muni)
                        <option value="{{$muni->mun_id}}">{{$muni->mun_nombre}}</option>
                    @endforeach -->
                </select>             
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registroComunidad','class'=>'btn btn-primary'], $secure=null)!!}         
            </div>
                        
        </div>
    </div>
</div>

<!-- ******************* MODAL NUEVA ASOCIACION *************************** -->

<div class="modal fade modal-primary" id="myCreateAsociacion" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Nueva Asociacion</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{ csrf_token() }}" id="token">
                <div class="form-group">
                    {!!Form::label('Asociacion','Nombre de la Asociacion: ')!!}
                     {!! Form::text('res.as_asociacion', null, array('placeholder' => 'Ingrese Nombre de la Asociacion','class' => 'form-control','id'=>'as_asociacion','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                </div>
                <div class="form-group">
                    {!!Form::label('Sigla','Sigla: ')!!}    
                     {!! Form::text('res.as_sigla', null, array('placeholder' => 'Ingrese Sigla de la Asociacion','class' => 'form-control','id'=>'as_sigla','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                </div>
                <label>
                    Departamento
                </label>
                <select class="form-control" id="as_departamento" name="as_departamento" placeholder="" value="">
                        <option>Seleccione Departamento...</option>
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
                <label>
                    Municipio:
                </label> 
                <select class="form-control" id="as_municipio" name="as_municipio" placeholder="" value="">
                    <!-- <option>Seleccione Municipio...</option>
                    @foreach($dataMuni as $muni)
                    <option value="{{$muni->mun_id}}">{{$muni->mun_nombre}}</option>
                    @endforeach -->
                </select>           
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registroAsociacion','class'=>'btn btn-primary'], $secure=null)!!}  
            </div>            
        </div>
    </div>
</div>


@push('scripts')
<script>     

$('#id_departamento').on('change', function(e){
    console.log(e);
    var depto_id = e.target.value;
    $.get('/ajax-municipio?depto_id='+depto_id, function(data){
        // console.log(data);
        $('#id_municipio').empty();
        $('#id_municipio').append('<option value="0">Seleccione</option>');
        $.each(data, function(index, muniObj){
            $('#id_municipio').append('<option value="'+muniObj.mun_id+'">'+muniObj.mun_nombre+'</option>');
        });
    });
});

$('#id_municipio').on('change', function(e){
    console.log(e);
    var municipio_id = e.target.value;
    $.get('/ajax-comunidad?municipio_id='+municipio_id, function(data){
        // console.log(data);
        $('#id_comunidad').empty();
        $('#id_comunidad').append('<option value="0">Seleccione</option>');
        $.each(data, function(index, comuObj){
            $('#id_comunidad').append('<option value="'+comuObj.com_id+'">'+comuObj.com_nombre+'</option>');
        });
    });
});

$('#id_municipio').on('change', function(e){
    console.log(e);
    var municipio_id = e.target.value;
    $.get('/ajax-asociacion?municipio_id='+municipio_id, function(data){
        // console.log(data);
        $('#id_asociacion').empty();
        $('#id_asociacion').append('<option value="0">Seleccione</option>');
        $.each(data, function(index, asocObj){
            $('#id_asociacion').append('<option value="'+asocObj.aso_id+'">'+asocObj.aso_nombre+'</option>');
        });
    });
});
// SUB MODALS CREATE 
$('#mu_departamento').on('change', function(e){
    console.log(e);
    var depto_id = e.target.value;
    $.get('/ajax-municipio?depto_id='+depto_id, function(data){
        // console.log(data);
        $('#com_municipio').empty();
        $('#com_municipio').append('<option value="0">Seleccione</option>');
        $.each(data, function(index, muniObj){
            $('#com_municipio').append('<option value="'+muniObj.mun_id+'">'+muniObj.mun_nombre+'</option>');
        });
    });
});

$('#as_departamento').on('change', function(e){
    console.log(e);
    var depto_id = e.target.value;
    $.get('/ajax-municipio?depto_id='+depto_id, function(data){
        // console.log(data);
        $('#as_municipio').empty();
        $('#as_municipio').append('<option value="0">Seleccione</option>');
        $.each(data, function(index, muniObj){
            $('#as_municipio').append('<option value="'+muniObj.mun_id+'">'+muniObj.mun_nombre+'</option>');
        });
    });
});
</script>
@endpush