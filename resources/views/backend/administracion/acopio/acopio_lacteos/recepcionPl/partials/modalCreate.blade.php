<div class="modal fade modal-fade-in-scale-up" data-backdrop="static" data-keyboard="false" id="myCreateRecepcion" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    X
                </button>
                <h4 class="modal-title" id="modalLabelfade">
                    <center>REGISTRO RECEPCION ACOPIO LACTEOS POR MODULOS Y/O CENTROS DE ACOPIO</center>
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                       {!! Form::open(['id'=>'acopio'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id" name="prsid" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-8">
                                         <div class="col-sm-12">
                                            <label>  MODULO:</label>  
                                            <br>
                                            <input id="cod_prov2" name="cod_prov" type="hidden" value="">
                                            <input  type="text" class="form-control" id="cod_nom2" name="cod_nom" disabled="true">                                 
                                        </div>
                                    </div>
                                    <div class="col-md-4">
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
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="col-sm-12">
                                            <label>  Fecha :    </label>
                                                <center> <label>
                                                    <?php  
                                                        date_default_timezone_set('America/New_York');
                                                        echo  date('m/d/Y g:ia');
                                                    ?>
                                                </center></label>
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
                                            <label>  Cantidad (lts):    </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::number('aco_can', null, array('placeholder' => 'Ingrese Cantidad (Lts)','maxlength'=>'20','class' => 'form-control','id'=>'aco_can')) !!}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="col-sm-12">
                                            <label>  Cantidad Baldes:    </label>
                                                {!! Form::number('aco_can_baldes', null, array('placeholder' => 'Ingrese Cantidad (Lts)','maxlength'=>'20','class' => 'form-control','id'=>'aco_can_baldes')) !!}
                                        </div>
                                    </div>  
                                </div>       
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="col-sm-12">
                                            <label>  Tipo Envase:    </label>
                                                <select class="form-control" id="aco_tenv" name="aco_tenv">
                                                    <option disabled selected>--Seleccione--</option>
                                                    <option value="1">Aluminio</option>
                                                    <option value="2">Plastico</option> 
                                                    <option value="2">Cisterna</option> 
                                                </select>
                                        </div>
                                    </div>                                                      
                                    <div class="col-md-3">
                                        <div class="col-sm-12">
                                            <label>  Condiciones de Higiente:    </label>
                                            <select class="form-control" id="aco_cond" name="aco_cond">
                                                <option disabled selected>--Seleccione--</option>
                                                <option value="1">Aceptable</option>
                                                <option value="2">No Aceptable</option> 
                                            </select>
                                        </div>
                                    </div>
                                    <?php  
                                     if($turno->usr_id_turno==1)
                                     { 
                                        echo '<div class="col-md-3">';
                                        echo '<div class="col-sm-12">';
                                        echo ' <label>  Turno:    </label>';
                                        echo '<input type="text" id="" class="form-control" placeholder="Mañana" aria-label="Username" aria-describedby="basic-addon1" disabled="true">' ;
                                        echo '</div>';
                                        echo '</div>';
                                     }
                                     else
                                     {
                                       echo '<div class="col-md-3">';
                                        echo '<div class="col-sm-12">';
                                        echo ' <label>  Turno:    </label>';
                                        echo '<input type="text" class="form-control" placeholder="Tarde" aria-label="Username" aria-describedby="basic-addon1" disabled="true">' ;
                                        echo '</div>';
                                        echo '</div>';
                                     }
                                    ?> 
                                </div>  
                                <div class="row">
                                    <div class="col-md-12">
                                            <div class="col-sm-12">
                                                <label>
                                                    Observaciones:
                                                </label>
                                               <span class="block input-icon input-icon-right">
                                                    {!! Form::text('aco_obs', null, array('placeholder' => 'Ingrese Observaciones','maxlength'=>'50','class' => 'form-control','id'=>'aco_obs','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>
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
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registroModuloAco','class'=>'btn btn-success'], $secure=null)!!}
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



 