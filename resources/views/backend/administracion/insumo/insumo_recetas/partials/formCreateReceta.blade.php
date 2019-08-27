    @extends('backend.template.app')
<style type="text/css" media="screen">
    .form-bg{
    background: #e4e6e6;
}
form{
    font-family: 'Roboto', sans-serif;
    background: #e4e6e6;
}
.form-horizontal .header{
    background: #3f9cb5;
    padding: 30px 25px;
    font-size: 30px;
    color: #fff;
    text-align: center;
    text-transform: uppercase;
    border-radius: 3px 3px 0 0;
}
.form-horizontal .heading{
    font-size: 16px;
    color: #3f9cb5;
    margin: 10px 0 20px 0;
    text-transform: capitalize;
}
.form-horizontal .form-content{
    padding: 25px;
    background: #fff;
}

.form-horizontal .form-control:focus{
    border-color: #3f9cb5;
    box-shadow: none;
}
.form-horizontal .control-label{
    font-size: 17px;
    color: #ccc;
    position: absolute;
    top: 5px;
    left: 27px;
    text-align: center;
}
table {
  border-collapse: separate;
  border-spacing: 0 5px;
}

thead th {
  background-color:#428bca;
  color: white;
}
tbody td {
  background-color: #EEEEEE;
}
</style>
@section('main-content')
<?php $now = new DateTime('America/La_Paz');?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title text-center">REGISTRO RECETA EBA</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ url('RegistrarReceta') }}" class="form-horizontal" method="GET">
                <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                <input id="fecha_resgistro" name="fecha_resgistro" type="hidden" value="<?php echo $now->format('d-m-Y H:i:s'); ?>">
                <input type="hidden" name="nro_acopio" id="nro_acopio" value="">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Nombre Producto:
                                    </label>
                                        {!! Form::text('nombre_receta', null, array('placeholder' => 'Nombre del producto','class' => 'form-control','id'=>'nombre_receta')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Sabor
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        <select class="form-control select_sabor" id="sabor" name="sabor">
                                            <option value="0">Seleccione</option>
                                            @foreach($sabor as $sab)
                                                <option value="{{$sab->sab_id}}">{{$sab->sab_nombre}}</option>
                                            @endforeach
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                       <b>Seleccione la línea de producción:</b> <font style="color:red">*</font>
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        <select class="form-control" name="lineaProduccion" id="lineaProduccion">
                                            <option value="0">Seleccione</option>
                                            <option value="1">Lacteos</option>
                                            <option value="2">Almendra</option>
                                            <option value="3">Miel</option>
                                            <option value="4">Frutos</option>
                                            <option value="5">Derivados</option>
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Sublinea
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        <select class="form-control select_sublinea" id="sublinea" name="sublinea">
                                            <option value="0">Seleccione</option>
                                            @foreach($sublinea as $sub)
                                            <option value="{{$sub->sublin_id}}">{{$sub->sublin_nombre}}</option>
                                            @endforeach
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Presentación
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::text('presentacion', null, array('placeholder' => 'Presentación','class' => 'form-control','id'=>'presentacion')) !!}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Unidad Medida
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        <select class="form-control select_umed" id="unidad_medida" name="unidad_medida">
                                            <option value="0">Seleccione</option>
                                            @foreach($listarUnidades as $uni)
                                                <option value="{{$uni->umed_id}}">{{$uni->umed_nombre}}</option>
                                            @endforeach
                                        </select>
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
                                        Peso Producto Total
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::text('peso_prod_total', null, array('placeholder' => 'Peso Producto Total ','class' => 'form-control','id'=>'peso_prod_total')) !!}                                       </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Rendimiento Base
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::text('rendimiento_base', null, array('placeholder' => 'Rendimiento Base','class' => 'form-control','id'=>'rendimiento_base')) !!}                                       </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Formato de Presentación
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        <select class="form-control select_upresentacion" id="unidad_presentacion" name="unidad_presentacion">
                                            <option value="0">Seleccione</option>
                                            @foreach($listarUnidades as $uni)
                                                <option value="{{$uni->umed_id}}">{{$uni->umed_nombre}}</option>
                                            @endforeach
                                        </select>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="OcultarMateriaPrima" style="display: none">
                    <div class="col-md-6">
                    <div class="text">
                        <h4 style="color:#2067b4"><strong>MATERIA PRIMA</strong></h4>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                                    <div class="form-group">
                                        <table  class="table table-bordered small-text" id="">
                                            <thead>
                                            <tr class="tr-header">
                                                <th>Descripcion</th>
                                                <th>Unidad</th>
                                                <th>Cantidad</th>
                                            </tr>
                                            </thead>
                                            <tr class="items_columsReceta2">
                                                <td id="tdformmatprim"><select name="descripcion_materia[]" class="form-control">
                                                        <!--<option value="">Seleccione</option>-->
                                                        @foreach($listarMateriaPrima as $insumo)
                                                            <option value="{{$insumo->ins_id}}">{{ $insumo->ins_codigo.' - '.$insumo->ins_desc}} {{$insumo->sab_nombre}} {{$insumo->ins_peso_presentacion}}</option>
                                                        @endforeach
                                                    </select>
                                                <td>
                                                    <input type="" name="" class="form-control" readonly>
                                                </td>
                                                <td><input type="text" name="cantidad_materia[]" class="form-control"></td>
                                            </tr>
                                        </table>

                                    </div>
                        </div>
                    </div>
                    </div>
                </div>

                <div id="OcultaCaracEnv" style="display:none">
                    <div class="col-md-6">
                    <div class="text">
                        <h4 style="color:#2067b4"><strong>CARACTERISTICAS DE ENVASE</strong></h4>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Densidad
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::text('densidad', null, array('placeholder' => 'Densidad','class' => 'form-control','id'=>'densidad')) !!}                                       </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Volumen del Recipiente
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::text('vol_recipiente', null, array('placeholder' => 'Rendimiento Base','class' => 'form-control','id'=>'vol_recipiente')) !!}                                       </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Peso Mezcla
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::text('peso_mezcla', null, array('placeholder' => 'Rendimiento Base','class' => 'form-control','id'=>'peso_mezcla')) !!}                                       </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Peso Botella
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::text('peso_botella', null, array('placeholder' => 'Rendimiento Base','class' => 'form-control','id'=>'peso_botella')) !!}                                       </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        Peso Tapa
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::text('peso_tapa', null, array('placeholder' => 'Rendimiento Base','class' => 'form-control','id'=>'peso_tapa')) !!}                                       </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>


                <div id="OcultarformulacionBase" style="display: none">
                    <div class="col-md-6">
                    <div class="text">
                        <h4 style="color:#2067b4"><strong>FORMULACION DE LA BASE</strong></h4>
                    </div>
                    <material-envasado :lista="{{$listarInsumo}}" nombre="bases" ></material-envasado>

                </div>
                </div>

                <div id="OcultarSaborizacion" style="display: none">
                    <div class="col-md-6">
                    <div class="text">
                        <h4 style="color:#2067b4"><strong>SABORIZACIÓN</strong></h4>
                    </div>
                    <material-envasado :lista="{{$listarSaborizantes}}" nombre="saborizantes" ></material-envasado>

                </div>
                </div>

                <div id="OcultarMatEnv" style="display: none">
                    <div class="col-md-6">
                    <div class="text">
                        <h4 style="color:#2067b4"><strong>MATERIAL DE ENVASADO</strong></h4>
                    </div>
                    <material-envasado :lista="{{$listarEnvase}}" nombre="envasados"></material-envasado>

                </div>
                </div>

                <div id="ocultaParFisQui" style="display: none;">
                    <div class="col-md-12">
                    <div class="text">
                        <h4 style="color:#2067b4"><strong>PARAMETROS FISICO QUÍMICO</strong></h4>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label></label>
                                    <div class="text-right">
                                        SOLIDES (%):
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                       LIE
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::text('solides_lie', null, array('placeholder' => '','class' => 'form-control','id'=>'solides_lie')) !!}                                       </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        LSE
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::text('solides_lse', null, array('placeholder' => '','class' => 'form-control','id'=>'solides_lse')) !!}                                       </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label></label>
                                    <div class="text-right">
                                        ACIDEZ (%AI):
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        LIE
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::text('acidez_lie', null, array('placeholder' => '','class' => 'form-control','id'=>'acidez_lie')) !!}                                       </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        LSE
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::text('acidez_lse', null, array('placeholder' => '','class' => 'form-control','id'=>'acidez_lse')) !!}                                       </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label></label>
                                    <div class="text-right">
                                        PH (-):
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        LIE
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::text('ph_lie', null, array('placeholder' => '','class' => 'form-control','id'=>'ph_lie')) !!}                                       </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        LSE
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::text('ph_lse', null, array('placeholder' => '','class' => 'form-control','id'=>'ph_lse')) !!}                                       </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label></label>
                                    <div class="text-right">
                                        VISCOSIDAD (Seg) a 10°C:
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        LIE
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::text('viscosidad_lie', null, array('placeholder' => '','class' => 'form-control','id'=>'viscosidad_lie')) !!}                                       </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                       LSE
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::text('viscosidad_lse', null, array('placeholder' => '','class' => 'form-control','id'=>'viscosidad_lse')) !!}                                       </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label></label>
                                    <div class="text-right">
                                        DENSIDAD
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        LIE
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::text('densidad_lie', null, array('placeholder' => '','class' => 'form-control','id'=>'densidad_lie')) !!}                                       </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>
                                        LSE
                                    </label>
                                    <span class="block input-icon input-icon-right">
                                        {!! Form::text('densidad_lse', null, array('placeholder' => '','class' => 'form-control','id'=>'densidad_lse')) !!}                                       </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-sm-12">
                            <label>
                                Observaciones
                            </label>
                            <span class="block input-icon input-icon-right">
                                {!! Form::textarea('observaciones', null, array('placeholder' => 'Observaciones','class' => 'form-control','id'=>'observaciones')) !!}                                       </span>
                            </div>
                        </div>
                    </div>
                </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-right">
                            <a class="btn btn-danger btn-lg" href="{{ url('InsumoRecetas') }}" type="button">
                            Cerrar
                            </a>
                            <!-- {!!link_to('#',$title='Registrar', $attributes=['id'=>'registro','class'=>'btn btn-success'], $secure=null)!!} -->
                            <input type="submit"  value="Registrar" class="btn btn-success btn-lg">
                            </div>
                        </div>
                    </div>

            </form>
            </div>
        </div>
    </div>
