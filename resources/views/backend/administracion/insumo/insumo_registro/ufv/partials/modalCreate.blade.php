<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myCreateUfv" tabindex="-5">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel">
                    Registro UFV Insumo 
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                        {!! Form::open(['id'=>'proveedor'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id" name="provid" type="hidden" value="">
                                <div class="row"> 
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Fecha:
                                                </label>
                                                <?php  
                                                        date_default_timezone_set('America/New_York');
                                                        echo  date('m/d/Y');
                                                ?>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    UFV:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('cantidad', null, array('placeholder' => 'Ingrese UFV','class' => 'form-control','id'=>'cantidad')) !!}
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
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registroUfv','class'=>'btn btn-success','style'=>''], $secure=null)!!}
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

 

