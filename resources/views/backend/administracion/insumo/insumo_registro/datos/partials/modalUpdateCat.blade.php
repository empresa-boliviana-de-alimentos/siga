<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myUpdateCat" tabindex="-5">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #202040">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button"><span style="color: white">x</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    Modificar Registro Categoria
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                        {!! Form::open(['id'=>'proveedor'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="idcat" name="idcat" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nombre Categoria:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('nombre', null, array('placeholder' => 'Nombre Categoria','maxlength'=>'250','class' => 'form-control','id'=>'catnombre','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                    <!--<div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Partida:
                                                </label>
                                                <select class="form-control" id="catpartida" name="catpartida" placeholder="" value="">
                                                    <option value="">Seleccione...</option>
                                                    @foreach($dataPartida as $part)
                                                    <option value="{{$part->part_id}}">{{$part->part_nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>-->
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
                {!!link_to('#',$title='Modificar', $attributes=['id'=>'modificarCat','class'=>'btn btn-success','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

 

