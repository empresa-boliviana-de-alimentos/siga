<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="formEvaluacion" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel">
                    Evaluacion Proveedor
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                        {!! Form::open(['id'=>'proveedor'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="prov_id_eval" name="provid" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nombre Proveedor:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('nombre', null, array('placeholder' => 'Ingrese Nombre','class' => 'form-control','id'=>'nombre_proveedor', 'style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();','readonly'=>'true')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                    
                                 
                                </div>
                                <br>  
                                <strong><h5 class="modal-title" style="color:#8a6d3b">Evaluación</h5></strong>       
                                
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table">
                                            <tr>
                                                <th class="text-center">Criterios de Evaluación</th>
                                                <th class="text-center">Ponderación</th>
                                                <th class="text-center">Calificación</th>
                                                <th class="text-center">Puntos</th>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Costo de Aprovisionamiento</th>
                                                <td class="text-center">25</th>
                                                <td class="text-center"><input type="number" name="costo_aprob" id="costo_aprob" class="form-control" onkeyup="calculos();"></th>
                                                <td class="text-center"><input type="text" name="puntos_costo_aprob" id="puntos_costo_aprob" class="form-control" readonly onkeyup="calculos();"></th>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Fiabilidad</th>
                                                <td class="text-center">10</th>
                                                <td class="text-center"><input type="number" name="fiabilidad" id="fiabilidad" class="form-control" onkeyup="calculos();"></th>
                                                <td class="text-center"><input type="number" name="puntos_fiabilidad" id="puntos_fiabilidad" class="form-control" onkeyup="calculos();" readonly></th>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Imagen</th>
                                                <td class="text-center">10</th>
                                                <td class="text-center"><input type="number" name="imagen" id="imagen" class="form-control" onkeyup="calculos();"></th>
                                                <td class="text-center"><input type="number" name="puntos_imagen" id="puntos_imagen" class="form-control" onkeyup="calculos();" readonly=""></th>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Calidad</th>
                                                <td class="text-center">20</th>
                                                <td class="text-center"><input type="number" name="calidad" id="calidad" class="form-control" onkeyup="calculos();" ></th>
                                                <td class="text-center"><input type="number" name="puntos_calidad" id="puntos_calidad" class="form-control" onkeyup="calculos();" readonly></th>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Cumplimiento de Plazos</th>
                                                <td class="text-center">20</th>
                                                <td class="text-center"><input type="number" name="plazos" id="plazos" class="form-control" onkeyup="calculos();" ></th>
                                                <td class="text-center"><input type="number" name="puntos_plazos" id="puntos_plazos" class="form-control" onkeyup="calculos();" readonly></th>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Condiciones de Pago</th>
                                                <td class="text-center">5</th>
                                                <td class="text-center"><input type="number" name="pagos" id="pagos" class="form-control" onkeyup="calculos();" ></th>
                                                <td class="text-center"><input type="number" name="puntos_pagos" id="puntos_pagos" class="form-control" onkeyup="calculos();" readonly></th>
                                            </tr>
                                            <tr>
                                                <td class="text-center">Capacidad de Cooperación</th>
                                                <td class="text-center">5</th>
                                                <td class="text-center"><input type="number" name="cooperacion" id="cooperacion" class="form-control" onkeyup="calculos();"></th>
                                                <td class="text-center"><input type="number" name="puntos_cooperacion" id="puntos_cooperacion" class="form-control" onkeyup="calculos();" readonly></th>
                                            </tr>
                                             <tr>
                                                <td class="text-center">Flexibilidad</th>
                                                <td class="text-center">5</th>
                                                <td class="text-center"><input type="number" name="flexibilidad" id="flexibilidad" class="form-control" onkeyup="calculos();"></th>
                                                <td class="text-center"><input type="number" name="puntos_flexibilidad" id="puntos_flexibilidad" class="form-control" onkeyup="calculos();" readonly></th>
                                            </tr>
                                            <tr>
                                                <td class="text-center">TOTALES</th>
                                                <td class="text-center">100</th>
                                                <td class="text-center">-</th>
                                                <td class="text-center"><input type="number" name="puntos_totales" id="puntos_totales" class="form-control" onkeyup="calculos();" readonly></th>
                                            </tr>
                                            <tr>
                                                <td class="text-center">PUNTOS</th>
                                                <td class="text-center">-</th>
                                                <td class="text-center">-</th>
                                                <td class="text-center"><input type="number" name="puntos_puntos" id="puntos_puntos" class="form-control" onkeyup="calculos();" readonly></th>
                                            </tr>
                                            <tr>
                                                <td class="text-center">PORCENTAJE %</th>
                                                <td class="text-center">-</th>
                                                <td class="text-center">-</th>
                                                <td class="text-center"><input type="number" name="puntos_porcentaje" id="puntos_porcentaje" class="form-control" onkeyup="calculos();" readonly></th>
                                            </tr>
                                        </table>
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
                {!!link_to('#',$title='Registrar Evaluación', $attributes=['id'=>'registroProvEval','class'=>'btn btn-success','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    function calculos()
    {
        //console.log("SDFADSF");
        var total_costo_aprob = $("#costo_aprob").val()*25;
        $("#puntos_costo_aprob").val(total_costo_aprob);
        var total_fiabilidad = $("#fiabilidad").val()*10;
        $("#puntos_fiabilidad").val(total_fiabilidad);
        var total_imagen = $("#imagen").val()*10;
        $("#puntos_imagen").val(total_imagen);
        var total_calidad = $("#calidad").val()*20;
        $("#puntos_calidad").val(total_calidad);
        var total_plazos = $("#plazos").val()*20;
        $("#puntos_plazos").val(total_plazos);
        var total_pagos = $("#pagos").val()*5;
        $("#puntos_pagos").val(total_pagos);
        var total_cooperacion = $("#cooperacion").val()*5;
        $("#puntos_cooperacion").val(total_cooperacion);
        var total_flexibilidad = $("#flexibilidad").val()*5;
        $("#puntos_flexibilidad").val(total_flexibilidad);
        var total_puntos = total_costo_aprob+total_fiabilidad+total_imagen+total_calidad+total_plazos+total_pagos+total_cooperacion+total_flexibilidad;
        $("#puntos_totales").val(total_puntos);
        var total_cali = $("#costo_aprob").val()+$("#fiabilidad").val()+$("#imagen").val()+$("#calidad").val()+$("#plazos").val()+$("#pagos").val()+$("#cooperacion").val()+$("#flexibilidad").val();
        $("#totales").val(total_cali);
        var puntos_puntos = total_puntos/100;
        $("#puntos_puntos").val(puntos_puntos);
        var puntos_porcentaje = (puntos_puntos/5)*100;
        $("#puntos_porcentaje").val(puntos_porcentaje);
    }
</script>
@endpush

 

