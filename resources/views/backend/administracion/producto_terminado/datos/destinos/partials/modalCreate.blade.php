<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myCreateDestino" tabindex="-5">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel">
                    Registro Destino
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
                                                    Nombre:
                                                </label>
                                                {!! Form::text('nomres', null, array('placeholder' => 'Nombre','class' => 'form-control','id'=>'nomres','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                            </div>
                                        </div>
                                    </div>                                 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Departamento:
                                                </label> 
                                                <select class="form-control">
                                                    <option>LA PAZ</option>
                                                    <option>ORURO</option>
                                                    <option>POTOSI</option>
                                                    <option>COCHABAMBA</option>
                                                    <option>CHUQUISACA</option>
                                                    <option>TARIJA</option>
                                                    <option>SANTA CRUZ</option>
                                                    <option>BENI</option>
                                                    <option>PANDO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Mercado:
                                                </label> 
                                                <select class="form-control">
                                                    <option>ABIERTO</option>
                                                    <option>CERRADO</option>
                                                </select>
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

 

