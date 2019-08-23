<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myUpdateIns" tabindex="-5">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    ×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Modificar Registro Insumo
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                        {!! Form::open(['id'=>'proveedor'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="ins_id1" name="ins_id1" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Codigo Insumo:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('codigo1', null, array('placeholder' => 'Cod. Insumo','maxlength'=>'20','class' => 'form-control','id'=>'codigo1', 'disabled'=>'true')) !!}
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
                                                    Tipo Insumo:
                                                </label>
                                                <select class="form-control" id="id_tip_ins1" name="id_tip_ins1" placeholder="" value="">
                                                    <option>Seleccione...</option>
                                                     @foreach($dataIns as $ins)
                                                    <option value="{{$ins->tins_id}}">{{$ins->tins_nombre}}</option>
                                                    @endforeach
                                                </select> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Partida:
                                                </label>
                                                <select class="form-control" id="id_part1" name="id_part1" placeholder="" value="">
                                                    <option>Seleccione...</option>
                                                    @foreach($dataPart as $part)
                                                    <option value="{{$part->part_id}}">{{$part->part_nombre}}</option>
                                                    @endforeach
                                                </select> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Categoria:
                                                </label> 
                                                <select class="form-control" id="id_cat1" name="id_cat1" placeholder="" value="">
                                                    <option>Seleccione...</option>
                                                    @foreach($dataCat as $cat)
                                                    <option value="{{$cat->cat_id}}">{{$cat->cat_nombre}}</option>
                                                    @endforeach
                                                </select> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                   Unidad Medida:
                                                </label>
                                                <select class="form-control" id="id_uni1" name="id_uni1" placeholder="" value="">
                                                    <option>Seleccione...</option>
                                                     @foreach($dataUni as $uni)
                                                    <option value="{{$uni->umed_id}}">{{$uni->umed_nombre}}</option>
                                                    @endforeach
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
                                                    Descripcion:
                                                </label> 
                                                {!! Form::textarea('res.descripcion1', null, array('placeholder' => ' ','class' => 'form-control','id'=>'descripcion1', 'rows'=>'2','required','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
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
                {!!link_to('#',$title='Actualizar', $attributes=['id'=>'actualizarIns','class'=>'btn btn-primary','style'=>'background:#57BC90'], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