</div>



@endsection
@push('scripts')
<script>
$("#form_base").select2({
    width: 250
});
$("#form_saborizacion").select2({
    width: 250
});
$("#form_envasado").select2({
    width: 250
});
$(".select_sabor").select2();
$(".select_sublinea").select2();

$(".select_umed").select2();
$(".select_upresentacion").select2();
$(function(){
    $('#lineaProduccion').change(function(){
        if($(this).val()==1){
            $('#OcultarMateriaPrima').hide();
            $('#OcultaCaracEnv').show();
            $('#OcultarformulacionBase').show();
            $('#OcultarSaborizacion').show();
            $('#OcultarMatEnv').show();
            $('#ocultaParFisQui').show();
        }else if($(this).val()==2){
            $('#OcultarMateriaPrima').show();
            $('#OcultaCaracEnv').hide();
            $('#OcultarformulacionBase').hide();
            $('#OcultarSaborizacion').hide();
            $('#OcultarMatEnv').show();
            $('#ocultaParFisQui').hide();
        }else if($(this).val()==3){
            $('#OcultarMateriaPrima').show();
            $('#OcultaCaracEnv').hide();
            $('#OcultarformulacionBase').hide();
            $('#OcultarSaborizacion').hide();
            $('#OcultarMatEnv').show();
            $('#ocultaParFisQui').hide();
        }else if($(this).val()==4){
            $('#OcultarMateriaPrima').hide();
            $('#OcultaCaracEnv').show();
            $('#OcultarformulacionBase').show();
            $('#OcultarSaborizacion').show();
            $('#OcultarMatEnv').show();
            $('#ocultaParFisQui').hide();
        }else if($(this).val()==5){
            $('#OcultarMateriaPrima').hide();
            $('#OcultaCaracEnv').show();
            $('#OcultarformulacionBase').show();
            $('#OcultarSaborizacion').show();
            $('#OcultarMatEnv').show();
            $('#ocultaParFisQui').hide();
        }

    })
});

 $('#addMore').on('click', function() {
              var data = $("#tb tr:eq(1)").clone(true).appendTo("#tb");
              data.find("input").val('');
     });
     $(document).on('click', '.remove', function() {
         var trIndex = $(this).closest("tr").index();
            if(trIndex>=1) {
             $(this).closest("tr").remove();
           } else {
             swal('Lo siento','No puede borrar el unico item');
           }
      });

