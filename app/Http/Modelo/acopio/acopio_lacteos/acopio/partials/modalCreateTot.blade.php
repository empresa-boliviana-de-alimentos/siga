<div class="modal fade modal-fade-in-scale-up" data-backdrop="static" data-keyboard="false" id="myCreateRTOT" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    X
                </button>
                <h4 class="modal-title" id="modalLabelfade">
                    <center>DATOS DE ACOPIO DIARIO</center>
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                      
                      <center> <label>  Revise los datos antes del envio de Acopio General !!!!!!</label></center>
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id" name="prsid" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-8">
                                         <div class="col-sm-12">
                                            <label>  RECEPCIONISTA CENTRO DE ACOPIO: </label>  
                                            <input id="cod_usu" name="cod_usu" type="hidden" value="">
                                            <span class="hidden-xs">   {{ Auth::user()->usr_usuario}}   </span>               
                                        </div>
                                    </div>
                                   
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="col-sm-12">
                                            <label>  Fecha y Hora:    </label>
                                                <center> <label>
                                                    <?php  
                                                        date_default_timezone_set('America/New_York');
                                                        echo  date('m/d/Y g:ia');
                                                    ?>
                                                </center></label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-sm-12">
                                            <label>  Cantidad Total de Proveedores:    </label>
                                            <input id="cant_prov1" name="cant_prov1" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-sm-12">
                                            <label>  Cantidad Total (lts):    </label>
                                           <input id="cant_lech1" name="cant_lech1"  >
                                        </div>
                                    </div>
                                     
                                </div>       
                                <div class="row">
                                     <div class="col-md-12">
                                            <div class="col-sm-12">
                                                <label>
                                                    Observaciones:
                                                </label>
                                               <span class="block input-icon input-icon-right">
                                                    {!! Form::text('acog_obs', null, array('placeholder' => 'Ingrese Municipio','maxlength'=>'50','class' => 'form-control','id'=>'acog_obs')) !!}
                                                </span>
                                            </div>
                                    </div>                        
                                </div>  
                                <strong><center><h4 class="modal-title" style="color:#191970">PARAMETROS FÍSICOQUIMICOS GENERALES</h4>  </center></strong>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    TEMPERATURA:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                  {!! Form::text('acog_tem', null, array('placeholder' => '(°c)','maxlength'=>'20','class' => 'form-control','id'=>'acog_tem')) !!}
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
                                                    {!! Form::text('acog_sng', null, array('placeholder' => '(9,2 minimo %) ','maxlength'=>'20','class' => 'form-control','id'=>'acog_sng')) !!}
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
                                                <select class="form-control" id="acog_palc" name="acog_palc">
                                                    <option value="1">+</option>
                                                    <option value="2">-</option> 
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               <strong><center> <h4 class="modal-title" style="color:#191970">PARAMETROS ORGANOLEPTICOS GENERALES</h4> </center></strong>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label> Aspecto:    </label>
                                                <select class="form-control" id="acog_asp" name="acog_asp">
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
                                                    <select class="form-control" id="acog_col" name="acog_col">
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
                                                <select class="form-control" id="acog_olo" name="acog_olo">
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
                                                <select class="form-control" id="acog_sab" name="acog_sab">
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
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registroG','class'=>'btn btn-primary','style'=>'background:#243B0B'], $secure=null)!!}
              
            </div>
        </div>
    </div>
</div>


