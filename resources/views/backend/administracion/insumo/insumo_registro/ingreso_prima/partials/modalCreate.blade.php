<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myCreatePrima" tabindex="-5">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #202040">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    <span style="color: white">x</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Detalle Materia Prima 
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                        {!! Form::open(['id'=>'proveedor'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="envid" name="envid" type="hidden" value="">
                                <div class="row"> 
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Nombre:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('nombre_env', null, array('placeholder' => 'ANA CORTES','class' => 'form-control','id'=>'nombre_env', 'disabled'=>'true')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row"> 
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Cantidad Total:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('cant_env', null, array('placeholder' => '5000','class' => 'form-control','id'=>'cant_env', 'disabled'=>'true')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Insumo:
                                                </label>
                                                <select class="form-control" id="ins_id" name="ins_id" placeholder="" value="">
                                                    <!--<option value="">Seleccione...</option>-->
                                                    @foreach($combo as $cmb)
                                                    <option value="{{$cmb->ins_id}}">{{$cmb->ins_desc}}</option>
                                                    @endforeach
                                                </select> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Costo Unitario Enviado:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('costo_env', null, array('placeholder' => 'Costo Enviado','class' => 'form-control','id'=>'costo_env','readonly'=>'true')) !!}
                                                </span>   
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <br>
                                <div class="row"> 
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Cantidad Recibida:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('cantidad', null, array('placeholder' => 'Cantidad','class' => 'form-control','id'=>'cantidad')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Costo Unidad:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('costo', null, array('placeholder' => 'Costo','class' => 'form-control','id'=>'costo')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Observacion General (Justificante)
                                                </label>
                                                <textarea id="env_obs" class="form-control"></textarea>
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
                 {!!link_to('#',$title='Rechazar', $attributes=['id'=>'registroUfv','class'=>'btn btn-warning','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
                {!!link_to('#',$title='Aprobar', $attributes=['id'=>'registroMatAprob','class'=>'btn btn-success','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// $(document).ready(function() {
//         $('#registroUfv').click(function() {
//             // Recargo la página
//             location.reload();
//         });
//     });
</script>
@endpush

 

