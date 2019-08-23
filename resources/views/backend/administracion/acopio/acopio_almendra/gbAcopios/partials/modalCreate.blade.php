<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myCreate" tabindex="-5">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel">
                    ACOPIO NRO: <span id="aconumaconuevo"></span>, PROVEEDOR: <span id="nombre_prov"></span>
                </h4>
            </div>
            <div class="modal-body" background-color="#f3f7f9">
                <div class="caption">
                        {!! Form::open(['id'=>'acopio'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id_prov" name="id_proveedor" type="hidden" value="">
				<center><b>Monto Actual que puede utilizar Bs.- {{ $total3 }}</b></center><br>
                            	<input type="hidden" name="montoActual" id="montoActual" value="{{ $total3 }}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Centro de Acopio:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('centro_acopio', null, array('placeholder' => 'Ingrese el Centro de Acopio','maxlength'=>'20','class' => 'form-control','id'=>'centro_acopio','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nro. Recibo:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('nro_recibo', null, array('placeholder' => 'Ingrese Nro. Recibo','min'=>'0','class' => 'form-control','id'=>'nro_recibo')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Peso Neto Kg:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('peso_neto', null, array('placeholder' => 'Ingrese Peso Neto','min'=>'0.01', 'step'=>'0.01', 'placeholder'=>'0.00','class' => 'form-control','id'=>'peso_neto')) !!}
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
                                                    Tipo de Castaña
                                                </label>
                                                <select class="form-control" id="id_tipo" name="id_tipo" placeholder="Ingrese Expedido" value="">
                                                   <option>Seleccione..</option>
                                                   @foreach($dataTipo as $tip)
                                                    <option value="{{$tip->tca_id}}">{{$tip->tca_nombre}}</option>
                                                   @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                   Cantidad:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                   <input class="form-control" name="cantidad" type="number" id="cantidad" onkeyup="totacopio()" min="0.01" step="0.01" placeholder="0.00" />
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Unidad:
                                                </label> 
                                                <select class="form-control" id="id_unidad" name="id_unidad" placeholder="Ingrese Expedido" value="">
                                                    <option>Seleccione..</option>
                                                    @foreach($dataUni as $uni)
                                                     <option value="{{$uni->uni_id}}">{{$uni->uni_nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                   Costo:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                   <input class="form-control" name="costo" type="text" id="costo" onkeyup="totacopio()" min="0.01" step="0.01" placeholder="0.00"/>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
					<div id="aco_plus_ocul" style="display: none;">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label style="color: blue">
                                                        Porcentaje del Plus
                                                    </label>
                                                    <span class="block input-icon input-icon-right">
                                                        <input type="number" class="form-control" step="any" name="aco_plus" id="aco_plus"  value="0" onkeyup="totacopio()" style="color: blue">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
				    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Total:
                                                </label> 
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('total', null, array('placeholder' => '0.01','maxlength'=>'15','class' => 'form-control', 'id'=>'total')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Lugar de Compra:
                                                </label> 
                                                <select class="form-control" id="id_lugar" name="id_lugar" placeholder="Ingrese Expedido" value="">
                                                    <option>Seleccione..</option>
                                                     @foreach($dataLugar as $lug)
                                                       <option value="{{$lug->proc_id}}">{{$lug->proc_nombre}}</option>
                                                     @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Comunidad:
                                                </label> 
                                                <select class="form-control" id="id_comunidad" name="id_comunidad" placeholder="Ingrese Expedido" value="" style="width: 100%">
                                                   
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <br>
                                                <label class="col-sm-6 col-form-label">
                                                    Nueva Comunidad...
                                                </label>
                                                <i href="#" class="btn btn-default" role="button" data-toggle="modal" data-target="#myCreateComunidad1"><span class="glyphicon glyphicon-plus-sign"></span></i> 
                                            </br>

                                        </div>
                                    </div> -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Observación:
                                                </label> 
                                                <input class="form-control" rows="3" id="observacion" onkeyup="javascript:this.value=this.value.toUpperCase();"></input>
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
                <button class="btn btn-default" data-dismiss="modal" style="background:#A5A5B2" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registroAcopio','class'=>'btn btn-primary','style'=>'background:#57BC90'], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>


     <!-- ******************* MODAL NUEVA COMUNIDAD *************************** -->

<div class="modal fade modal-primary" id="myCreateComunidad1" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Nueva Comunidad</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf-token" value="{{ csrf_token() }}" id="token">
                <div class="form-group">
                    {!!Form::label('Comunidad','Nombre de la Comunidad: ')!!}
                     {!! Form::text('res.com_comunidad1', null, array('placeholder' => 'Ingrese Nombre de la Comunidad','class' => 'form-control','id'=>'com_comunidad1','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                </div>
                <label>
                    Municipio:
                </label> 
                <select class="form-control" id="com_municipio1" name="com_municipio1" placeholder="" value="">
                    <option>Seleccione Municipio...</option>
                    @foreach($dataMuni as $muni)
                        <option value="{{$muni->mun_id}}">{{$muni->mun_nombre}}</option>
                    @endforeach
                </select>             
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registroComunidad','class'=>'btn btn-primary'], $secure=null)!!}         
            </div>
                        
        </div>
    </div>
</div>

</div>
<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
@push('scripts')
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

    var cant= document.getElementById("cantidad").value;
    console.log(cant);
    var costo= document.getElementById("costo").value;
    console.log(costo);
    var plus = document.getElementById("aco_plus").value;
    console.log(plus);
    //PLUS
    var total =  cant * costo;
    var totalporc = total * plus /100;
    var totalplus = total+totalporc;   
    // var total= number_format(cant*costo,2,'.','');
    console.log('plus: '+totalplus);
    var totalplusporc =  number_format(totalplus,2,'.','');
    document.getElementById("total").value= totalplusporc;
    
  }

 $('#id_comunidad').select2({
    dropdownParent: $('#myCreate'),
    placeholder: "Selec. Comunidad",
    comunidad: true,
    tokenSeparators: [','],
    ajax: {
        dataType: 'json',
        url: '{{ url("obtenerComunidad") }}',
        delay: 250,
        data: function(params) {
            return {
                term: params.term
            }
        },
        processResults: function (data, page) {
            return {
            results: data
            };
        },
    },
    language: "es",
  });

/******** PLUS *****************/
  $('#id_tipo').on('change',function(){
    if (document.getElementById("id_tipo").value == 1 ) {
     	$("#aco_plus_ocul").hide();
        // $("#aco_plus_ocul").show();
        document.getElementById("aco_plus").value = 0;
    } else if(document.getElementById("id_tipo").value == 2) {
        $("#aco_plus_ocul").hide();
        document.getElementById("aco_plus").value = 0;
    } else {
        $("#aco_plus_ocul").hide();
        document.getElementById("aco_plus").value = 0;
    }
  })
    
</script>
@endpush