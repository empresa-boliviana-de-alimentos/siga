<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myCreatePre" tabindex="-5">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel">
                    Asignar Presupuesto
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                    <hr>
                        {!! Form::open(['id'=>'proveedor'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="sol_id1" name="sol_id1" type="hidden" value="">
                             <input id="sol_fecha_reg1" name="sol_fecha_reg1" type="hidden" value="">
                             <input id="sol_monto1" name="sol_monto1" type="hidden" value="">
                             <input id="sol_id_usr1" name="sol_id_usr1" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Comprador:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('sol_nombre', null, array('placeholder' => '','maxlength'=>'150','class' => 'form-control','id'=>'sol_nombre','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
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
                                                    Monto:
                                                </label>
                                                {!! Form::text('asig_monto', null, array('placeholder' => '0.0','maxlength'=>'150','class' => 'form-control','id'=>'asig_monto')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Fecha de Desembolso:
                                                </label> 
                                                <span class="block input-icon input-icon-right">
                                                    <div class="input-group">
                                                        <input class="form-control datepicker" id="asig_fecha" name="asig_fecha" type="text" value="">
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
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Observacion:
                                                </label>
                                                {!! Form::text('asig_obs', null, array('placeholder' => '','maxlength'=>'150','class' => 'form-control','id'=>'asig_obs','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
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
                    Cancelar
                </button>
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registroAsignacion','class'=>'btn btn-primary','style'=>'background:#57BC90'], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function (e) {
             $('#myModalPres').on('show.bs.modal', function(e) {    
               var id = $(e.relatedTarget).data().id;
                 $(e.currentTarget).find('#idcmp').val(id);

               var id2 = $(e.relatedTarget).data().id2;
                 $(e.currentTarget).find('#nomcmp').val(id2);  

               var id3 = $(e.relatedTarget).data().id3;
                 $(e.currentTarget).find('#idsolip').val(id3);  

               var id4 = $(e.relatedTarget).data().id4;
                 $(e.currentTarget).find('#montosoli').val(id4);  

               
             });
           });

function mayor(sol_monto1){
var varjs=asig_monto;
if(sol_monto1>varjs)
{
alert(amount + " es mayor que " + varjs)
}}


var micampo = document.getElementById('asig_monto').value
console.log(micampo);
if(micampo <= 0 ){
   alert('No se permiten valores iguales a cero');
   return;
}else if(micampo != 0 ){
   if(!isNaN(parseInt(micampo))){
    alert('numero Positivo distinto a cero. Gracias');
    document.forms[0].submit();
  }
}  
</script>