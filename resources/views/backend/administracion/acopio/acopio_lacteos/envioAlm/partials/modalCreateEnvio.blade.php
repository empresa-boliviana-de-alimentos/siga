
<div class="modal fade bs-example-modal-sm in" data-backdrop="static" data-keyboard="false" id="myCreateEnvioAlm" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    ×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    ENVIO DE MATERIA PRIMA - ALMACEN
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                    <?php $now = new \DateTime('America/La_Paz'); ?>
                        {!! Form::open(['id'=>'envioalm'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <!--<input id="id" name="id_proveedor" type="" value="">-->
                                <div class="row">
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Cantidad total de Envio:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('enval_cant_total', $datos->cantidad_total, array('placeholder' => '0','maxlength'=>'40','class' => 'form-control','id'=>'enval_cant_total','onkeyup'=>'javascript:this.value=this.value.toUpperCase();','readonly','onkeyup'=>'totacopio()')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                     Costo Unitario:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('enval_cost_uni',$cantuni,array('placeholder' => '','maxlength'=>'15','class' => 'form-control','id'=>'enval_cost_uni','onkeyup'=>'javascript:this.value=this.value.toUpperCase();','onkeyup'=>'totacopio()', 'readonly')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                     Costo total de Envio:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('enval_cost_total', $tot,array('placeholder' => '','maxlength'=>'15','class' => 'form-control','id'=>'enval_cost_total','onkeyup'=>'javascript:this.value=this.value.toUpperCase();','readonly','onkeyup'=>'totacopio()')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Fecha de Envio:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('enval_registro', $now->format('d-m-Y'), array('placeholder' => 'Fecha y Hora ', 'class'=>'form-control','maxlength'=>'40','id'=>'enval_registro', 'readonly' => 'readonly')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Planta:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('enval_cost_total', $nomplant,array('placeholder' => 'Ingrese Apellido Paterno','maxlength'=>'15','class' => 'form-control','id'=>'enval_cost_total','onkeyup'=>'javascript:this.value=this.value.toUpperCase();','readonly')) !!}
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
                <button class="btn btn-danger" data-dismiss="modal" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='ENVIAR', $attributes=['id'=>'envioAlm','class'=>'btn btn-primary','style'=>'background:#57BC90'], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

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

    var cant= document.getElementById("enval_cant_total").value;
    console.log(cant);
    var costo= document.getElementById("enval_cost_uni").value;
    console.log(costo);
    //PLUS
    var total =  cant * costo;
 

    var totalplusporc =  number_format(total,2,'.','');
    document.getElementById("enval_cost_total").value= totalplusporc;
    
  }




    
</script>
@endpush
