<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myCreateSolReceta" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel">
                    REGISTRO NUEVA SOLICITUD POR RECETA
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                        {!! Form::open(['id'=>'proveedor', 'files' => true])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id" name="provid" type="hidden" value="">
                            <input id="cantidad_base" name="cantidad_base" type="hidden">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nombre Receta:
                                                </label>
                                                <select name="receta_nombre" id="receta_id" style="width: 100%" class="form-control"></select>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Cant:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('cant_min_solrec', null, array('placeholder' => 'Cant. minima','class' => 'form-control','id'=>'cant_min_solrec')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Cantidad Base de Receta:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('cantidad_base_det', null, array('placeholder' => 'Cantidad Base','class' => 'form-control','id'=>'cantidad_base_det', 'readonly')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    .....
                                                </label>
                                                <a class="btn btn-primary" id="botonCalculos">Calcular</a>
                                            </div>
                                        </div>
                                    </div>
                                                                
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Mercado:
                                                </label>
                                                <select class="form-control" name="sol_receta_mercado" id="sol_receta_mercado">
                                                    <option value="">Seleccione</option>
                                                    @foreach($mercado as $mer)
                                                        <option value="{{ $mer->merc_id }}">{{ $mer->merc_nombre }}</option>
                                                    @endforeach
                                                </select>  
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                                <br>                               
                                
                                <div class="form-group">
                                    
                                    <table  class="table table-hover small-text" id="TableRecetas">
                                        <thead>
                                            <tr>
                                                <th>Cod Insumo</th>
                                                <th>Insumo</th>
                                                <th>Unidad</th>
                                                <th>Cantidad</th>
                                                <!-- <th>Rango Adicional</th> -->
                                                <th></th>
                                                <th>Stock Actual</th>                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
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
                {!!link_to('#',$title='Enviar Solicitud', $attributes=['id'=>'registroSolicitudReceta','class'=>'btn btn-success','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
$('#receta_id').select2({
    dropdownParent: $('#myCreateSolReceta'),
    placeholder: "Selec. Receta",
    proveedor: true,
    tokenSeparators: [','],
    ajax: {
        dataType: 'json',
        url: '{{ url("getReceta") }}',
        delay: 250,
        data: function(params) {
            return {
                term: params.term
            }
        },
        processResults: function (data, page) {
            return {
            results: data
            };
        },
    },
    language: "es",
});
///COLOCANDO A LA TABLA LOS DATOS
var itemAux=[];
$('#receta_id').on('change', function(e){
    var receta_id = e.target.value;
    $.get('getDataReceta?rec_id='+receta_id, function(data){
      console.log(data[0].rec_cant_min);
      $("#cantidad_base").val(data[0].rec_cant_min);
      $("#cantidad_base_det").val(data[0].rec_cant_min+' '+data[0].rec_uni_base);
      $( "#TableRecetas tbody tr" ).each( function(){ this.parentNode.removeChild( this ); }); 

      var datosJson = JSON.parse(data[0].rec_data);

      console.log('Total item: '+datosJson.length);
        for (i = 0; i < datosJson.length; i++){

                 $("#TableRecetas").append('<tr class="items_columsReceta3">' + 
                    '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ datosJson[i].cod_ins + '"></input></td>'+
                    '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ datosJson[i].descripcion + '"></input></td>'+
                    '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ datosJson[i].unidad + '"></input></td>'+
                    '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ datosJson[i].cantidad+ '"></input></td>'+
                    '<td align="center" style="dislay: none;"><input type="hidden" name="nro[]" class="form-control" readonly value="'+ datosJson[i].rango_adicional + '"></input></td>'+
                    '<td align="center" style="dislay: none;"><input type="hidden" name="nro[]" class="form-control" readonly value="'+ datosJson[i].ins_id + '"></input></td></tr>');
            
        }
        itemAux = data[0].rec_data;
    });
});
$( "#botonCalculos" ).click(function() {
    if ($('#cant_min_solrec').val()>0) {
        var cantidadPed = $('#cant_min_solrec').val()/$('#cantidad_base').val();
        console.log(cantidadPed);
        itemsReceta3 = JSON.parse(itemAux);
        $( "#TableRecetas tbody tr" ).each( function(){ this.parentNode.removeChild( this ); });
        console.log('Total item: '+itemsReceta3.length);
        for (i = 0; i < itemsReceta3.length; i++){
                var stockActual={};
 
                function getstockActual(id)
                {
                    var res = JSON.parse($.ajax({
                        type: 'get',
                        url: "StockActual/"+id,
                        dataType: 'json',
                        async:false,
                        success: function(data)
                        {
                            return data;
                        }
                    }).responseText);

                    return res.stockal_cantidad;
                }
        
             $("#TableRecetas").append('<tr class="items_columsReceta3">' + 
                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ itemsReceta3[i].cod_ins + '"></input></td>'+
                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ itemsReceta3[i].descripcion + '"></input></td>'+
                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ itemsReceta3[i].unidad + '"></input></td>'+
                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ itemsReceta3[i].cantidad*cantidadPed + '"></input></td>'+
                // '<td align="center" style="dislay: none;"><input type="hidden" name="nro[]" class="form-control" readonly value="'+ itemsReceta3[i].rango_adicional*cantidadPed + '"></input></td>'+                
                '<td align="center" style="dislay: none;"><input type="hidden" name="nro[]" class="form-control" readonly value="'+ itemsReceta3[i].ins_id + '"></input></td>'+
                '<td align="center" style="dislay: none; background: red;"><input style="background: yellow;" type="text" name="nro[]" class="form-control" readonly value="'+getstockActual(itemsReceta3[i].ins_id)+'"></input></td>'+'</tr>');
        }
    }else{
        swal('Lo siento', 'La cantidad minima debe ser mayor a 0');
    }
    
});
</script>
@endpush