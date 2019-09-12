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
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    FECHA INGRESO:
                                                </label>
                                                <span class="form-control" readonly>{{date('d-m-Y')}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    COSTO TOTAL:
                                                </label>
                                                <input type="text" name="costo_total" id="costo_total" value="" class="form-control" readonly="true">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    ORIGEN:
                                                </label>
                                                <select class="form-control" name="origen">
                                                    @foreach($punto_ventas as $pv)
                                                    <option value="{{$pv->id_planta}}">{{$pv->pv_nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>                            
                                </div>
                                <div class="row"> 
                                    <div class="col-md-12">                                                      
                                        <table id="lts-carritoingresopv" class="table table-condensed" style="width:100%">
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
                                        <div class="col-md-12">
                                            <label>
                                                Obseraciones:
                                            </label>
                                            <textarea class="form-control" name="observacion" id="observacion"></textarea>
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
                {!!link_to('#',$title='Enviar Solicitud', $attributes=['id'=>'registroIngresoPv','class'=>'btn btn-success','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    
</script>
@endpush