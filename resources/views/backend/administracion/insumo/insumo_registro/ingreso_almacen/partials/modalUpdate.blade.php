<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myUpdateProv" tabindex="-5">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    ×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Modificar Proveedor Insumo
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                        {!! Form::open(['id'=>'proveedor'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="prov_id1" name="prov_id1" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nombre Proveedor:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('prov_nom1', null, array('placeholder' => 'Ingrese Nombre','maxlength'=>'20','class' => 'form-control','id'=>'prov_nom1')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Direccion:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('prov_dir1', null, array('placeholder' => 'Ingrese direccion','maxlength'=>'15','class' => 'form-control','id'=>'prov_dir1')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Telefono:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('prov_tel1', null, array('placeholder' => 'Ingrese telefono','maxlength'=>'15','class' => 'form-control','id'=>'prov_tel1')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>  
                                <strong><h5 class="modal-title" style="color:#8a6d3b">Datos del Responsable</h5></strong>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nombre:
                                                </label>
                                                {!! Form::text('prov_nom_res1', null, array('placeholder' => 'Nombre(s) Responsable','maxlength'=>'15','class' => 'form-control','id'=>'prov_nom_res1')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Apellido Paterno:
                                                </label> 
                                                {!! Form::text('prov_ap_res1', null, array('placeholder' => 'Ap. Paterno Responsable','maxlength'=>'15','class' => 'form-control','id'=>'prov_ap_res1')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                   Apellido Materno:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('prov_am_res1', null, array('placeholder' => 'Ap. Materno Responsable','maxlength'=>'15','class' => 'form-control','id'=>'prov_am_res1')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Telefono:
                                                </label> 
                                                 <span class="block input-icon input-icon-right">
                                                    {!! Form::text('prov_tel_res1', null, array('placeholder' => 'Ingrese Telefono','maxlength'=>'15','class' => 'form-control','id'=>'prov_tel_res1')) !!}
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
                                                    Observaciones:
                                                </label> 
                                                 {!! Form::textarea('res.prov_obs1', null, array('placeholder' => ' ','class' => 'form-control','id'=>'prov_obs1', 'rows'=>'2','required')) !!} 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </input>
                        </input>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" style="background:#A5A5B2" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Actualizar', $attributes=['id'=>'actualizarProv','class'=>'btn btn-primary','style'=>'background:#57BC90'], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
