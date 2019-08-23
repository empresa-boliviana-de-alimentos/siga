<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myUpdate" tabindex="-5">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    ×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Modificar Proveedor
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                    <hr>
                        {!! Form::open(['id'=>'proveedor'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id_proveedor1" name="id_proveedor" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nombre:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('nombres', null, array('placeholder' => 'ingrese Nombre(s) ','maxlength'=>'20','class' => 'form-control','id'=>'nombres1','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>
                                                <label>
                                                    Apellido Paterno:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('apellido_paterno', null, array('placeholder' => 'Ingrese Apellido Paterno','maxlength'=>'15','class' => 'form-control','id'=>'apellido_paterno1','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>
                                                <label>
                                                   Apellido Materno:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('apellido_materno', null, array('placeholder' => 'Ingrese Apellido Materno','maxlength'=>'15','class' => 'form-control','id'=>'apellido_materno1','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
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
                                                    C.I.:
                                                </label>
                                                {!! Form::text('ci', null, array('placeholder' => 'Ingrese C.I.','maxlength'=>'15','class' => 'form-control','id'=>'ci1')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Expedido:
                                                </label> 
                                                <select class="form-control" id="exp1" name="exp" placeholder="Ingrese Expedido" value="">
                                                   @foreach($dataExp as $exp)
                                                    <option value="{{$exp->dep_id}}">{{$exp->dep_exp}}</option>
                                                   @endforeach
                                                </select>
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
                                                    {!! Form::text('telefono', null, array('placeholder' => 'Ingrese Telefono','maxlength'=>'15','class' => 'form-control','id'=>'telefono1')) !!}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Convenio:
                                                </label> 
                                                <select class="form-control" id="id_convenio1" name="id_convenio" placeholder="Ingrese Expedido" value="">
                                                    <option>Seleccione...</option>
                                                    <option value="SI">SI</option>
                                                    <option value="NO">NO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Comunidad:
                                                </label> 
                                                <select class="form-control" id="id_comunidad1" name="id_comunidad" placeholder="Ingrese Expedido" value="">
                                                    <option>Seleccione Comunidad...</option>
                                                    @foreach($dataComu as $comu)
                                                    <option value="{{$comu->com_id}}">{{$comu->com_nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Comprador Asignado:
                                                </label> 
                                                 <select class="form-control" id="id_comprador1" name="id_comprador1" placeholder="Ingrese Expedido" value="">
                                                    <option>Seleccione Comprador...</option>
                                                    @foreach($usuario as $usu)
                                                    <option value="{{$usu->usr_id}}">{{$usu->prs_nombres.' '.$usu->prs_paterno.' '.$usu->prs_materno}}</option>
                                                    @endforeach
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
                <button class="btn btn-default" data-dismiss="modal" style="background:#A5A5B2" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Actualizar', $attributes=['id'=>'actualizar','class'=>'btn btn-primary','style'=>'background:#57BC90'], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
