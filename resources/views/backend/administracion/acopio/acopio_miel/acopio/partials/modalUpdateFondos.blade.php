<div class="modal fade bs-example-modal-sm in" data-backdrop="static" data-keyboard="false" id="UpdateFondosAvance" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    ×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Modificar Acopio
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                    <?php $now = new \DateTime(); ?>
                        {!! Form::open(['id'=>'acopio'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                         <input id="id1" name="prsid1" type="hidden" value="">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                Proveedor:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('id_proveedor', null, array('placeholder' => 'Ingrese Proveedor','maxlength'=>'20','class' => 'form-control','id'=>'id_proveedor1')) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                Lugar:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('id_lugar', null, array('placeholder' => 'Ingrese Apellido Paterno','maxlength'=>'15','class' => 'form-control','id'=>'id_lugar1')) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                               Centro Acopio:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('centro_acopio', null, array('placeholder' => 'Ingrese centro acopio','maxlength'=>'15','class' => 'form-control','id'=>'centro_acopio1')) !!}
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
                                                Tipo:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('id_tipo', null, array('placeholder' => 'Ingrese Tipo','maxlength'=>'10','class' => 'form-control','id'=>'id_tipo1')) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                Peso Neto:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('peso_neto', null, array('placeholder' => 'Peso Neto','maxlength'=>'10','class' => 'form-control','id'=>'peso_neto1')) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                Nro. Acopio:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('nro_acopio', null, array('placeholder' => 'Nro. Acopio','maxlength'=>'10','class' => 'form-control','id'=>'nro_acopio1')) !!}
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
                                                Unidad:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('id_unidad', null, array('placeholder' => 'Ingrese Unidad','maxlength'=>'50','class' => 'form-control','id'=>'id_unidad1')) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                Cantidad:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('cantidad', null, array('placeholder' => 'Ingrese cantidad','class' => 'form-control','id'=>'cantidad1')) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                Costo:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('costo', null, array('placeholder' => 'Ingrese costo', 'class' => 'form-control','id'=>'costo1')) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                Total:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('total', null, array('placeholder' => 'Ingrese Total', 'class' => 'form-control','id'=>'total1')) !!}
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
                                                Imp Sup:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('imp_sup', null, array('placeholder' => 'Ingrese Imp Sup', 'class' => 'form-control','id'=>'imp_sup1')) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                               Total Imp Sup:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('total_imp_sup', null, array('placeholder' => 'Ingrese Total imp sup', 'class' => 'form-control','id'=>'total_imp_sup1')) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                Observación:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('observacion', null, array('placeholder' => 'Ingrese Observacion', 'class' => 'form-control','id'=>'observacion1')) !!}
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
                                                Boleta:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('boleta', null, array('placeholder' => 'Ingrese Boleta', 'class' => 'form-control','id'=>'boleta1')) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                Nro. Recibo:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('nro_recibo', null, array('placeholder' => 'Ingrese Nro Recibo', 'class' => 'form-control','id'=>'nro_recibo1')) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                Zona:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('id_zona', null, array('placeholder' => 'Ingrese Zona', 'class' => 'form-control','id'=>'id_zona1')) !!}
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
                                                Tipo Acopio:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('id_tipo_acopio', null, array('placeholder' => 'Ingrese Tipo Acopio', 'class' => 'form-control','id'=>'id_tipo_acopio1')) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                    Prop Fisico Quimico:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('id_prop_fq', null, array('placeholder' => 'Ingrese prop Fisico Quimico','class' => 'form-control','id'=>'id_prop_fq1')) !!}
                                                </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                Prop Organico:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('id_prop_org', null, array('placeholder' => 'Ingrese prop Organico','class' => 'form-control','id'=>'id_prop_org1')) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                Responsable de Recepción:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('id_resp_recepcion', null, array('placeholder' => 'Ingrese responsable de Recepcion','class' => 'form-control','id'=>'id_resp_recepcion1')) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                Acta de entrega:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('acta_entrega', null, array('placeholder' => 'Ingrese acta de entrega','class' => 'form-control','id'=>'acta_entrega1')) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                Pago:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('pago', null, array('placeholder' => 'Ingrese pago','class' => 'form-control','id'=>'pago1')) !!}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                 Destino:
                                            </label>
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('id_destino', null, array('placeholder' => 'Ingrese destino','class' => 'form-control','id'=>'id_destino1')) !!}
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
                {!!link_to('#',$title='Actualizar', $attributes=['id'=>'actualizar','class'=>'btn btn-primary','style'=>'background:#57BC90'], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>