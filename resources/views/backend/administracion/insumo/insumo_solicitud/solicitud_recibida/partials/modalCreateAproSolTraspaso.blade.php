<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myCreateSolTraspaso" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel">
                    APROBAR SOLICITUD POR TRASPASO/MAQUILA
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                        {!! Form::open(['id'=>'proveedor', 'files' => true])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id_solMaquila" name="id_solMaquila" type="hidden" value="">
                            <input id="id_insumo" type="hidden" name="id_insumo" value="">
                            <input type="hidden" name="cod_solMaquila" id="cod_solMaquila" value="">
                            <input id="codigo_insumo" name="codigo_insumo" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nombre Insumo:
                                                </label>
                                                {!! Form::text('nombre_sol_traspaso', null, array('placeholder' => 'Nombre del insumo','class' => 'form-control','id'=>'nombre_sol_traspaso', 'style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();', 'readonly')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Cantidad:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('sol_cant_traspaso', null, array('placeholder' => 'Cantidad','class' => 'form-control','id'=>'sol_cant_traspaso','readonly')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    UM:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('sol_um_traspaso', null, array('placeholder' => 'Unidad de Medida','class' => 'form-control','id'=>'sol_um_traspaso','readonly')) !!}
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
                                                    Origen:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('sol_origen_traspaso', null, array('placeholder' => 'Origen','class' => 'form-control','id'=>'sol_origen_traspaso','readonly')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Destino:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('sol_destino_traspaso', null, array('placeholder' => 'Destino','class' => 'form-control','id'=>'sol_destino_traspaso','readonly')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Observaciones:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('sol_obs_traspaso', null, array('placeholder' => 'Observaciones','class' => 'form-control','id'=>'sol_obs_traspaso','readonly')) !!}
                                                </span>   
                                            </div>
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
                <button class="btn btn-danger" data-dismiss="modal" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Rechazar', $attributes=['id'=>'rechazoMaquila','class'=>'btn btn-warning','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
                {!!link_to('#',$title='Aprobar', $attributes=['id'=>'aprovMaquila','class'=>'btn btn-success','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">

</script>
@endpush