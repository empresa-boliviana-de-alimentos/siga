<div class="extended_modals">
<div class="modal fade bs-example-modal-sm in" data-backdrop="static" data-keyboard="false" id="myCreate" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    ×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Registro de Nuevo Proveedor
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                        {!! Form::open(['id'=>'proveedor', 'files' => true])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id" name="id_proveedor" type="hidden" value="">
                                <div class="row">
                                    <div class="text-center">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="fileinput fileinput-new" id="img-prov" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail" style="width: 120px; height: 120px;">
                                                        </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 120px; max-height: 120px;"></div>
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
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nombres:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('nombres', null, array('placeholder' => 'Ingrese Nombre(s) ','maxlength'=>'40','class' => 'form-control','id'=>'nombres','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                     Apellido Paterno:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('apellido_paterno', null, array('placeholder' => 'Ingrese Apellido Paterno','maxlength'=>'15','class' => 'form-control','id'=>'apellido_paterno','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Apellido Materno:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('apellido_materno', null, array('placeholder' => 'Ingrese Apellido Materno','class' => 'form-control','id'=>'apellido_materno')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    C.I.:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('ci', null, array('placeholder' => 'Ingrese C.I. ','maxlength'=>'10','class' => 'form-control','id'=>'ci')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Expedido:
                                                </label>
                                                 <select class="form-control" id="exp" name="exp">
                                                     <option>Seleccione..</option>
                                                     @foreach($exp as $ex)
                                                     <option value="{{$ex->dep_id}}">{{$ex->dep_exp}}</option>
                                                     @endforeach
                                                 </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="row">                                   
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Telefono:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('telefono', null, array('placeholder' => 'Ingrese telefono', 'class' => 'form-control','id'=>'telefono')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Dirección:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('direccion', null, array('placeholder' => 'Ingrese dirección','maxlength'=>'50','class' => 'form-control','id'=>'direccion','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Rau:
                                                </label>
                                                <select class="form-control" id="prov_rau" name="prov_rau">
                                                        <option value="1">SI</option>
                                                        <option value="2">NO</option> 
                                                </select>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                              <!--  <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                {!!Form::label('Municipio','Municipio: ')!!}
                                                {!! Form::select('id_municipio', $municipio, null,['class'=>'form-control','name'=>'id_municipio', 'id'=>'id_municipio']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Nuevo</label>
                                                <a class="btn btn-success" data-toggle="modal" href="#nuevoMunicipio">+</a>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                {!!Form::label('Comunidad','C. Agraria o Comunidad: ')!!}
                                                {!! Form::select('id_comunidad', $comunidad, null,['class'=>'form-control','name'=>'id_comunidad', 'id'=>'id_comunidad']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Nuevo</label>
                                                <a class="btn btn-success" data-toggle="modal" href="#nuevaComunidad">+</a>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                               {!!Form::label('Asocacion','Sindicato o Asociacion: ')!!}
                                               {!! Form::select('id_asociacion', $asociacion, null,['class'=>'form-control','name'=>'id_asociacion', 'id'=>'id_asociacion']) !!} 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Nuevo</label>
                                                <a class="btn btn-success" data-toggle="modal" href="#nuevaAsociacion">+</a>
                                            </div>
                                        </div>                                        
                                    </div>
                                </div>-->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Departamento:
                                                </label>
                                                 {!! Form::select('id_departamento', $departamento, null,['class'=>'form-control','name'=>'id_departamento', 'id'=>'id_departamento','placeholder'=>'Seleccione']) !!}
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Provincia:
                                                </label>
                                                 {!! Form::select('id_provincia', $provincia, null,['class'=>'form-control','name'=>'id_provincia', 'id'=>'id_provincia', 'placeholder'=>'Seleccione']) !!} 
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
                                                    {!! Form::text('comunidad', null, array('placeholder' => 'Ingrese comunidad','maxlength'=>'50','class' => 'form-control','id'=>'comunidad','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
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
                                                    Tipo Proveedor:
                                                </label>
                                                <select class="form-control" id="id_tipo_prov" name="id_tipo_prov">
                                                        <option>Seleccionar</option>
                                                        <option value="1">Proveedor</option>
                                                        <option value="2">Productor</option>     
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
                <button class="btn btn-danger" data-dismiss="modal" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registro','class'=>'btn btn-success'], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@include('backend.administracion.acopio.acopio_miel.proveedor.partials.modalCreateMunicipio')
@include('backend.administracion.acopio.acopio_miel.proveedor.partials.modalCreateComunidad')
@include('backend.administracion.acopio.acopio_miel.proveedor.partials.modalCreateAsociacion')
</div>
{!! Html::script('js/jquery-3.1.0.min.js') !!}
<script type="text/javascript">


$('#id_departamento').on('change', function(e){
    console.log(e);
    var depto_id = e.target.value;
    $.get('/ajax-provincia?depto_id='+depto_id, function(data){
        console.log(data);
        $('#id_provincia').empty();
        $('#id_provincia').append('<option value="0">Seleccione</option>');
        $.each(data, function(index, provObj){
            $('#id_provincia').append('<option value="'+provObj.provi_id+'">'+provObj.provi_nom+'</option>');
        });
    });
});

// $('#id_municipio').on('change', function(e){
//     console.log(e);
//     var municipio_id = e.target.value;
//     $.get('/ajax-comunidad?municipio_id='+municipio_id, function(data){
//         // console.log(data);
//         $('#id_comunidad').empty();
//         $('#id_comunidad').append('<option value="0">Seleccione</option>');
//         $.each(data, function(index, comuObj){
//             $('#id_comunidad').append('<option value="'+comuObj.com_id+'">'+comuObj.com_nombre+'</option>');
//         });
//     });
// });

// $('#id_municipio').on('change', function(e){
//     console.log(e);
//     var municipio_id = e.target.value;
//     $.get('/ajax-asociacion?municipio_id='+municipio_id, function(data){
//         // console.log(data);
//         $('#id_asociacion').empty();
//         $('#id_asociacion').append('<option value="0">Seleccione</option>');
//         $.each(data, function(index, asocObj){
//             $('#id_asociacion').append('<option value="'+asocObj.aso_id+'">'+asocObj.aso_nombre+'</option>');
//         });
//     });
// });
</script>