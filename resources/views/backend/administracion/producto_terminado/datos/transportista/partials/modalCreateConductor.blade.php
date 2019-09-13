<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="myCreateConductor" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
      <div class="row">
         <div class="col-xs-12 container-fluit">
             <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4>
	                    Registrar Conductor
                    </h4>
                    </div>
                    <div class="panel-body">
                <div class="caption">
                    <hr>
                        {!! Form::open(['id'=>'conductor'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id" name="prsid" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nombre:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('prs_nombres', null, array('placeholder' => 'ingrese Nombre(s) ','maxlength'=>'20','class' => 'form-control','id'=>'nombres')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Paterno:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('prs_paterno', null, array('placeholder' => 'Ingrese Apellido Paterno','maxlength'=>'15','class' => 'form-control','id'=>'paterno')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Materno:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('prs_materno', null, array('placeholder' => 'Ingrese Apellido Materno','maxlength'=>'15','class' => 'form-control','id'=>'materno')) !!}
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
                                                    {!! Form::text('prs_ci', null, array('placeholder' => 'Ingrese C.I. ','maxlength'=>'10','class' => 'form-control','id'=>'ci')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Genero:
                                                </label>
                                                <div class="controls">
                                                    <!--{!! Form::text('prs_sexo', null, array('placeholder' => 'Ingrese genero','class' => 'form-control','id'=>'sexo')) !!}-->
                                                    {!! Form::radio('prs_sexo','M', ['class'=>'form-control','id'=>'sexo']) !!} Masculino

                                    {!! Form::radio('prs_sexo','F',['class'=>'form-control','id'=>'sexo']) !!} Femenino
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Fecha de Nacimiento:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    <div class="input-group">
                                                        <input class="form-control datepicker" id="fec_nacimiento" name="fec_nacimiento" type="text" value="">
                                                            <div class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar">
                                                                </span>
                                                            </div>
                                                        </input>
                                                    </div>
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
                                                    Dirección:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('prs_direccion', null, array('placeholder' => 'Ingrese dirección','maxlength'=>'50','class' => 'form-control','id'=>'direccion')) !!}
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
                                                    {!! Form::text('prs_telefono', null, array('placeholder' => 'Ingrese telefono ', 'class' => 'form-control','id'=>'telefono')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Celular:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('prs_celular', null, array('placeholder' => 'Ingrese celular ', 'class' => 'form-control','id'=>'celular')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Correo:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('prs_correo', null, array('placeholder' => 'Ingrese correo ejemplo@gmail.com','class' => 'form-control','id'=>'correo')) !!}
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
                                                    Estado Civil:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    <select class="form-control" id="estadocivil" name="prs_id_estado_civil" placeholder="Ingrese estado civil">
                                                        @foreach($data as $rol)
                                                        <option value="{{$rol->estcivil_id}}">
                                                            {{$rol->estcivil}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nro Licencia Conducir:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('pcd_licencia', null, array('placeholder' => 'Ingrese numero de licencia de conducir','class' => 'form-control','id'=>'pcd_licencia')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Categoria:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('pcd_categoria', null, array('placeholder' => 'Ingrese la categoria de su licencia','class' => 'form-control','id'=>'categoria')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div><br><br><br>
                                    <div class="col-md-12 text-center">
                                        <label><b>ASIGNACION DE VEHICULO</b></label>
                                    </div>
                                   <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Vehiculo a conducir:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                   {!! Form::select('pcd_veh_id', $vehiculo, null,['class'=>'form-control','name'=>'pcd_veh_id', 'id'=>'pcd_veh_id','placeholder'=>'Seleccione']) !!}
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
            </div>
            </div>
            </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registroConductor','class'=>'btn btn-success'], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
