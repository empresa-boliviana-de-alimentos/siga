<div class="modal fade modal-fade-in-scale-up" data-backdrop="static" data-keyboard="false" id="myCreateLAB" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    X
                </button>
                <h4 class="modal-title" id="modalLabelfade">
                    <center>REGISTRO ACOPIO LABORATORIO</center>
                </h4>
            </div> 
            <div class="modal-body">
                <div class="caption">
                       {!! Form::open(['id'=>'acopio'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="dac_id1" name="dac_id1" type="hidden" value="">
                            {{-- <input id="idtipofru" name="idtipofru" type="hidden" value=""> --}}
                            <input id="idfruta" name="idfruta" type="hidden" value="">
                            <input id="prov_id1" name="prov_id1" type="hidden" value="">
                            <label> <strong> DATOS PRODUCTOR </strong></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-sm-12">
                                            <label>Nombre: </label>  
                                             <br>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('nombre', null, array('placeholder' => '','maxlength'=>'50','class' => 'form-control','id'=>'nombre', 'disabled'=>'true')) !!}
                                            </span>          
                                        </div>
                                    </div>
                                 {{--    <div class="col-md-6">
                                        <div class="col-sm-12">
                                            <label>Sindicato: </label>  
                                             <br>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('nombre', null, array('placeholder' => '','maxlength'=>'50','class' => 'form-control','id'=>'nombre')) !!}
                                            </span>          
                                        </div>
                                    </div> --}}
                                    <div class="col-md-4">
                                        <div class="col-sm-12">
                                            <label>Estado: </label>  
                                            <br>
                                            <select class="form-control" id="estadofru" name="estadofru" required>
                                                <option>Seleccione...</option>
                                                <option value="1">Aceptado</option>
                                                <option value="2">Rechazado</option> 
                                            </select>           
                                        </div>
                                    </div>
                                </div>        
                                <br>
                                 <strong><center><h4 class="modal-title" style="color:#191970">DATOS TRANSPORTE</h4></center></strong>    
                                <br>   
                                    <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Nombre Chofer:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('aco_nomchofer', null, array('placeholder' => 'Ingrese nombre del chofer ','maxlength'=>'20','class' => 'form-control','id'=>'aco_nomchofer','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                   {{--   <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    C.I.:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('aco_placa', null, array('placeholder' => 'Ingrese C.I. ','maxlength'=>'20','class' => 'form-control','id'=>'aco_placa',)) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Tipo de vehiculo:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('aco_placa', null, array('placeholder' => 'Tipo de vehiculo','maxlength'=>'20','class' => 'form-control','id'=>'aco_placa')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    N° Placa:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('aco_placa', null, array('placeholder' => 'Ingrese el N° placa ','maxlength'=>'20','class' => 'form-control','id'=>'aco_placa','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>   
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label> Obj. Extraños:  </label>
                                                    <select class="form-control" id="aco_extrañosfru" name="aco_extrañosfru">
                                                        <option>--Seleccione--</option>
                                                        <option value="1">SI</option>
                                                        <option value="2">NO</option>   
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label> Olores Extraños:  </label>
                                                    <select class="form-control" id="aco_olor" name="aco_olor">
                                                        <option>--Seleccione--</option>
                                                        <option value="1">SI</option>
                                                        <option value="2">NO</option>   
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label> Libre de Infestacion:  </label>
                                                    <select class="form-control" id="aco_infestfru" name="aco_infestfru">
                                                        <option>--Seleccione--</option>
                                                        <option value="1">SI</option>
                                                        <option value="2">NO</option>   
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <strong><center><h4 class="modal-title" style="color:#191970">DATOS ACOPIO</h4></center></strong>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label> Lote: </label>
                                                <span class="block input-icon input-icon-right">
                                                {!! Form::text('lote', null, array('placeholder' => '','maxlength'=>'50','class' => 'form-control','id'=>'lote','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>                   
                                 {{--    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label> Cant. Aprob.:  </label>
                                                <span class="block input-icon input-icon-right">
                                                {!! Form::number('cant_aprob', null, array('placeholder' => '','maxlength'=>'50','class' => 'form-control','id'=>'cant_aprob', 'disabled'=>'true')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div> --}}
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Cant. Aprox.:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                  {!! Form::number('aco_fru_mues', null, array('placeholder' => '','maxlength'=>'20','class' => 'form-control','id'=>'aco_fru_acep')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Cant. Muestra:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                  {!! Form::number('aco_fru_mues', null, array('placeholder' => 'Muestra','maxlength'=>'20','class' => 'form-control','id'=>'aco_fru_mues')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div> 
                                     <div class="col-md-3">
                                        <div class="col-sm-12">
                                            <label>Tipo de Fruta:   </label>
                                            <select class="form-control" id="idtipofru" name="idtipofru" onchange="muestrafruta();">
                                                <option>Seleccione...</option>
                                                  @foreach($fruta as $fru)
                                                    <option value="{{$fru->tipfr_id}}">{{$fru->tipfr_nombre}}</option>
                                                  @endforeach
                                            </select>
                                        </div>
                                    </div> 
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Variedad:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                  {!! Form::text('Variedad', null, array('placeholder' => 'Ingrese Variedad','maxlength'=>'20','class' => 'form-control','id'=>'Variedad','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                 <br>
                               <strong><center><h4 class="modal-title" style="color:#191970">PARAMETROS FISICO-QUIMICOS</h4></center></strong>    
                                <br>   
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Acidez(%):
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                 <!--<input id="n_tem" name="n_tem" type="text" placeholder="(°c)">-->
                                                  {!! Form::number('acidez', null, array('placeholder' => '(°c)','maxlength'=>'20','class' => 'form-control','id'=>'acidez')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    PH:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('ph', null, array('placeholder' => '','maxlength'=>'20','class' => 'form-control','id'=>'ph')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Grados Brix:
                                                </label>
                                               <span class="block input-icon input-icon-right">
                                                    {!! Form::number('brix', null, array('placeholder' => '(6,6 -6,8) ','maxlength'=>'20','class' => 'form-control','id'=>'brix')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Grado Madurez:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('madurez', null, array('placeholder' => '(9,2 minimo %) ','maxlength'=>'20','class' => 'form-control','id'=>'madurez')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Relacion Uds/Kg:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('rel', null, array('placeholder' => '(0,13 -0,18 % a.l.) ','maxlength'=>'20','class' => 'form-control','id'=>'rel')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>                            
                                </div>
                                <br>
                                <strong><center><h4 class="modal-title" style="color:#191970">PARAMETROS ORGANOLEPTICOS</h4></center></strong>
                                 <br>
                                <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label> Homogeneidad:    </label>
                                                    <select class="form-control" id="asp" name="asp">
                                                        <option>Seleccione...</option>
                                                        <option value="1">Si</option>
                                                        <option value="2">No</option> 
                                                    </select>   
                                                </div>
                                            </div>
                                        </div>                   
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label> Color:  </label>
                                                    <div class="controls">
                                                         {{-- <span class="block input-icon input-icon-right">
                                                            {!! Form::text('color', null, array('placeholder' => '','maxlength'=>'20','class' => 'form-control','id'=>'color')) !!}
                                                         </span> --}}
                                                        <select class="form-control" id="color" name="color">
                                                            <option>Seleccione...</option>
                                                            <option value="1">Si</option>
                                                            <option value="2">No</option> 
                                                        </select>   

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>   Olor:  </label>
                                                        <select class="form-control" id="olor" name="olor">
                                                            <option>Seleccione...</option>
                                                            <option value="1">SI</option>
                                                            <option value="2">NO</option>   
                                                        </select>
                                                </div>
                                            </div>
                                        </div>    
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label> Sabor:  </label>
                                                        <select class="form-control" id="sabor" name="sabor">
                                                            <option>Seleccione...</option>
                                                            <option value="1">POCO DULCE</option>
                                                            <option value="2">AGRADABLE</option>   
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                               {{--          <div id="datoaddcomp1" style="display: none;">
                                        <div class="col-md-3">
                                            <div class="col-sm-12">
                                                <label>Cant. min. Zumo:    </label>
                                                 <br>
                                                    <span class="block input-icon input-icon-right">
                                                        {!! Form::number('minzumo', null, array('placeholder' => '30% - 40%','maxlength'=>'50','class' => 'form-control','id'=>'minzumo')) !!}
                                                    </span>
                                            </div>
                                        </div>
                                        </div> --}}
                                        <div id="datoaddpiña" style="display: none;">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label> Categoria:  </label>
                                                        <select class="form-control" id="categoria" name="categoria">
                                                           <option disabled selected>--Seleccione--</option>
                                                            <option value="1">CATEGORIA I</option>
                                                            <option value="2">CATEGORIA II</option> 
                                                            <option value="2">EXTRA</option>   
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                </div>
                               <br>
                                <strong><center><h4 class="modal-title" style="color:#191970">CALIBRE PROMEDIO</h4></center></strong>
                                 <br>
                                <div class="row">
                                    <div id="datoaddpiña" style="display: none;">
                                    <div class="col-md-3">
                                        <div class="col-sm-12">
                                            <label>  Codigo Calibre:    </label>
                                            <select class="form-control" id="cod_calibre" name="cod_calibre" onchange="Mostrarcalibre();">
                                                <option>Seleccione...</option>
                                                @foreach($calibre as $cal)
                                                    <option value="{{$cal->calibre_id}}">{{$cal->codigo}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="col-sm-12">
                                            <label class="form-check-label" for="defaultCheck1">
                                                Peso Medio(+/-12%)gr
                                            </label> 
                                            <div id="valor">
                                              <label class="form-check-label" for="defaultCheck1">
                                                Con Corona
                                              </label>
                                                <input class="form-check-input" type="radio" value="" id="corona" onchange="Pesovalor1()" name="corona">
                                                <input class="form-check-input" type="text" value="" id="corona1" name="corona" style="width :65px;" disabled>
                                              <label class="form-check-label" for="defaultCheck2">
                                                Sin Corona
                                              </label>  
                                              <input class="form-check-input" type="radio" value="" id="sincorona" onchange="Pesovalor1()" name="corona">
                                               <input class="form-check-input" type="text" value="" id="sincorona1" name="sincorona" style="width :65px;" disabled>
                                            </div>
                                              
                                        </div>
                                    </div>
                                     {{-- <div class="col-md-2">
                                        <div class="col-sm-12">   
                                              <label class="form-check-label" for="defaultCheck2">
                                                Sin Corona
                                              </label>  
                                              <input class="form-check-input" type="checkbox" value="" id="defaultCheck2">
                                        </div>
                                    </div> --}}
                                   {{--  <div class="col-md-3">
                                        <div class="col-sm-12">
                                            <label>  Corona:    </label>
                                            <select class="form-control" id="corona1" name="corona1" onchange="Pesovalor();">
                                                        <option>Seleccione...</option>
                                                        <option value="1">CORONA</option>
                                                        <option value="2">SIN CORONA</option>
                                            </select>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="col-sm-12">
                                            <label>  Peso Medio(+/-12%)gr:    </label>
                                             <br>
                                               <span class="block input-icon input-icon-right">
                                                    {!! Form::text('dm', null, array('placeholder' => '','maxlength'=>'50','class' => 'form-control','id'=>'dm','disabled'=>'true')) !!}
                                                </span>
                                        </div>
                                    </div> --}}
                                    </div>
                                    <div class="col-md-2">
                                        <div class="col-sm-12">
                                            <label>  Diametro (cm):    </label>
                                             <br>
                                               <span class="block input-icon input-icon-right">
                                                    {!! Form::number('dm', null, array('placeholder' => 'Diametro','maxlength'=>'50','class' => 'form-control','id'=>'dm')) !!}
                                                </span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="col-sm-12">
                                            <label>  Longitud (cm):    </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::number('long', null, array('placeholder' => 'Longitud','maxlength'=>'50','class' => 'form-control','id'=>'long')) !!}
                                            </span>
                                        </div>
                                    </div>
                                    <div id="datoaddcomp" style="display: none;">
                                    <div class="col-md-2">
                                        <div class="col-sm-12">
                                            <label>  Tamaño (mm):    </label>
                                             <br>
                                               <span class="block input-icon input-icon-right">
                                                    {!! Form::number('tam', null, array('placeholder' => 'Tamaño','maxlength'=>'50','class' => 'form-control','id'=>'tam')) !!}
                                                </span>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Responsable de Calidad:
                                                </label>
                                               {{--  <span class="block input-icon input-icon-right">
                                                {!! Form::text('resp', null, array('placeholder' => '{{  }}','maxlength'=>'50','class' => 'form-control','id'=>'resp')) !!}
                                                </span> --}}
                                                <input type="text" class="form-control" name="resp" id="resp" placeholder="{{$per->prs_nombres}} {{$per->prs_paterno}} {{$per->prs_materno}}" disabled="true">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                {{-- </div> --}}
                                <div class="row">    
                                    <div class="col-md-8">
                                        <div class="col-sm-12">
                                            <label>
                                                Observaciones:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                 {!! Form::textarea('obs', null, array('placeholder' => 'Ingrese Obs','maxlength'=>'50','class' => 'form-control','id'=>'obs', 'rows'=>'2','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
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
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registro','class'=>'btn btn-success','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
