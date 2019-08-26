<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myCreateIns" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel">
                    Registro Insumo
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
                                                    Nombre Genérico:
                                                </label> 
                                                {!! Form::textarea('res.descripcion', null, array('placeholder' => ' ','class' => 'form-control','id'=>'descripcion', 'rows'=>'2','required','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
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
                                                <select class="form-control" id="id_tip_ins" name="id_tip_ins" placeholder="" value="" onchange="muestradat()">
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
                                                <select class="form-control id_part_select" style="width: 100%" id="id_part" name="id_part" placeholder="" value="">
                                                    <option value="">Seleccione...</option>
                                                    @foreach($dataPart as $part)
                                                    <option value="{{$part->part_id}}">{{$part->part_nombre}}</option>
                                                    @endforeach
                                                </select> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tipo_envase" style="display: none;">
                                    <div class="row">
                                        <h4 class="text-center" style="color:#2067b4"><strong>ENVASE</strong></h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Tipo Envase:
                                                    </label>
                                                    <select class="form-control" id="id_tip_env" name="id_tip_env" placeholder="" value="">
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
                                                    <select class="form-control" id="id_linea_prod" name="id_linea_prod" value="">
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
                                                    <select class="form-control" id="id_prod_especifico" name="id_prod_especifico" placeholder="" value="">
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
                                                    <select class="form-control" id="id_mercado" name="id_mercado" placeholder="" value="">
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
                                                    {!! Form::text('formato', null, array('placeholder' => ' ','class' => 'form-control','id'=>'formato', 'rows'=>'2','required','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();','placeholder'=>'Formato')) !!}
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                       Unidad Medida:
                                                    </label>
                                                    <select class="form-control id_uni_select" id="id_uni" style="width: 100%" name="id_uni" value="">
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
                                                    <select class="form-control" id="id_municipio" name="id_municipio" value="">
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
                                <div id="tipo_insumo" style="display: none;">
                                    <div class="row">
                                        <h4 class="text-center" style="color:#2067b4"><strong>INSUMO</strong></h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Sabor:
                                                    </label>
                                                    <select class="form-control id_sabor_select" style="width: 100%" id="id_sabor" name="id_sabor" placeholder="" value="">
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
                                                    <select class="form-control" id="id_color" name="id_color" value="">
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
                                                    {!! Form::text('presentacion', null, array('placeholder' => ' ','class' => 'form-control','id'=>'presentacion', 'rows'=>'2','required','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();','placeholder'=>'Peso presentación')) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                       Unidad Medida:
                                                    </label>
                                                    <select class="form-control id_uni_ins_select" id="id_uni_ins" style="width: 100%" name="id_uni_ins" value="">
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
                                <div id="tipo_insumo_map" style="display: none;">
                                    <div class="row">
                                        <h4 class="text-center" style="color:#2067b4"><strong>INSUMO MATERIA PRIMA</strong></h4>
                                    </div>
                                    <div class="row">                                 
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <label>
                                                       Unidad Medida:
                                                    </label>
                                                    <select class="form-control" id="id_uni_ins_map" name="id_uni_ins_map" value="">
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
                    </hr>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registroIns','class'=>'btn btn-success','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$('.id_part_select').select2({
    dropdownParent: $('#myCreateIns'),
    placeholder: "Selecciona",
    proveedor: true,
    language: "es",
});
$('.id_sabor_select').select2({
    dropdownParent: $('#myCreateIns'),
    placeholder: "Selecciona",
    proveedor: true,
    language: "es",    
});
$('.id_uni_ins_select').select2({
    dropdownParent: $('#myCreateIns'),
    placeholder: "Selecciona",
    proveedor: true,
    language: "es",    
});

$('.id_uni_select').select2({
    dropdownParent: $('#myCreateIns'),
    placeholder: "Selecciona",
    proveedor: true,
    language: "es",    
});
function muestradat(){

    var id_tipins = document.getElementById('id_tip_ins').value;
    console.log(id_tipins);
    
    if (id_tipins==1) {
        $('#tipo_insumo').show();
        $('#tipo_envase').hide();
        $('#tipo_insumo_map').hide();
        $('#id_tip_env').val("");
        $('#id_linea_prod').val("");
        $('#id_mercado').val("");
        $('#formato').val("");
        $('#id_uni').val("");
        $('#id_municipio').val("");
        $('#id_prod_especifico').val("");              
    }else if(id_tipins==2){      
       $('#tipo_envase').show();
       $('#tipo_insumo').hide();
       $('#tipo_insumo_map').hide();
       $('#id_sabor').val("");
       $('#id_color').val("");
       $('#presentacion').val("");
       $('#id_uni').val("");  
    }else if(id_tipins==3){
        $('#tipo_insumo').hide();
        $('#tipo_envase').hide();
        $('#tipo_insumo_map').show();
        $('#id_tip_env').val("");
        $('#id_linea_prod').val("");
        $('#id_mercado').val("");
        $('#formato').val("");
        $('#id_uni').val("");
        $('#id_municipio').val("");
        $('#id_prod_especifico').val("");
    }else{
        $('#tipo_insumo').show();
        $('#tipo_envase').hide();
        $('#tipo_insumo_map').hide();
        $('#id_tip_env').val("");
        $('#id_linea_prod').val("");
        $('#id_mercado').val("");
        $('#formato').val("");
        $('#id_uni').val("");
        $('#id_municipio').val("");
        $('#id_prod_especifico').val("");
    }
}
</script>
@endpush 

