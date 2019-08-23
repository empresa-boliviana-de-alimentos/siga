<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myCreateSol" tabindex="-5">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel">
                    NUEVA SOLICITUD
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                    <hr>
                        {!! Form::open(['id'=>'proveedor'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id" name="provid" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Objeto:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('sol_detalle', null, array('placeholder' => 'ingrese el Objeto ','maxlength'=>'250','class' => 'form-control','id'=>'sol_detalle','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Centro de Acopio:
                                                </label>
                                                {!! Form::text('sol_centr_acopio', null, array('placeholder' => 'Ingrese Centro de Acopio','maxlength'=>'250','class' => 'form-control','id'=>'sol_centr_acopio','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Municipio:
                                                </label> 
                                                <select class="form-control" id="id_municipio" name="id_municipio" placeholder="Ingrese Expedido" value="">
                                                    <option>Seleccione Municipio...</option>
                                                    @foreach($dataMuni as $muni)
                                                    <option value="{{$muni->mun_id}}">{{$muni->mun_nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Monto Bs:
                                                </label>
                                                {!! Form::number('sol_monto', null, array('placeholder' => '','maxlength'=>'15','class' => 'form-control','id'=>'sol_monto','step'=>'any')) !!}
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
		<button class="btn btn-default" data-dismiss="modal" style="background:#A5A5B2" type="button">
                    Cancelar
                </button>
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registroSolicitud','class'=>'btn btn-primary','style'=>'background:#57BC90'], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>


