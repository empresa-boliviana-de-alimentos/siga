
<div class="extended_modals">

<div class="modal fade bs-example-modal-sm in" style="overflow-y: scroll;" data-backdrop="static" data-keyboard="false" id="myCreate" tabindex="-5">
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
                    <?php $now = new \DateTime() ?>
                        {!! Form::open(['id'=>'proveedor', 'files' => true])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id" name="id_proveedor" type="hidden" value="">
                            <input id="fecha_registro" name="fecha_registro" type="hidden" value="<?php echo $now->format('d-m-Y H:i:s'); ?>">
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
                                                <div class="form-group">
                                                    <label style="color: blue">Documentos Proveedor en formato PDF <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></label>
                                                    <input type="file" name="archivo_pdf" accept=".pdf" id="archivo_pdf" class="form-control"> 
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
                                                    {!! Form::text('nombres', null, array('placeholder' => 'ingrese Nombre(s) ','maxlength'=>'40','class' => 'form-control','id'=>'nombres','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
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
                                                    {!! Form::text('apellido_materno', null, array('placeholder' => 'Ingrese Apellido Materno','maxlength'=>'15','class' => 'form-control','id'=>'apellido_materno','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
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
                                                {!! Form::select('exp', $dep_exp, null,['class'=>'form-control','name'=>'exp', 'id'=>'exp']) !!}
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- UBICACION GEOGRÁFICA -->                                
                                <div class="row">
                                    <div class="col-md-6">                                        
                                        <div id="map" style="with:80px;height:80px;">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('lat_map','Lat:',['class'=>'col-sm-2 control-label']) !!}
                                                <div class="col-sm-10">
                                                    {!! Form::number('lat_map',0,['id'=>'coordslat','class'=>'form-control','placeholder'=>'Introduzca latitud del mapa','step'=>'any','readonly']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('lng_map','Lng:',['class'=>'col-sm-2 control-label']) !!}
                                                <div class="col-sm-10">
                                                    {!! Form::number('lng_map',0,['id'=>'coordslng','class'=>'form-control','placeholder'=>'Introduzca longitud del mapa','step'=>'any','readonly']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <!-- END UBICACION GEOGRÁFICA -->
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
                                                    RAU:
                                                </label>
                                                
                                                <select class="form-control" id="id_rau" name="id_rau" placeholder="Elija una opcion" value="">
                                                    <option value="0" disabled selected>
                                                        Seleccione
                                                    </option>
                                                    <option value="1">
                                                        SI
                                                    </option>
                                                    <option value="2">
                                                        NO
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                <div id="dvOcultar" style="display: none">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nit:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    <!-- {!! Form::text('nit', '0', array('placeholder' => 'Ingrese nit','class' => 'form-control','id'=>'nit')) !!} -->
                                                    {!! Form::number('nit', '0', array('placeholder' => 'Numero de nit','class' => 'form-control','id'=>'nit')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Fecha Inscripción:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    <input type="text" class="form-control datepickerDays" id="fecha_inscripcion" name="fecha_inscripcion" placeholder="Introduzca dia"> 
                                                </span>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Fecha Vencimiento:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    <input type="text" class="form-control datepickerDays" id="fecha_vecimiento" name="fecha_vencimiento" placeholder="Introduzca dia"> 
                                                </span>
                                            </div>
                                        </div>
                                    </div>                                      
                                </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Cuenta Bancaria:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('cuenta_bancaria', '0', array('placeholder' => 'Ingrese cuenta bancaria','class' => 'form-control','id'=>'cuenta_bancaria')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Departamento:
                                                </label>
                                                {!! Form::select('departamento', $departamento, null,['class'=>'form-control','name'=>'departamento', 'id'=>'departamento','placeholder'=>'Seleccione']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                
                                                {!!Form::label('Municipio','Municipio: ')!!}
                                                
                                                <select name="municipio" class="form-control" id="municipio" style="width: 100%"></select>
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
                                                <!-- {!! Form::select('id_comunidad', $comunidad, null,['class'=>'form-control','name'=>'id_comunidad', 'id'=>'id_comunidad']) !!} -->
                                                <select name="comunidad" class="form-control" id="comunidad" style="width: 100%"></select>
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
                                                <!-- {!! Form::select('id_asociacion', $asociacion, null,['class'=>'form-control','name'=>'id_asociacion', 'id'=>'id_asociacion']) !!} -->
                                                <select name="asociacion" class="form-control" id="asociacion" style="width: 100%"></select>
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
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Tipo Proveedor:
                                                </label>
                                                {!! Form::select('tipo_proveedor', $tipo_proveedor, null,['class'=>'form-control','name'=>'tipo_proveedor', 'id'=>'tipo_proveedor','placeholder' => 'Seleccione un tipo']) !!}
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div id="dvOcultar2" style="display: none">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                    Nro. Contrato:
                                                    </label>
                                                    <span class="block input-icon input-icon-right">
                                                    {!! Form::text('nro_contrato', null , array('placeholder' => 'Numero de Contrato','class' => 'form-control','id'=>'nro_contrato')) !!}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                    Monto Prestamo:
                                                    </label>
                                                    <span class="block input-icon input-icon-right">
                                                    {!! Form::number('monto_prestamo', '0', array('placeholder' => 'Ingrese Monto a Asignar','class' => 'form-control','id'=>'monto_prestamo','step'=>'any')) !!}
                                                    </span>
                                                </div>
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
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registro','class'=>'btn btn-primary','style'=>'background:#57BC90'], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@include('backend.administracion.acopio.acopio_miel.proveedor.partials.modalCreateMunicipio')
@include('backend.administracion.acopio.acopio_miel.proveedor.partials.modalCreateComunidad')
@include('backend.administracion.acopio.acopio_miel.proveedor.partials.modalCreateAsociacion')
</div>
@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=geometry&v=3.22&key=AIzaSyDKalaXloymra2Q8Rro5T5xP2DLxzP24BQ">
</script>
<script>

// OCULTA CAMPOS
$(function(){
    $('#id_rau').change(function(){
    if($(this).val()==2){
        $('#dvOcultar').hide();
    }else{
        $('#dvOcultar').show();
    }
  
  })

});
$(function(){
    $('#tipo_proveedor').change(function(){
    if($(this).val()!=11){
        $('#dvOcultar2').hide();
    } else if($(this).val()==11){
        $('#dvOcultar2').show();
    } 
  
  })

});
		
// SELECT2
// $('#id_municipio').select2({
//     dropdownParent: $('#myCreate'),
//     placeholder: "Selec. Municipio",
// });

// $('#id_comunidad').select2({
//     dropdownParent: $('#myCreate'),
//     placeholder: "Selec. Municipio",
// });

// $('#id_asociacion').select2({
//     dropdownParent: $('#myCreate'),
//     placeholder: "Selec. Asociacion",
// });

// // BUSQUEDAS ASINCRONAS          
// $('#id_municipio').select2({
//     dropdownParent: $('#myCreate'),
//     placeholder: "Selec. Municipio",
//     municipio: true,
//     tokenSeparators: [','],
//     ajax: {
//         dataType: 'json',
//         url: '{{ url("obtenerMunicipio") }}',
//         delay: 250,
//         data: function(params) {
//             return {
//                 term: params.term
//             }
//         },
//         processResults: function (data, page) {
//             return {
//             results: data
//             };
//         },
//     },
//     language: "es",
// });

// $('#id_comunidad').select2({
//     dropdownParent: $('#myCreate'),
//     placeholder: "Selec. Comunidad",
//     comunidad: true,
//     tokenSeparators: [','],
//     ajax: {
//         dataType: 'json',
//         url: '{{ url("obtenerComunidad") }}',
//         delay: 250,
//         data: function(params) {
//             return {
//                 term: params.term
//             }
//         },
//         processResults: function (data, page) {
//             return {
//             results: data
//             };
//         },
//     },
//     language: "es",
// });

// $('#id_asociacion').select2({
//     dropdownParent: $('#myCreate'),
//     placeholder: "Selec. Asociacion",
//     asociacion: true,
//     tokenSeparators: [','],
//     ajax: {
//         dataType: 'json',
//         url: '{{ url("obtenerAsociacion") }}',
//         delay: 250,
//         data: function(params) {
//             return {
//                 term: params.term
//             }
//         },
//         processResults: function (data, page) {
//             return {
//             results: data
//             };
//         },
//     },
//     language: "es",
// });        

$('#departamento').on('change', function(e){
    console.log(e);
    var depto_id = e.target.value;
    $.get('/ajax-municipio?depto_id='+depto_id, function(data){
        // console.log(data);
        $('#municipio').empty();
        $('#municipio').append('<option value="0">Seleccione</option>');
        $.each(data, function(index, muniObj){
            $('#municipio').append('<option value="'+muniObj.mun_id+'">'+muniObj.mun_nombre+'</option>');
        });
    });
});

$('#municipio').on('change', function(e){
    console.log(e);
    var municipio_id = e.target.value;
    $.get('/ajax-comunidad?municipio_id='+municipio_id, function(data){
        // console.log(data);
        $('#comunidad').empty();
        $('#comunidad').append('<option value="0">Seleccione</option>');
        $.each(data, function(index, comuObj){
            $('#comunidad').append('<option value="'+comuObj.com_id+'">'+comuObj.com_nombre+'</option>');
        });
    });
});

$('#municipio').on('change', function(e){
    console.log(e);
    var municipio_id = e.target.value;
    $.get('/ajax-asociacion?municipio_id='+municipio_id, function(data){
        // console.log(data);
        $('#asociacion').empty();
        $('#asociacion').append('<option value="0">Seleccione</option>');
        $.each(data, function(index, asocObj){
            $('#asociacion').append('<option value="'+asocObj.aso_id+'">'+asocObj.aso_nombre+'</option>');
        });
    });
});


$('.datepickerDays').datepicker({
        format: "dd/mm/yyyy",        
        language: "es",
    }).datepicker("setDate", new Date()); 
</script>
@endpush