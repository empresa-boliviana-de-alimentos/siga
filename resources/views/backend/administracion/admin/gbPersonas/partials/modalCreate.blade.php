<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="myCreate" tabindex="-5">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
      <div class="row">
         <div class="col-xs-12 container-fluit">
             <div class="panel panel-warning">
                <div class="panel-heading">
                    <h4>
                    Registrar Persona
                    </h4>
                    </div>
                    <div class="panel-body">
                <div class="caption">
                    <hr>
                        {!! Form::open(['id'=>'persona'])!!}
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
                                                    Direccion:
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
                                                    Direccion Auxiliar:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('prs_direccion2', null, array('placeholder' => 'Ingrese dirección auxiliar','class' => 'form-control','id'=>'direccionaux')) !!}
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
                                                    {!! Form::text('prs_telefono', null, array('placeholder' => 'Ingrese telefono', 'class' => 'form-control','id'=>'telefono')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Telefono Auxiliar:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('prs_telefono2', null, array('placeholder' => 'Ingrese telefono auxiliar', 'class' => 'form-control','id'=>'telefonoaux')) !!}
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
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Area Produccion:
                                                </label>
                                                    <select class="form-control" id="lineatrabajo" name="lineatrabajo" onchange="muestradat()" required>
                                                        <option value="">Elija una opcion</option>
                                                        @foreach($dataList as $list)
                                                        <option value="{{$list->ltra_id}}">
                                                            {{$list->ltra_nombre}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="datoaddcomp" style="display: none;">
                                    <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Tipo Persona:
                                                    </label>
                                                    <select class="form-control" id="rol" name="rol" onchange="muestrapersona()">
                                                        <option value="">Elija una opcion</option>
                                                        @foreach($dataRol as $rol)
                                                        <option value="{{$rol->rls_id}}">
                                                            {{$rol->rls_rol}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
				    <div class="col-md-6" id="zonaResp" style="display: none;">
					
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Zona de Accion:
                                                    </label>
                                                    <select class="form-control" id="zona" name="zona" onchange="muestrapersona()">
                                                        <option value="">Elija una opcion</option>
                                                        <option value="A - RIBERALTA">A - RIBERALTA</option>
                                                        <option value="B - EL SENA">B - EL SENA</option>
                                                        <option value="C - COBIJA">C - COBIJA</option>
                                                    </select>
                                                </div>
                                            </div>
                                        

				    </div>
                                    <div id="datoaddper" style="display: none;">
                                                                                                                    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Tipo de Garantia:
                                                    </label>
                                                     <select class="form-control" id="tipg" name="tipg" onchange="muestragarantia()">
                                                        <option value="">Elija una opcion</option>
                                                        @foreach($dataTipg as $tgar)
                                                        <option value="{{$tgar->tipg_garantia_id}}">
                                                            {{$tgar->tipg_garantia_nombre}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="datoaddgar" style="display: none;">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Tipo de Relacion:
                                                    </label>
                                                    <select class="form-control" id="rel" name="rel" placeholder="Ingrese Expedido" value="">
                                                       @foreach($dataRel as $rel)
                                                        <option value="{{$rel->tiprel_id}}">{{$rel->tiprel_nombre}}</option>
                                                       @endforeach
                                                    </select>
                                                    
                                                </div>
                                            </div>
                                        </div>   
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Nombre y Apellido:
                                                    </label>
                                                    <span class="block input-icon input-icon-right">
                                                    {!! Form::text('nompar', null, array('placeholder' => 'Ingrese Nombre Parentesco','class' => 'form-control','id'=>'nompar')) !!}
                                                    </span>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        C.I.:
                                                    </label>
                                                    <span class="block input-icon input-icon-right">
                                                    {!! Form::text('cipar', null, array('placeholder' => 'Ingrese C.I.','class' => 'form-control','id'=>'cipar')) !!}
                                                    </span>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Expedido en:
                                                    </label>
                                                    <select class="form-control" id="expar" name="expar" placeholder="Ingrese Expedido" value="">
                                                       @foreach($dataExp as $exp)
                                                        <option value="{{$exp->dep_id}}">{{$exp->dep_exp}}</option>
                                                       @endforeach
                                                    </select>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        </div>

                                        <div id="datoaddgar1" style="display: none;">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Tipo de Relacion:
                                                    </label>
                                                    <select class="form-control" id="rel1" name="rel1" placeholder="Ingrese Expedido" value="">
                                                       @foreach($dataRel1 as $rel1)
                                                        <option value="{{$rel1->tiprel_id}}">{{$rel1->tiprel_nombre}}</option>
                                                       @endforeach
                                                    </select>     
                                                </div>
                                            </div>
                                        </div>   
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Nro de Regitro:
                                                    </label>
                                                    <span class="block input-icon input-icon-right">
                                                    {!! Form::text('nroreg', null, array('placeholder' => 'Ingrese Nro Registro','class' => 'form-control','id'=>'nroreg')) !!}
                                                    </span>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Valor del Bien:
                                                    </label>
                                                    <span class="block input-icon input-icon-right">
                                                    {!! Form::text('valorbien', null, array('placeholder' => 'Ingrese Valor del Bien','class' => 'form-control','id'=>'valorbien')) !!}
                                                    </span>
                                                    
                                                </div>
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
            </div>
            </div>
            </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registro','class'=>'btn btn-warning'], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=geometry&v=3.22&key=AIzaSyDKalaXloymra2Q8Rro5T5xP2DLxzP24BQ">
</script>
<script type="text/javascript">

function muestradat(){

    var idprv = document.getElementById('lineatrabajo').value;
    console.log(idprv);
    
    if (idprv==1) {
        $('#datoaddcomp').show();
       
    }else{
      
       $('#datoaddcomp').hide();  
    }
}

function muestrapersona(){

    var idper = document.getElementById('rol').value;
    console.log(idper);
    
    if (idper==2) {
        $('#datoaddper').show();
        $('#zonaResp').show();
       
    }else if(idper == 13){
        $('#zonaResp').show();
        $('#datoaddper').hide();
    }else{
       $('#zonaResp').hide();
       $('#datoaddper').hide();  
    }
}
function muestragarantia(){

    var idgar = document.getElementById('tipg').value;
    console.log(idgar);
    
    if (idgar==1) {
        $('#datoaddgar1').hide();
        $('#datoaddgar').show();
       
    }else{
        $('#datoaddgar').hide();
       $('#datoaddgar1').show();  
    }
}

</script>
@endpush
    
     
  
