<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myCreateSubLinea" tabindex="-5">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #202040">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button"><span style="color: white">x</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    Registro Sub-Linea
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
                                                    Nombre Sub-Linea:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('nombresub', null, array('placeholder' => 'Nombre Sub-Linea','maxlength'=>'250','class' => 'form-control','id'=>'nombresub', 'style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Linea Produccion:
                                                </label>
                                                <select class="form-control" id="prodlinea" name="prodlinea" placeholder="" value="">
                                                    <option value="">Seleccione...</option>
                                                    <!--<option value="1">LACTEOS</option>
                                                    <option value="2">ALMENDRA</option>
                                                    <option value="3">MIEL</option>
                                                    <option value="4">FRUTOS</option>
                                                    <option value="5">DERIVADOS</option>-->
                                                    @foreach($datalinprod as $dlp)
                                                        <option value="{{$dlp->linea_prod_id}}">{{$dlp->linea_prod_nombre}}</option>
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
                <button class="btn btn-danger" data-dismiss="modal" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registroSubLinea','class'=>'btn btn-success','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

 

