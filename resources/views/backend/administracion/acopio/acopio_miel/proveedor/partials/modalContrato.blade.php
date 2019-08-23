<div class="modal fade bs-example-modal-sm in" data-backdrop="static" data-keyboard="false" id="myContrato" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    ×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Agregar nuevo contrato
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                        {!! Form::open(['id'=>'contrato'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                         <input id="idProvContrato1" name="prsid1" type="hidden" value="">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                Datos del proveedor
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('nombre_proveedor', null, array('placeholder' => 'Nombres del proveedor','maxlength'=>'10','class' => 'form-control','id'=>'nombre_proveedor', 'readonly')) !!}
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
                                                Nro de Contrato:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('nro_contrato_prov', null, array('placeholder' => 'Nro de Contrato ','maxlength'=>'20','class' => 'form-control','id'=>'nro_contrato_prov')) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>  
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                Precio de Contrato:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::number('precio_contrato', null, array('placeholder' => 'Precio de Contrato','maxlength'=>'50','class' => 'form-control','id'=>'precio_contrato', 'onkeyup'=>"totacuota()", 'min'=>"0.01", 'step'=>"0.01", 'placeholder'=>"0.00")) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                Precio de cuotas:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('precio_cuotas', null, array('placeholder' => 'Precio de cuotas a pagar', 'class' => 'form-control','id'=>'precio_cuotas', 'readonly','onkeyup'=>"totacuota()", 'min'=>"0.01", 'step'=>"0.01", 'placeholder'=>"0.00")) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>        
                            
                        </input>
                    </hr>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Agregar Contrato', $attributes=['id'=>'registroContrato','class'=>'btn btn-primary','style'=>'background:#57BC90'], $secure=null)!!}
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
  
   function totacuota(){

    var precio_contrato= document.getElementById("precio_contrato").value;
    var precio_cuotas = precio_contrato/7;
    console.log('cuota: '+precio_cuotas);
    var precio_cuotas1 =  number_format(precio_cuotas,2,'.','');
    document.getElementById("precio_cuotas").value= precio_cuotas1;
    
  }
</script>
@endpush

                        

