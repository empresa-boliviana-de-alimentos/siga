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
                         <input id="id1" name="prsid1" type="" value="">
                            <div class="row">
                                <div class="col-md-4">
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
                            </div>
                            <div class="row">
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
                                            <!-- <span class="block input-icon input-icon-right">
                                                {!! Form::text('exp', null, array('placeholder' => 'Expedido ','maxlength'=>'10','class' => 'form-control','id'=>'exp1')) !!}
                                            </span> -->
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
                            </div>
                            <div class="row">
                                <div class="col-md-8">
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
                                                    Rau:
                                                </label>
                                                <select class="form-control" id="id_rau1" name="id_rau1">
                                                        <option value="1">SI</option>
                                                        <option value="2">NO</option> 
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                Tipo Proveedor:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                            <select class="form-control" id="id_tipo_prov" name="id_tipo_prov">
                                                <option value="1">Proveedor</option>
                                                <option value="2">Productor</option>          
                                            </select>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

<script>
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
                         
</script>

                        

