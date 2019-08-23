<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myCreateSolRecibidas" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel">
                    APROBAR SOLICITUD POR RECETA
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                        {!! Form::open(['id'=>'proveedor', 'files' => true])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id_solReceta" name="id_solReceta" type="hidden" value="">
                            <input type="hidden" name="cod_solReceta" id="cod_solReceta" value="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nombre Receta:
                                                </label>
                                                {!! Form::text('nombre_sol_receta', null, array('placeholder' => 'Nombre de la Receta','class' => 'form-control','id'=>'nombre_sol_receta', 'style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();', 'readonly')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Cant:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('sol_cantidad_rec', null, array('placeholder' => 'Cant. minima','class' => 'form-control','id'=>'sol_cantidad_rec')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div> -->
                                    
                                </div>
                                <div class="row">                                                       
                                    <!-- <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Nro Lote:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('cant_minima', null, array('placeholder' => 'Cant. minima','class' => 'form-control','id'=>'cant_minima')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Solicitante:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('solicitante_sol_rec', null, array('placeholder' => 'Solicitente','class' => 'form-control','id'=>'solicitante_sol_rec','readonly')) !!}
                                                </span> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Mercado:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('mercado_sol_rec', null, array('placeholder' => 'Mercado','class' => 'form-control','id'=>'mercado_sol_rec','readonly')) !!}
                                                </span>   
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                    
                                    <table  class="table table-hover small-text" id="TableSolRecetas">
                                        <thead>
                                            <tr>
                                                <th>codigo Insumo</th>
                                                <th>Insumo</th>
                                                <th>Unidad</th>
                                                <th>Cantidad</th>
                                                <!-- <th>Rango Adicional</th>                                 -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
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
                {!!link_to('#',$title='Rechazar', $attributes=['id'=>'rechazoReceta','class'=>'btn btn-warning','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
                {!!link_to('#',$title='Aprobar', $attributes=['id'=>'aprovacionReceta','class'=>'btn btn-success','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">

</script>
@endpush