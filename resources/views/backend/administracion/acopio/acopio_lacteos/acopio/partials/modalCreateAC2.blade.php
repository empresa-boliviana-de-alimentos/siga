<div class="modal fade modal-fade-in-scale-up" data-backdrop="static" data-keyboard="false" id="myCreateAC" tabindex="-5" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    X
                </button>
                <h4 class="modal-title" id="modalLabelfade">
                    <center>REGISTRO ACOPIO LACTEOS CENTROS DE ACOPIO</center>
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">    
                        {!! Form::open(['id'=>'acopio'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id" name="prsid" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-sm-12">
                                            <label>  FECHA Y HORA:    </label>
                                            <br><br>
                                                <center> <label>
                                                    <?php  
                                                        date_default_timezone_set('America/New_York');
                                                        echo  date('m/d/Y g:ia');
                                                    ?>
                                                    
                                                </center></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-sm-12">
                                            <label>  PROVEEDOR:    </label>
                                            <select class="form-control" id="aco_prov" name="aco_prov">
                                              @foreach($data as $rol)
                                              <option value="{{$rol->id_proveedor}}">
                                                 {{$rol->nombres}}     {{$rol->apellido_paterno}}    {{$rol->apellido_materno}}
                                              </option>
                                               @endforeach
                                            </select>
                                        </div>
                                   </div>
                                </div>
                                <div class="row">
                                   <!-- <div class="col-md-4">
                                        <div class="col-sm-12">
                                            <label>  CANTIDAD (KG):    </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('aco_can1', null, array('placeholder' => 'Ingrese la cantidad en kg','maxlength'=>'20','class' => 'form-control','id'=>'n_can1')) !!}
                                            </span>
                                        </div>
                                    </div>  -->                             
                                    <div class="col-md-4">
                                        <div class="col-sm-12">
                                            <label>  CANTIDAD (LTS):    </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('aco_can', null, array('placeholder' => 'Ingrese la cantidad en Lt ','maxlength'=>'20','class' => 'form-control','id'=>'n_can')) !!}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-sm-12">
                                            <label>  TIPO DE ENVASE:    </label>
                                            <select class="form-control" id="aco_tenv" name="aco_env">
                                                        <option value="1">ALUMINIO</option>
                                                        <option value="2">PLASTICO</option> 
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div class="col-sm-12">
                                            <label>  Condiciones de Higiente:    </label>
                                            <select class="form-control" id="aco_cond" name="aco_cond">
                                                        <option value="1">Aceptable</option>
                                                        <option value="2">No Aceptable</option> 
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Encargado:
                                                    </label>
                                                    <select class="form-control" id="aco_enc" name="aco_enc">
                                                        @foreach($data as $rol2)
                                                        <option value="{{$rol->id_resp}}">
                                                           {{$rol2->nombre}}     {{$rol2->ap_paterno}}    {{$rol2->ap_materno}}
                                                        </option>
                                                       @endforeach
                                                    </select>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Cerificacion de Aceptacion:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    <select class="form-control" id="aco_apr" name="aco_apr">
                                                        <option value="1">Aceptado</option>
                                                        <option value="2">Rechazado</option>   
                                                    </select>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Observaciones:
                                                    </label>
                                                   <span class="block input-icon input-icon-right">
                                                        {!! Form::text('aco_obs', null, array('placeholder' => 'Ingrese Observaciones','maxlength'=>'50','class' => 'form-control','id'=>'aco_obs')) !!}
                                                    </span>
                                                </div>
                                        </div>
                                    </div>
                                </div>   
                            </input>
                        </input>
                  
                </div>
            </div>
            <center>
                <button class="button button-glow button-rounded button-success" data-target="#modalpfqAC" data-toggle="modal"  type="button">
                    Registrar Parametros Fisico Químico 
                </button>
                <button class="button button-glow button-rounded button-warning" data-target="#modalporAC" data-toggle="modal"  type="button">
                    Registrar Parametros Organolepticos
                </button>
            </center>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" style="background:#8A0829" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registro','class'=>'btn btn-primary','style'=>'background:#243B0B'], $secure=null)!!}
                {!! Form::close() !!}
            </div>


        </div>
    </div>
</div>

<div class="modal fade modal-fade-in-scale-up" id="modalpfqAC" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> X </button>
                    <h4 class="modal-title">PARAMETROS FÍSICOQUIMICOS</h4>
            </div>
            <div class="modal-body modal_long">
                <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">              
                    <input id="id1" name="id_propfq" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    TEMPERATURA:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                  {!! Form::text('n_tem', null, array('placeholder' => '(°c)','maxlength'=>'20','class' => 'form-control','id'=>'n_tem')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    SNG:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('n_sng', null, array('placeholder' => '(9,2 minimo %) ','maxlength'=>'20','class' => 'form-control','id'=>'n_sng')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    DENSIDAD:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('n_den', null, array('placeholder' => '(1,028-1,034 G/cC) ','maxlength'=>'20','class' => 'form-control','id'=>'n_den')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Prueba de Alcohol:
                                                </label>
                                                    <select class="form-control" id="n_palc" name="n_palc">
                                                        <option value="1">+</option>
                                                        <option value="2">-</option> 
                                                   </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </input>
                    </input>
                    <br>
                    <div class="form-group" align="center">
                         <button class="btn btn-danger" data-dismiss="modal" style="background:#8A0829" type="button">    Cerrar   </button>
                        {!!link_to('#',$title='Registrar', $attributes=['id'=>'registrofqpAC','class'=>'btn btn-responsive btn-success btn-sm'], $secure=null)!!}
                    </div>
        
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-fade-in-scale-up" id="modalporAC" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> X </button>
                    <h4 class="modal-title">PARAMETROS ORGANOLEPTICOS</h4>
            </div>
            <div class="modal-body modal_long">
                <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">              
                    <input id="id1" name="id_propor" type="hidden" value="">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label> Aspecto:    </label>
                                        <select class="form-control" id="n_asp" name="n_asp">
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
                                            <select class="form-control" id="n_col" name="n_col">
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
                                            <select class="form-control" id="n_olo" name="n_olo">
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
                                            <select class="form-control" id="n_sab" name="n_sab">
                                                <option value="1">Poco Dulce</option>
                                                <option value="2">Agradable</option>   
                                            </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" align="center">
                           <button class="btn btn-danger" data-dismiss="modal" style="background:#8A0829" type="button">    Cerrar   </button>
                           {!!link_to('#',$title='Registrar', $attributes=['id'=>'registropor','class'=>'btn btn-responsive btn-success btn-sm'], $secure=null)!!} 
                        </div>
           </div>  
        </div>
    </div>
</div>
