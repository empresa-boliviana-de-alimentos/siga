<div class="modal fade bs-example-modal-sm in" data-backdrop="static" data-keyboard="false" id="myUpdate" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
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
                        {!! Form::open(['id'=>'proveedor1','files' => true])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                         <input id="id1" name="prsid1" type="hidden" value="">
                            <div class="row">
                                <div class="text-center">
                                    <div class="col-md-4">
                                        <input type="hidden" id="imagenActual" name="imagenActual">
                                        <input type="file" id="files" class="img_file" name="imgProveedor1" id="list"> 
                                        <div class="col-md-6">
                                            <div class="form-group">                                         
                                                <img src="" width="120px" height="120px" id="imagenProv" name="img">                                            
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">                            
                                                <output id="list"></output>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                            <label style="color: blue">Documentos Proveedor en formato PDF <span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span></label>
                                            <input type="file" name="archivo_pdf1" accept=".pdf" id="uploadPDF" class="form-control archivo_pdf"> 
                                            <input type="hidden" name="doc_actual_nombre" id="doc_actual_nombre">
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
                                                {!! Form::text('nombres', null, array('placeholder' => 'ingrese Nombre(s) ','maxlength'=>'20','class' => 'form-control','id'=>'nombres1')) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                Apelido Paterno:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('apellido_paterno', null, array('placeholder' => 'Ingrese Apellido Paterno','maxlength'=>'15','class' => 'form-control','id'=>'apellido_paterno1')) !!}
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
                                                {!! Form::text('apellido_materno', null, array('placeholder' => 'Ingrese Apellido Materno','maxlength'=>'15','class' => 'form-control','id'=>'apellido_materno1')) !!}
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
                                                {!! Form::text('ci', null, array('placeholder' => 'Ingrese C.I. ','maxlength'=>'10','class' => 'form-control','id'=>'ci1')) !!}
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
                                             <select class="form-control" id="exp1" name="exp" placeholder="Elija el depto" value="">
                                                    <option value="1">
                                                        LP
                                                    </option>
                                                    <option value="2">
                                                        OR
                                                    </option>
                                                    <option value="3">
                                                        PT
                                                    </option>
                                                    <option value="4">
                                                        TJ
                                                    </option>
                                                    <option value="5">
                                                        SC
                                                    </option>
                                                    <option value="6">
                                                        CB
                                                    </option>
                                                    <option value="7">
                                                        BN
                                                    </option>
                                                    <option value="8">
                                                        PA
                                                    </option>
                                                    <option value="9">
                                                        CH
                                                    </option>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- DOCUMENTOS PDF -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label for="">Doc Actual</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <!-- <embed id="doc_actual" src="nombre_archivo.pdf" type="application/pdf" width="100%" height="150"></embed> -->
                                            <iframe id="doc_actual" src="" width="100%" height="280px"></iframe>
                                         </div>
                                    </div>                              
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label for="">Doc Nuevo</label> <input type="button" value="Ver documento" onclick="PreviewImage();" /> 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div style="clear:both"> 
                                                <iframe id="viewer" frameborder="0" scrolling="no" width="100%" height="280"></iframe> 
                                            </div> 
                                         </div>
                                    </div>                              
                                </div>
                            </div>
                            <!-- END DOCUMENTOS PDF -->
                            <!-- UBICACION GEOGRÁFICA -->                                
                                <div class="row">
                                    <div class="col-md-6">                                        
                                        <div id="mapUpdate" style="with:80px;height:80px;">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('lat_map','Lat:',['class'=>'col-sm-2 control-label']) !!}
                                                <div class="col-sm-10">
                                                    {!! Form::text('lat_map',null,['id'=>'coordslat1','class'=>'form-control','placeholder'=>'Introduzca latitud del mapa','step'=>'any','required']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('lng_map','Lng:',['class'=>'col-sm-2 control-label']) !!}
                                                <div class="col-sm-10">
                                                    {!! Form::text('lng_map',null,['id'=>'coordslng1','class'=>'form-control','placeholder'=>'Introduzca longitud del mapa','step'=>'any','required']) !!}
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
                                                {!! Form::text('telefono', null, array('placeholder' => 'Expedido ','maxlength'=>'10','class' => 'form-control','id'=>'telefono1')) !!}
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
                                                {!! Form::text('direccion', null, array('placeholder' => 'Ingrese dirección','maxlength'=>'50','class' => 'form-control','id'=>'direccion1')) !!}
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
                                            <select class="form-control" id="id_rau1" name="id_rau" placeholder="Elija una opcion" value="">
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
                            <div id="dvOcultar1" style="display: none;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                Nit:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('nit', null, array('placeholder' => 'Ingrese Nit', 'class' => 'form-control','id'=>'nit1')) !!}
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
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                Cuenta Bancaria:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('cuenta_bancaria', null, array('placeholder' => 'Ingrese Cuenta bancaria', 'class' => 'form-control','id'=>'cuenta_bancaria1')) !!}
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
                                            <!-- <span class="block input-icon input-icon-right">
                                                {!! Form::text('id_departamento', null, array('placeholder' => 'Ingrese Dpto', 'class' => 'form-control','id'=>'id_departamento1')) !!}
                                            </span> -->
                                            <select class="form-control" id="id_departamento1" name="id_departamento" placeholder="Elija el depto" value="" selected>
                                                    <option value="0">Seleccino Depto</option>
                                                    <option value="1">
                                                        La Paz
                                                    </option>
                                                    <option value="2">
                                                        Oruro
                                                    </option>
                                                    <option value="3">
                                                        Potosi
                                                    </option>
                                                    <option value="4">
                                                        Tarija
                                                    </option>
                                                    <option value="5">
                                                        Santa Cruz
                                                    </option>
                                                    <option value="6">
                                                        Cochabamba
                                                    </option>
                                                    <option value="7">
                                                        Beni
                                                    </option>
                                                    <option value="8">
                                                        Pando
                                                    </option>
                                                    <option value="9">
                                                        Chuquisaca
                                                    </option>
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
                                            <span class="block input-icon input-icon-right">
                                                <!-- {!! Form::text('id_municipio', null, array('placeholder' => 'Ingrese Municipio', 'class' => 'form-control','id'=>'id_municipio1')) !!} -->
                                                {!! Form::select('id_municipio', $municipio, null,['class'=>'form-control','name'=>'id_municipio1', 'id'=>'id_municipio1']) !!}
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
                                                <!-- {!! Form::text('id_comunidad', null, array('placeholder' => 'Ingrese Comunidad', 'class' => 'form-control','id'=>'id_comunidad1')) !!} -->
                                                {!! Form::select('id_comunidad', $comunidad, null,['class'=>'form-control','name'=>'id_comunidad1', 'id'=>'id_comunidad1']) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                Asociación:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                <!-- {!! Form::text('id_asociacion', null, array('placeholder' => 'Ingrese Dpto', 'class' => 'form-control','id'=>'id_asociacion1')) !!} -->
                                                {!! Form::select('id_asociacion', $asociacion, null,['class'=>'form-control','name'=>'id_asociacion1', 'id'=>'id_asociacion1']) !!}
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
                                            <span class="block input-icon input-icon-right">
                                                <!-- {!! Form::text('id_tipo_prov', null, array('placeholder' => 'Ingrese Tipo Proveedor', 'class' => 'form-control','id'=>'id_tipo_prov1')) !!} -->
                                                {!! Form::select('id_tipo_prov', $tipo_proveedor, null,['class'=>'form-control','name'=>'id_tipo_prov1', 'id'=>'id_tipo_prov1']) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <div id="dvOcultar3" style="display: none;">
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
                            <!-- <div class="row">                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                        
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::hidden('lugar_proveedor', null, array('placeholder' => 'Ingrese Tipo Proveedor', 'class' => 'form-control','id'=>'lugar_proveedor1')) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>                                
                            </div>   -->                      
                        </input>
                    </hr>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Actualizar', $attributes=['id'=>'actualizar','class'=>'btn btn-primary','style'=>'background:#57BC90'], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
function archivo(evt) {
        var files = evt.target.files; // FileList object
                         
        // Obtenemos la imagen del campo "file".
    for (var i = 0, f; f = files[i]; i++) {
            //Solo admitimos imágenes.
        if (!f.type.match('image.*')) {
            continue;
        }
        var reader = new FileReader();
                         
        reader.onload = (function(theFile) {
        return function(e) {
                // Insertamos la imagen
            document.getElementById("list").innerHTML = ['<img width="120px" height="120px" class="thumb" id="img2" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
                };
        })(f);
                         
        reader.readAsDataURL(f);
    }
}
                         
document.getElementById('files').addEventListener('change', archivo, false);



function PreviewImage() 
{ 
    pdffile=document.getElementById("uploadPDF").files[0]; pdffile_url=URL.createObjectURL(pdffile); $('#viewer').attr('src',pdffile_url); 
}

$(function(){
    $('#id_rau1').change(function(){
    if($(this).val()==2){
        $('#dvOcultar1').hide();
    }else{
        $('#dvOcultar1').show();
    }
  
  })

});
$(function(){
    $('#id_tipo_prov1').change(function(){
    if($(this).val()!=11){
        $('#dvOcultar3').hide();
    } else if($(this).val()==11){
        $('#dvOcultar3').show();
    } 
  
  })

});
</script>
                        
@endpush
