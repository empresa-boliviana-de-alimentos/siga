<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myUpdateReceta" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel">
                    MODIFICACIÓN RECETA
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                        {!! Form::open(['id'=>'receta', 'files' => true])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id" name="provid" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nombre Receta:
                                                </label>
                                                {!! Form::text('nombre_receta', null, array('placeholder' => 'Nombre de la Receta','class' => 'form-control','id'=>'nombre_receta', 'style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Base/Cant. Mínima:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('cant_minima', null, array('placeholder' => 'Cant. minima','class' => 'form-control','id'=>'cant_minima')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Unidad Base:
                                                </label>
                                                {!! Form::text('unidad_base', null, array('placeholder' => 'Unidad Base','class' => 'form-control','id'=>'unidad_base', 'style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Planta:
                                                </label>
                                                <!-- <select class="form-control" name="receta_planta" id="receta_planta">
                                                    <option>Seleccione</option>
                                                    @foreach($plantas as $planta)
                                                        <option value="{{ $planta->id_planta }}">{{ $planta->nombre_planta }}</option>
                                                    @endforeach
                                                </select> -->
                                                <input type="hidden" name="receta_planta" id="receta_planta" value="{{$planta->id_planta}}">
                                                <input type="text" class="form-control" value="{{$planta->nombre_planta}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Producción:
                                                </label>
                                                <select class="form-control" name="receta_produccion" id="receta_produccion">
                                                    <option value="">Seleccione</option>
                                                    @foreach($lineaTrabajo as $linea)
                                                        <option value="{{ $linea->ltra_id }}">{{ $linea->ltra_nombre }}</option>
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
                                                <select class="form-control" name="receta_mercado" id="receta_mercado">
                                                    <option value="">Seleccione</option>
                                                    @foreach($listarMercados as $mercado)
                                                        <option value="{{ $mercado->merc_id }}">{{ $mercado->merc_nombre }}</option>
                                                    @endforeach
                                                </select>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>                               
                                <div class="">
                                    <a href="javascript:void(0);" style="font-size:18px;" id="addMoreUpdate" title="Add More Person"><span class="btn btn-primary">Añadir Insumo</span></a>
                                </div>
                                <div class="form-group">
                                    
                                    <table  class="table table-hover small-text" id="tb">
                                        <tr class="tr-header">
                                            <th>Descripcion</th>
                                            <th>Unidad</th>
                                            <th>Cantidad</th>
                                            <th>Opcion</th>
                                            <!-- <th>Rango Adicional</th>                                             -->
                                        <tr class="items_columsReceta2">
                                            <td><select name="descripcion[]" class="form-control">
                                                    <option value="">Seleccione</option>
                                                    @foreach($listarInsumo as $insumo)
                                                        <option value="{{$insumo->ins_codigo.'+'.$insumo->ins_desc.'+'.$insumo->ins_id}}">{{ $insumo->ins_codigo.' - '.$insumo->ins_desc}}</option>
                                                    @endforeach
                                                </select>
                                            <td><select name="unidad[]" class="form-control">
                                                    <option value="">Seleccione</option>
                                                    @foreach($listarUnidades as $unidad)
                                                        <option value="{{$unidad->dat_nom}}">{{$unidad->dat_nom}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="text" name="cantidad[]" class="form-control"></td>
                                            <td><div class="text-center"><a href='javascript:void(0);'  class='removeUpdate btncirculo btn-md btn-danger'><i class="glyphicon glyphicon-remove"></i></a></div></td>
                                            <!-- <td><input type="text" name="rango[]" class="form-control"></td> -->
                                        </tr>
                                    </table>
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
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registroReceta','class'=>'btn btn-success','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<datalist id="insumosRece" width="80px">
@foreach($listarInsumo as $insumo)
    <option value="{{$insumo->ins_desc}}"></option>
@endforeach
</datalist> 

<datalist id="unidades" width="80px">
@foreach($listarUnidades as $unidad)
    <option value="{{$unidad->dat_nom}}"></option>
@endforeach
</datalist> 

@push('scripts')
<script type="text/javascript">

 $('#addMoreUpdate').on('click', function() {
              var data = $("#tb tr:eq(1)").clone(true).appendTo("#tb");
              data.find("input").val('');
     });
     $(document).on('click', '.removeUpdate', function() {
         var trIndex = $(this).closest("tr").index();
            if(trIndex>1) {
             $(this).closest("tr").remove();
           } else {
             swal('Lo siento','No puede borrar el unico item');
           }
      });
</script>
@endpush