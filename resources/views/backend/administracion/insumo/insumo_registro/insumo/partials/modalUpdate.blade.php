<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myUpdateIns" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #202040">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button"><span style="color: white">x</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    Modificar Insumo
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                        {!! Form::open(['id'=>'proveedor'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="ins_id1" name="provid" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nombre Genérico:
                                                </label> 
                                                {!! Form::textarea('res.descripcion1', null, array('placeholder' => ' ','class' => 'form-control','id'=>'descripcion1', 'rows'=>'2','required','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
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
                                                <select class="form-control" id="ins_id_tip_ins1" name="ins_id_tip_ins1" placeholder="" value="" onchange="muestradatEdit()">
                                                    <option value="">Seleccione...</option>
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
                                                <select class="form-control" id="ins_id_part1" name="ins_id_part1" placeholder="" value="">
                                                    <option value="">Seleccione...</option>
                                                    @foreach($dataPart as $part)
                                                    <option value="{{$part->part_id}}">{{$part->part_nombre}}</option>
                                                    @endforeach
                                                </select> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tipo_envase1" style="display: none;">
                                    <div class="row">
                                        <h4 class="text-center" style="color:#202040"><strong>ENVASE</strong></h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Tipo Envase:
                                                    </label>
                                                    <select class="form-control" id="id_tip_env1" name="id_tip_env1" placeholder="" value="">
                                                        <option value="">Selec. tipo envase...</option>
                                                        @foreach($dataTipEnv as $tipenv)
                                                        <option value="{{$tipenv->tenv_id}}">{{$tipenv->tenv_nombre}}</option>
                                                        @endforeach
                                                    </select> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                       Linea producción:
                                                    </label>
                                                    <select class="form-control" id="id_linea_prod1" name="id_linea_prod1" value="">
                                                        <option value="">Selec. linea Prod</option>
                                                        @foreach($dataLineaProd as $lineaProd)
                                                        <option value="{{$lineaProd->linea_prod_id}}">{{$lineaProd->linea_prod_nombre}}</option>
                                                        @endforeach
                                                    </select> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Producto Específico:
                                                    </label>
                                                    <select class="form-control" id="id_prod_especifico1" name="id_prod_especifico1" placeholder="" value="">
                                                        <option value="">Seleccione prod. especif...</option>
                                                        @foreach($dataProdEspe as $prodEsp)
                                                        <option value="{{$prodEsp->prod_esp_id}}">{{$prodEsp->prod_esp_nombre}}</option>
                                                        @endforeach
                                                    </select> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Mercado:
                                                    </label>
                                                    <select class="form-control" id="id_mercado1" name="id_mercado1" placeholder="" value="">
                                                        <option value="">Seleccione mercado...</option>
                                                        @foreach($dataMercado as $mercado)
                                                        <option value="{{$mercado->mer_id}}">{{$mercado->mer_nombre}}</option>
                                                        @endforeach
                                                    </select> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                       Formato:
                                                    </label>
                                                    {!! Form::text('formato1', null, array('placeholder' => ' ','class' => 'form-control','id'=>'formato1', 'rows'=>'2','required','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();','placeholder'=>'Formato')) !!}
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                       Unidad Medida:
                                                    </label>
                                                    <select class="form-control" id="id_uni1" name="id_uni1" value="">
                                                        <option value="">Seleccione unidad medida</option>
                                                        @foreach($dataUni as $uni)
                                                        <option value="{{$uni->umed_id}}">{{$uni->umed_nombre}}</option>
                                                        @endforeach
                                                    </select> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                       Municipio:
                                                    </label>
                                                    <select class="form-control" id="id_municipio1" name="id_municipio1" value="">
                                                        <option value="">Seleccione municipio</option>
                                                        @foreach($dataMunicipio as $municipio)
                                                        <option value="{{$municipio->muni_id}}">{{$municipio->muni_nombre}}</option>
                                                        @endforeach
                                                    </select> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tipo_insumo1" style="display: none;">
                                    <div class="row">
                                        <h4 class="text-center" style="color:#202040"><strong>INSUMO</strong></h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Sabor:
                                                    </label>
                                                    <select class="form-control" id="id_sabor1" name="id_sabor1" placeholder="" value="">
                                                        <option value="">Seleccione sabor</option>
                                                        @foreach($dataSabor as $sabor)
                                                        <option value="{{$sabor->sab_id}}">{{$sabor->sab_nombre}}</option>
                                                        @endforeach
                                                    </select> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                       Color:
                                                    </label>
                                                    <select class="form-control" id="id_color1" name="id_color1" value="">
                                                        <option value="">Seleccione color</option>
                                                        @foreach($dataColor as $color)
                                                        <option value="{{$color->col_id}}">{{$color->col_nombre}}</option>
                                                        @endforeach
                                                    </select> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Peso por presentación:
                                                    </label>
                                                    {!! Form::text('presentacion1', null, array('placeholder' => ' ','class' => 'form-control','id'=>'presentacion1', 'rows'=>'2','required','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();','placeholder'=>'Peso presentación')) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                       Unidad Medida:
                                                    </label>
                                                    <select class="form-control" id="id_uni_ins1" name="id_uni_ins1" value="">
                                                        <option value="">Seleccione unidad medida</option>
                                                        @foreach($dataUni as $uni)
                                                        <option value="{{$uni->umed_id}}">{{$uni->umed_nombre}}</option>
                                                        @endforeach
                                                    </select> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tipo_insumo_map1" style="display: none;">
                                    <div class="row">
                                        <h4 class="text-center" style="color:#202040"><strong>INSUMO MATERIA PRIMA</strong></h4>
                                    </div>
                                    <div class="row">                                 
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                       Unidad Medida:
                                                    </label>
                                                    <select class="form-control" id="id_uni_ins_map1" name="id_uni_ins_map1" value="">
                                                        <option value="">Seleccione unidad medida</option>
                                                        @foreach($dataUni as $uni)
                                                        <option value="{{$uni->umed_id}}">{{$uni->umed_nombre}}</option>
                                                        @endforeach
                                                    </select> 
                                                </div>
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
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'actualizarIns','class'=>'btn btn-success','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function muestradatEdit(){

    var id_tipins = document.getElementById('ins_id_tip_ins1').value;
    console.log(id_tipins);
    
    if (id_tipins==1) {
        $('#tipo_insumo1').show();
        $('#tipo_envase1').hide();
        $('#tipo_insumo_map1').hide();
        $('#id_tip_env1').val("");
        $('#id_linea_prod1').val("");
        $('#id_mercado1').val("");
        $('#formato1').val("");
        $('#id_uni1').val("");
        $('#id_municipio1').val("");
        $('#id_prod_especifico1').val("");              
    }else if(id_tipins==2){      
       $('#tipo_envase1').show();
       $('#tipo_insumo1').hide();
       $('#tipo_insumo_map1').hide();
       $('#id_sabor1').val("");
       $('#id_color1').val("");
       $('#presentacion1').val("");
       $('#id_uni1').val("");  
    }else if(id_tipins==3){
        $('#tipo_insumo1').hide();
        $('#tipo_envase1').hide();
        $('#tipo_insumo_map1').show();
        $('#id_tip_env1').val("");
        $('#id_linea_prod1').val("");
        $('#id_mercado1').val("");
        $('#formato1').val("");
        $('#id_uni1').val("");
        $('#id_municipio1').val("");
        $('#id_prod_especifico1').val("");
    }else{
        $('#tipo_insumo1').show();
        $('#tipo_envase1').hide();
        $('#tipo_insumo_map1').hide();
        $('#id_tip_env1').val("");
        $('#id_linea_prod1').val("");
        $('#id_mercado1').val("");
        $('#formato1').val("");
        $('#id_uni1').val("");
        $('#id_municipio1').val("");
        $('#id_prod_especifico1').val("");
    }
}
</script>
@endpush 