$('#addMoreSabor').on('click', function() {
              var data = $("#tbSabor tr:eq(1)").clone(true).appendTo("#tbSabor");
              data.find("input").val('');
     });
     $(document).on('click', '.removeSabor', function() {
         var trIndex = $(this).closest("tr").index();
            if(trIndex>=1) {
             $(this).closest("tr").remove();
           } else {
             swal('Lo siento','No puede borrar el unico item');
           }
      });
$('#addMoreEnvase').on('click', function() {
              var data = $("#tbEnvase tr:eq(1)").clone(true).appendTo("#tbEnvase");
              data.find("input").val('');
     });
     $(document).on('click', '.removeEnvase', function() {
         var trIndex = $(this).closest("tr").index();
            if(trIndex>=1) {
             $(this).closest("tr").remove();
           } else {
             swal('Lo siento','No puede borrar el unico item');
           }
      });

//TRAE VALOR DE UNIDAD MEDIDA PARA FORMULACION DE LA BASE
$("#tdformbase").click(function(){
    console.log($(this).parents("tr").find("td").find("select").eq(0).val());
    var ins_id2 = $(this).parents("tr").find("td").find("select").eq(0).val();
    console.log(ins_id2);
    traeUnidad(ins_id2);
    $(this).parents("tr").find("td").find("input").eq(0).val(traeUnidad(ins_id2));
});
function traeUnidad(id_insumo){
    var route = 'trae_uni?ins_id='+id_insumo;
    var dataToReturn = "Error";
    $.ajax({
        url: route,
        type: "GET",
        async: false,
        success: function(data) {
            dataToReturn = data.umed_nombre;
        }
    });
    return dataToReturn;
}
//TRAE VALOR DE UNIDAD MEDIDA PARA SABORIZACION
$("#tdformsab").click(function(){
    console.log($(this).parents("tr").find("td").find("select").eq(0).val());
    var ins_id2 = $(this).parents("tr").find("td").find("select").eq(0).val();
    console.log(ins_id2);
    traeUnidad(ins_id2);
    $(this).parents("tr").find("td").find("input").eq(0).val(traeUnidad(ins_id2));
});
function traeUnidad(id_insumo){
    var route = 'trae_uni?ins_id='+id_insumo;
    var dataToReturn = "Error";
    $.ajax({
        url: route,
        type: "GET",
        async: false,
        success: function(data) {
            dataToReturn = data.umed_nombre;
        }
    });
    return dataToReturn;
}
//TRAE VALOR DE UNIDAD MEDIDA PARA ENVASADO
$("#tdformenv").click(function(){
    console.log($(this).parents("tr").find("td").find("select").eq(0).val());
    var ins_id2 = $(this).parents("tr").find("td").find("select").eq(0).val();
    console.log(ins_id2);
    traeUnidad(ins_id2);
    $(this).parents("tr").find("td").find("input").eq(0).val(traeUnidad(ins_id2));
});
function traeUnidad(id_insumo){
    var route = 'trae_uni?ins_id='+id_insumo;
    var dataToReturn = "Error";
    $.ajax({
        url: route,
        type: "GET",
        async: false,
        success: function(data) {
            dataToReturn = data.umed_nombre;
        }
    });
    return dataToReturn;
}
//TRAE VALOR DE UNIDAD MEDIDA PARA ENVASADO
$("#tdformmatprim").click(function(){
    console.log($(this).parents("tr").find("td").find("select").eq(0).val());
    var ins_id2 = $(this).parents("tr").find("td").find("select").eq(0).val();
    console.log(ins_id2);
    traeUnidad(ins_id2);
    $(this).parents("tr").find("td").find("input").eq(0).val(traeUnidad(ins_id2));
});
function traeUnidad(id_insumo){
    var route = 'trae_uni?ins_id='+id_insumo;
    var dataToReturn = "Error";
    $.ajax({
        url: route,
        type: "GET",
        async: false,
        success: function(data) {
            dataToReturn = data.umed_nombre;
        }
    });
    return dataToReturn;
}
</script>
@endpush
