<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myCreateConfirmacionIngresoPv" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel">
                    CONFIRMAR INGRESO ALMACEN
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                        {!! Form::open(['id'=>'proveedor', 'files' => true])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id_planta_confirm" name="id_planta_confirm" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    PLANTA:
                                                </label>
                                                <input type="text" name="nombre_planta_confirm" id="nombre_planta_confirm" value="" class="form-control" readonly="true">
                                            </div>
                                        </div>
                                    </div>
                                   
                                    
                                </div>
                                <div class="row"> 
                                    <div class="col-md-12">                                                      
                                        <table id="lts-carritosol" class="table table-condensed" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">CODIGO</th>
                                                    <th class="text-center">PRODUCTO</th>
                                                    <th class="text-center">CANTIDAD</th>
                                                    <th class="text-center">COSTO U.</th>
                                                    <th class="text-center">SUBTOTAL</th>
                                                    <th class="text-center">LOTE</th>
                                                    <th class="text-center">FECHA VENC.</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>                                                           
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                Obseraciones:
                                            </label>
                                            <textarea class="form-control" name="soltras_obs" id="soltras_obs"></textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                <br>                                
                            </input>
                        </input>
                    </hr>
                </div>
            </div>       
            <div class="modal-footer">
                <button class="btn btn-danger" onclick="eliminarTodosModal()" data-dismiss="modal" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Enviar Solicitud', $attributes=['id'=>'registroSolTrasp','class'=>'btn btn-success','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    
</script>
@endpush