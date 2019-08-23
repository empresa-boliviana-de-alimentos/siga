<div class="modal fade modal-fade-in-scale-up" data-backdrop="static" data-keyboard="false" id="myCreatePl" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    X
                </button>
                <h4 class="modal-title" id="modalLabelfade">
                    <center>REGISTRO ACOPIO LACTEOS PLANTAS</center>
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                       {!! Form::open(['id'=>'acopio'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="idrec" name="prsid" value="" type="hidden">
                                <div class="row">
                                    <div class="col-md-6">
                                         <div class="col-sm-12">
                                            <label>  RECEPCIONISTA: </label>  
                                             <span class="block input-icon input-icon-right">
                                                    {!! Form::text('lab_rec', null, array('placeholder' => 'Ingrese Observaciones','maxlength'=>'50','class' => 'form-control','id'=>'lab_rec','disabled'=>'true')) !!}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                         <div class="col-sm-12">
                                            <label>
                                                Certificación de Aceptación:
                                            </label>
                                            <select class="form-control" id="lab_apr" name="lab_apr">
                                                <option disabled selected>--Seleccione--</option>
                                                <option value="1">Aceptado</option>
                                                <option value="2">Rechazado</option> 
                                            </select>
                                            </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="col-sm-12">
                                            <label>  Fecha y Hora:    </label>
                                             <br>
                                             <?php  
                                                date_default_timezone_set('America/New_York');
                                                echo  date('m/d/Y g:ia');
                                             ?>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="col-sm-12">
                                            <label>Cantidad (lts):</label>
                                            <span class="block input-icon input-icon-right">
                                            {!! Form::number('lab_cant', null, array('placeholder' => 'Ingrese Observaciones','maxlength'=>'50','class' => 'form-control','id'=>'lab_cant','disabled'=>'true')) !!}
                                            </span>
                                            
                                        </div>
                                    </div>
                                   {{--  <div class="col-md-3">
                                        <div class="col-sm-12">
                                            <label>  Cantidad Recep. (lts):    </label>
                                            <span class="block input-icon input-icon-right">
                                            {!! Form::number('lab_cant_rep', null, array('placeholder' => 'Ingrese cant. recep.','maxlength'=>'50','class' => 'form-control','id'=>'lab_cant_rep')) !!}
                                            </span>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-3">
                                        <div class="col-sm-12">
                                            <label>  Condiciones de Higiente:    </label>
                                            <select class="form-control" id="lab_cond" name="lab_cond">
                                                <option disabled selected>--Seleccione--</option>
                                                <option value="1">Aceptable</option>
                                                <option value="2">No Aceptable</option> 
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                         <div class="col-sm-12">
                                            <label>
                                                    TRAM (HRS):
                                            </label>
                                            <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                                                <input type="text" class="form-control" value="" id="lab_tra" placeholder="00:00">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-time"></span>
                                                </span>
                                            </div>
                                            </div>{{-- 'onkeyup'=>'MostrarFunsol()' --}}
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>Responsable de Analisis:</label>
                                                    <input type="text" class="form-control" value="" id="lab_enc" placeholder="{{$usuario->prs_nombres}} {{$usuario->prs_paterno}} {{$usuario->prs_materno}}" disabled="true">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-sm-12">
                                            <label>
                                                Observaciones:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('lab_obs', null, array('placeholder' => 'Ingrese Observaciones','maxlength'=>'50','class' => 'form-control','id'=>'lab_obs','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                             
                                  <!--PARAMETROS FISICO QUIMICOS--> 
                                <CENTER><h4 style="color:#191970">PARAMETROS FÍSICOQUIMICOS LABORATORIO</h4></CENTER>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    TEMPERATURA:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                 <!--<input id="n_tem" name="n_tem" type="text" placeholder="(°c)">-->
                                                  {!! Form::text('lab_tem', null, array('placeholder' => '(°c)','maxlength'=>'20','class' => 'form-control','id'=>'lab_tem')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Acidez:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('lab_aci', null, array('placeholder' => '(0,13 -0,18 % a.l.) ','maxlength'=>'20','class' => 'form-control','id'=>'lab_aci')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    PH:
                                                </label>
                                               <span class="block input-icon input-icon-right">
                                                    {!! Form::text('lab_ph', null, array('placeholder' => '(6,6 -6,8) ','maxlength'=>'20','class' => 'form-control','id'=>'lab_ph')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    SNG:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('lab_sng', null, array('placeholder' => '(9,2 minimo %) ','maxlength'=>'20','class' => 'form-control','id'=>'lab_sng')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    DENSIDAD:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('lab_den', null, array('placeholder' => '(1,028-1,034 G/cC) ','maxlength'=>'20','class' => 'form-control','id'=>'lab_den')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    MATERIA GRASA:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('lab_mgra', null, array('placeholder' => '(minimo 3,0 %) ','maxlength'=>'20','class' => 'form-control','id'=>'lab_mgra')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Prueba de Alcohol:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    <select class="form-control" id="lab_palc" name="lab_palc">
                                                        <option disabled selected>--Seleccione--</option>
                                                        <option value="1">+</option>
                                                        <option value="2">-</option> 
                                                   </select>

                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                             <div class="col-sm-12">
                                                <label>
                                                    Prueba antibiotico:
                                                </label>
                                                <select class="form-control" id="lab_pant" name="lab_pant">
                                                    <option disabled selected>--Seleccione--</option>
                                                    <option value="1">+</option>
                                                    <option value="2">-</option> 
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                                <!--PARAMETROS ORGANOLEPTICOS-->
                                <CENTER><h4 style="color:#191970">PARAMETROS ORGANOLÉPTICOS LABORATORIO</h4></CENTER>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label> Aspecto:    </label>
                                                <select class="form-control" id="lab_asp" name="lab_asp">
                                                    <option disabled selected>--Seleccione--</option>
                                                    <option value="1">Liquido</option>
                                                    <option value="2">Homogeneo</option> 
                                                </select>   
                                            </div>
                                        </div>
                                    </div>                   
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label> Color:  </label>
                                                <div class="controls">
                                                    <select class="form-control" id="lab_col" name="lab_col">
                                                        <option disabled selected>--Seleccione--</option>
                                                        <option value="1">Blanco Opaco</option>
                                                        <option value="2">Blanco Cremoso</option>   
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>   Olor:  </label>
                                                    <select class="form-control" id="lab_olo" name="lab_olo">
                                                        <option disabled selected>--Seleccione--</option>
                                                        <option value="1">SI</option>
                                                        <option value="2">NO</option>   
                                                    </select>
                                            </div>
                                        </div>
                                    </div>    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label> ** Sabor:  </label>
                                                    <select class="form-control" id="lab_sab" name="lab_sab">
                                                        <option disabled selected>--Seleccione--</option>
                                                        <option value="1">Poco Dulce</option>
                                                        <option value="2">Agradable</option>   
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
            <center>
            </center>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" style="background:#8A0829" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registroaco','class'=>'btn btn-primary','style'=>'background:#243B0B'], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.css">
<script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
<script src="https://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.js"></script>

<script type="text/javascript">
$('.clockpicker').clockpicker();
</script>

<style type="text/css">
.popover.clockpicker-popover {
     z-index : 1050 ;
}
</style>