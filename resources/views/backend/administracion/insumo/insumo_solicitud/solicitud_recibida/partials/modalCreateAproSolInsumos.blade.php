<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myCreateSolInsumos" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel">
                    APROBAR SOLICITUD POR INSUMO
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                        {!! Form::open(['id'=>'proveedor', 'files' => true])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id_soladi" name="id_soladi" type="hidden" value="">
                            <input type="hidden" name="cod_soladi" id="cod_soladi" value="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nombre Receta:
                                                </label>
                                                {!! Form::text('nombre_sol_insumos', null, array('placeholder' => 'Nombre de los insumos','class' => 'form-control','id'=>'nombre_sol_insumos', 'style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();', 'readonly')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Nro. Lote:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('sol_insumos_lote', null, array('placeholder' => 'Nro. Lote','class' => 'form-control','id'=>'sol_insumos_lote')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
 -->                                <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Nro. Salida:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('sol_insumos_salida', null, array('placeholder' => 'Nro. Salida','class' => 'form-control','id'=>'sol_insumos_salida')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div> -->
                                    
                                </div>
                                <div class="row">                                                       
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Nota Salida:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('sol_nota_salida', null, array('placeholder' => 'Cantidad minima','class' => 'form-control','id'=>'sol_nota_salida', 'readonly')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Solicitante:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('solicitante_sol_insumos', null, array('placeholder' => 'Solicitente','class' => 'form-control','id'=>'solicitante_sol_insumos','readonly')) !!}
                                                </span> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Mercado:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('mercado_sol_insumos', null, array('placeholder' => 'Mercado','class' => 'form-control','id'=>'mercado_sol_insumos','readonly')) !!}
                                                </span>   
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                    
                                    <table  class="table table-hover small-text" id="TableSolInsumos">
                                        <thead>
                                            <tr>
                                                <th>Codigo Insumo</th>
                                                <th>Insumo</th>
                                                <th>Unidad</th>
                                                <th>Cantidad</th>
                                                <th></th>
                                                <th>Cant. Adicional</th>
                                                <th>Observacion</th>                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
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
                                                    {!! Form::text('observ_sol_insumos', null, array('placeholder' => 'Observaciones','class' => 'form-control','id'=>'observ_sol_insumos', 'readonly')) !!}
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
                {!!link_to('#',$title='Rechazar', $attributes=['id'=>'rechazoInsumoAdi','class'=>'btn btn-warning','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
                {!!link_to('#',$title='Aprobar', $attributes=['id'=>'aprovacionInsumoAdi','class'=>'btn btn-success','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">

</script>
@endpush