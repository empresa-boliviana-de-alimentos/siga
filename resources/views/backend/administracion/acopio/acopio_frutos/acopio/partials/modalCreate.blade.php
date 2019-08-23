<div class="modal fade modal-fade-in-scale-up" data-backdrop="static" data-keyboard="false" id="myCreateRepFruto" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    X
                </button>
                <h4 class="modal-title" id="modalLabelfade">
                    <center>REGISTRO ACOPIO FRUTOS POR PROVEEDOR</center>
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                       {!! Form::open(['id'=>'acopio'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="idaco" name="idaco" type="hidden" value="">
                            <input id="rau" name="rau" type="hidden" value="">
                            <input id="planta" name="planta" type="hidden" value="">
                            <input id="dep" name="dep" type="hidden" value="">
                            <input id="provincia" name="provincia" type="hidden" value="">
                            <input id="comunidad" name="comunidad" type="hidden" value="">
                            <input id="estadodec" name="estadodec" type="hidden" value="">
                            <input id="user" name="estadodec" type="hidden" value="{{$user}}">
                            <label> <strong>PROCEDENCIA</strong> </label> 
                                <div class="row">
                                    <div class="col-md-6">
                                         <div class="col-sm-12">
                                            <input id="cod_prov" name="cod_prov" type="hidden" value="">
                                            <label>Nombre Proveedor:</label>  
                                            <br>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('cod_nom', null, array('placeholder' => '','maxlength'=>'50','class' => 'form-control','id'=>'cod_nom', 'disabled'=>'true')) !!}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    C.I.:
                                                </label>
                                                 <span class="block input-icon input-icon-right">
                                                {!! Form::text('cod_ci', null, array('placeholder' => '','maxlength'=>'50','class' => 'form-control','id'=>'cod_ci', 'disabled'=>'true')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Cel.:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                {!! Form::text('cod_tel', null, array('placeholder' => '','maxlength'=>'50','class' => 'form-control','id'=>'cod_tel', 'disabled'=>'true')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Rau.:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                {!! Form::text('rau1', null, array('placeholder' => '','maxlength'=>'50','class' => 'form-control','id'=>'rau1', 'disabled'=>'true')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Departamento:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                {!! Form::text('nombre_dep', null, array('placeholder' => '','maxlength'=>'50','class' => 'form-control','id'=>'nomdep', 'disabled'=>'true')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Provincia:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                {!! Form::text('nombre_dep', null, array('placeholder' => '','maxlength'=>'50','class' => 'form-control','id'=>'provi_nom', 'disabled'=>'true')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Comunidad:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                {!! Form::text('nombre_dep', null, array('placeholder' => '','maxlength'=>'50','class' => 'form-control','id'=>'com_nombre', 'disabled'=>'true')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                 <label> <strong>DATOS TRANSPORTE</strong> </label> 
                                 {{-- <div id="datoaddotro" style="display: none;"> --}}
                                 <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label> Calibre:</label>
                                                <select class="form-control" id="aco_calibrefru" name="aco_calibrefru">
                                                    <option value="1">SI</option>
                                                    <option value="2">NO</option> 
                                                </select>   
                                            </div>
                                        </div>
                                    </div>                   
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label> Ramas Hojas:  </label>
                                                <div class="controls">
                                                    <select class="form-control" id="aco_ramhojafru" name="aco_ramhojafru">
                                                        <option value="1">SI</option>
                                                        <option value="2">NO</option>   
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label> Frut. Dañados:  </label>
                                                    <select class="form-control" id="aco_dañadosfru" name="aco_dañadosfru">
                                                        <option value="1">SI</option>
                                                        <option value="2">NO</option>   
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>   Frut.Infestados:  </label>
                                                    <select class="form-control" id="aco_infestfru" name="aco_infestfru" disabled="true">
                                                        <option value="1">SI</option>
                                                        <option value="2">NO</option>   
                                                    </select>
                                            </div>
                                        </div>
                                    </div>    
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label> Obj. Extraños:  </label>
                                                    <select class="form-control" id="aco_extrañosfru" name="aco_extrañosfru" disabled="true">
                                                        <option value="1">SI</option>
                                                        <option value="2">NO</option>   
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label> Olores Extraños:  </label>
                                                    <select class="form-control" id="aco_olor" name="aco_olor" disabled="true">
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
                                                    Nombre Chofer:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('aco_nomchofer', null, array('placeholder' => 'Ingrese nombre del chofer ','maxlength'=>'20', 'disabled'=>'true', 'class' => 'form-control','id'=>'aco_nomchofer','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    C.I.:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('aco_placa', null, array('placeholder' => 'Ingrese C.I. ','maxlength'=>'20','class' => 'form-control','id'=>'cichofer','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
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
                                                    {!! Form::text('aco_placa', null, array('placeholder' => 'Tipo de vehiculo','maxlength'=>'20','class' => 'form-control','id'=>'tipo_vehiculo','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    N° Placa:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('aco_placa', null, array('placeholder' => 'Ingrese el N° placa ','maxlength'=>'20','class' => 'form-control','id'=>'aco_placa', 'disabled'=>'true','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- </div> --}}
                                 <br>
                                <label> <strong>DATOS DE CARGA</strong> </label> 
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="col-sm-12">
                                            <label>  Fecha de llegada:    </label>
                                                <center> <label>
                                                    <?php  
                                                        date_default_timezone_set('America/New_York');
                                                        echo  date('m/d/Y g:ia');
                                                    ?>
                                                </center></label>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Fecha de Acopio:
                                                </label> 
                                                <span class="block input-icon input-icon-right">
                                                    <div class="input-group">
                                                        <input class="form-control datepicker" id="fecha_acopio" name="fecha_acopio" type="text" value="">
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
                                    <div class="col-md-3">
                                        <div class="col-sm-12">
                                            <label>Tipo de Fruta:   </label>
                                            <select class="form-control" id="aco_id_tipofru" name="aco_id_tipofru" disabled="true">
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
                                                    Lote:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                  {!! Form::text('aco_lotefru', null, array('placeholder' => 'Ingrese Lote','maxlength'=>'20','class' => 'form-control','id'=>'aco_lotefru', 'disabled'=>'true','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div> 
                                </div>       
                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Precio Unitario:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                  {!! Form::number('aco_preciofru', null, array('placeholder' => 'Ingrese Precio','maxlength'=>'20','class' => 'form-control','id'=>'aco_preciofru')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Cantidad Fruta Acop.:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                  {!! Form::number('aco_cant_uni', null, array('placeholder' => 'Ingrese Cantidad','maxlength'=>'20','class' => 'form-control','id'=>'aco_cant_uni', 'onkeyup'=>'totacopio()')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Peso Fruta Acop.:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                  {!! Form::number('aco_pesofru', null, array('placeholder' => 'Ingrese Peso','maxlength'=>'20','class' => 'form-control','id'=>'aco_pesofru', 'onkeyup'=>'totacopiopeso()')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Cantidad Fruta Descarte.:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                  {!! Form::number('aco_descartefru', null, array('placeholder' => 'Ingrese Cant. desc','maxlength'=>'20','class' => 'form-control','id'=>'aco_descartefru', 'onkeyup'=>'totacopio()')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Peso Fruta Descarte.:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                  {!! Form::number('aco_pesodescfru', null, array('placeholder' => 'Ingrese Peso desc','maxlength'=>'20','class' => 'form-control','id'=>'aco_pesodescfru', 'onkeyup'=>'totacopiopeso()')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                <strong><center><h4 class="modal-title" style="color:#191970">TOTALES</h4>  </center></strong>
                                <br>
                                <div class="row">
                                  {{--   <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Cantidad Recepcionada:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('aco_cant_uni1', null, array('placeholder' => 'Ingrese cant. Descarte','maxlength'=>'20','class' => 'form-control','id'=>'aco_cant_uni', 'onkeyup'=>'totacopio()')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Total Descarte:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('aco_descartefru1', null, array('placeholder' => 'Ingrese Descarte','maxlength'=>'20','class' => 'form-control','id'=>'aco_descartefru', 'onkeyup'=>'totacopio()')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Total Cantidad fruta Acopiado:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('total', null, array('placeholder' => '','maxlength'=>'20','class' => 'form-control','id'=>'total', 'disabled'=>'true')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Total Peso fruta Acopiado:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('totalpeso', null, array('placeholder' => '','maxlength'=>'20','class' => 'form-control','id'=>'totalpeso', 'disabled'=>'true')) !!}
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
            <div class="modal-footer">
                 <div id="estadoA" style="display: none;">
                    <button class="btn btn-danger" data-dismiss="modal" style="" type="button">
                    Cerrar
                    </button>
                    {!!link_to('#',$title='Registrar', $attributes=['id'=>'actualizar','class'=>'btn btn-success'], $secure=null)!!}
                    {!! Form::close() !!}
                </div>
                <div id="estadoC" style="display: none;">
                    <button class="btn btn-danger" data-dismiss="modal" style="" type="button">
                    Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
{{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}
<script type="text/javascript">  

    function number_format (number, decimals, dec_point, thousands_sep){
  
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? '' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function (n, prec) 
    {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
     if (s[0].length > 3) 
    {
      s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) 
    {
      s[1] = s[1] || '';
      s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
  }
  
   function totacopio(){

    var cant= document.getElementById("aco_cant_uni").value;
    console.log(cant);
    var descarte= document.getElementById("aco_descartefru").value;
    console.log(descarte);
    var total= (cant-descarte);
       
    document.getElementById("total").value= total;
    
  }

   function totacopiopeso(){

    var cantp= document.getElementById("aco_pesofru").value;
    console.log(cantp);
    var descartep= document.getElementById("aco_pesodescfru").value;
    console.log(descartep);
    var totalpeso= (cantp-descartep);
       
    document.getElementById("totalpeso").value= totalpeso;
    
  }

  
    
</script>
<script type="text/javascript">
    $('.datepicker').datepicker({
                format: "yyyy-mm-dd",
                language: "es",
                autoclose: true
            });
        
            var fecha= new Date();
            var vDia; 
            var vMes;

            if ((fecha.getMonth()+1) < 10) { vMes = "0" + (fecha.getMonth()+1); }
            else { vMes = (fecha.getMonth()+1); }

            if (fecha.getDate() < 10) { vDia = "0" + fecha.getDate(); }
            else{ vDia = fecha.getDate(); }
</script>
@endpush


