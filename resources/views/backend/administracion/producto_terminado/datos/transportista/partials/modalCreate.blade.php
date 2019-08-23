<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myCreateProv" tabindex="-5">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel">
                    Registro Transportista
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                        {!! Form::open(['id'=>'proveedor'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id" name="provid" type="hidden" value="">                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nombres:
                                                </label>
                                                {!! Form::text('nomres', null, array('placeholder' => 'Nombre(s)','class' => 'form-control','id'=>'nomres','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Apellido Paterno:
                                                </label> 
                                                {!! Form::text('apres', null, array('placeholder' => 'Apellido Paterno','class' => 'form-control','id'=>'apres','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
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
                                                    {!! Form::text('amres', null, array('placeholder' => 'Apellido Materno Responsable','class' => 'form-control','id'=>'amres','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    CI:
                                                </label> 
                                                 <span class="block input-icon input-icon-right">
                                                    {!! Form::number('telres', null, array('placeholder' => 'CI','class' => 'form-control','id'=>'telres')) !!}
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
                                                    Telefono:
                                                </label> 
                                                {!! Form::number('telres', null, array('placeholder' => 'Telefono','class' => 'form-control','id'=>'telres')) !!}
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
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registroProv','class'=>'btn btn-success','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

 

