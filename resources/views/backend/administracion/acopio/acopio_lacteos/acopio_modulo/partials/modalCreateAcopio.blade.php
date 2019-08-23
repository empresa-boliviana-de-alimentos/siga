<div class="modal fade modal-fade-in-scale-up" data-backdrop="static" data-keyboard="false" id="myCreateRCAprov" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    X
                </button>
                <h4 class="modal-title" id="modalLabelfade">
                    <center>REGISTRO ACOPIO LACTEOS POR MODULOS Y/O CENTROS DE ACOPIO</center>
                </h4>
            </div>
            <?php date_default_timezone_set('America/New_York'); ?>
            <div class="modal-body">
                <div class="caption">
                       {!! Form::open(['id'=>'acopio'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id" name="prsid" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-7">
                                         <div class="col-sm-12">
                                            <label>  PROVEEDOR:</label>  
                                            <br>
                                            <input id="cod_prov" name="cod_prov" type="hidden" value="">
                                            <input id="cod_nom" name="cod_nom" disabled="true" class="form-control">
                                            <!-- <input id="cod_ap" name="cod_ap" disabled="true">
                                            <input id="cod_am" name="cod_am" disabled="true">   -->                               
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                         <div class="col-sm-12">
                                            <label>
                                                    Certificación de Aceptación:
                                                </label>
                                               <select class="form-control" id="aco_apr" name="aco_apr">
                                                    <option disabled selected>--Seleccione--</option>
                                                    <option value="1">Aceptado</option>
                                                    <option value="2">Rechazado</option> 
                                            </select>
                                            </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="col-sm-12">
                                            <label>  Cantidad (lts):    </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::number('aco_can', null, array('placeholder' => 'Ingrese Cantidad (Lts)','maxlength'=>'20','class' => 'form-control','id'=>'aco_can')) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="col-sm-12">
                                            <label>  Fecha :    </label>
                                                <center> <label>
                                                    <?php  
                                                        echo  date('Y/m/d g:ia');
                                                    ?>
                                                </center></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="col-sm-12">
                                            <label>
                                                Fecha Acopio
                                            </label>
                                            <input class="form-control datepicker" id="fecha_acopio" name="fecha_acopio" type="text" value="<?php echo date('Y-m-d');?>">
                                            </input> 
                                        </div>
                                    </div>
                                    <div class="col-md-3">                                
                                        <div class="col-sm-12">
                                            <label>  HORA:    </label>
                                           <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                                                <input type="text" class="form-control" value="" id="aco_hrs" placeholder="00:00">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-time"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="col-sm-12">
                                            <label>  Tipo Envase:    </label>
                                                <select class="form-control" id="aco_tenv" name="aco_tenv">
                                                    <option disabled selected>--Seleccione--</option>
                                                    <option value="1">Aluminio</option>
                                                    <option value="2">Plastico</option>
                                                    <option value="3">Cisterna</option> 
                                                </select>
                                        </div>
                                    </div>  
                                </div>       
                                <div class="row">
                                     <div class="col-md-8">
                                            <div class="col-sm-12">
                                                <label>
                                                    Observaciones:
                                                </label>
                                               <span class="block input-icon input-icon-right">
                                                    {!! Form::text('aco_obs', null, array('placeholder' => 'Ingrese Observaciones','maxlength'=>'50','class' => 'form-control','id'=>'aco_obs','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>
                                            </div>
                                    </div>                        
                                    <div class="col-md-4">
                                        <div class="col-sm-12">
                                            <label>  Condiciones de Higiente:    </label>
                                            <select class="form-control" id="aco_cond" name="aco_cond">
                                                <option disabled selected>--Seleccione--</option>
                                                <option value="1">Aceptable</option>
                                                <option value="2">No Aceptable</option> 
                                            </select>
                                        </div>
                                    </div>
                                </div>  
                               {{--  <strong><center><h4 class="modal-title" style="color:#191970">PARAMETROS FÍSICOQUIMICOS</h4>  </center></strong>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    TEMPERATURA:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                  {!! Form::number('aco_tem', null, array('placeholder' => '(°c)','maxlength'=>'20','class' => 'form-control','id'=>'aco_tem')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    SNG:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('aco_sng', null, array('placeholder' => '(9.2 minimo %) ','maxlength'=>'20','class' => 'form-control','id'=>'aco_sng')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Prueba de Alcohol:
                                                </label>
                                                <select class="form-control" id="aco_palc" name="aco_palc">
                                                    <option disabled selected>--Seleccione--</option>
                                                    <option value="1">+</option>
                                                    <option value="2">-</option> 
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <br>
                               <strong><center> <h4 class="modal-title" style="color:#191970">PARAMETROS ORGANOLEPTICOS</h4> </center></strong>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label> Aspecto:    </label>
                                                <select class="form-control" id="aco_asp" name="aco_asp">
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
                                                    <select class="form-control" id="aco_col" name="aco_col">
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
                                                    <select class="form-control" id="aco_olo" name="aco_olo">
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
                                                    <select class="form-control" id="aco_sab" name="aco_sab">
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
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" style="background:#8A0829" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registroAco','class'=>'btn btn-primary','style'=>'background:#243B0B'], $secure=null)!!}
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



