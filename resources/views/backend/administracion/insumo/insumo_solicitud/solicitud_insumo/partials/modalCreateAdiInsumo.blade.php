<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myCreateInsumoAd" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel">
                    SOLICITUD POR ADICION INSUMO
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                        {!! Form::open(['id'=>'proveedor', 'files' => true])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id" name="provid" type="hidden" value="">
                            <input type="hidden" name="aprsol_id" id="aprsol_id" value="">
                            <input type="hidden" name="aprsol_cod_solicitud" id="aprsol_cod_solicitud" value="">
                            <input type="hidden" name="rec_id" id="rec_id" value="">
                            <input type="hidden" name="merc_id" id="merc_id" value="">
                                <div class="row">
                                    <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nro Lote:
                                                </label>
                                                {!! Form::text('soladi_num_lote', null, array('placeholder' => 'Nro Lote','class' => 'form-control','id'=>'soladi_num_lote', 'style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nro Salida:
                                                </label>
                                                {!! Form::text('soladi_num_salida', null, array('placeholder' => 'Nro Salida','class' => 'form-control','id'=>'soladi_num_salida', 'style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Numero Solicitud de Salida:
                                                </label>
                                                <select name="soladi_id_nrosol" id="soladi_id_nrosol" style="width: 100%" class="form-control"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nombre de Receta:
                                                </label>
                                                {!! Form::text('nombre_receta', null, array('placeholder' => 'Cant. minima','class' => 'form-control','id'=>'nombre_receta','readonly')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Solicitante:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('nombre_solicitante', null, array('placeholder' => 'Cant. minima','class' => 'form-control','id'=>'nombre_solicitante','readonly')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Mercado:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('nombre_mercado', null, array('placeholder' => 'Cant. minima','class' => 'form-control','id'=>'nombre_mercado','readonly')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>                                   
                                </div>
                                <br>                               
                                
                                <div class="form-group">                                
                                    <table  class="table table-hover small-text" id="TableSolAdi">
                                        <thead>
                                            <tr>
                                                <th>Cod Insumo</th>
                                                <th>Insumo</th>
                                                <th>Unidad</th>
                                                <th>Cantidad</th>
                                                <!-- <th>Rango Adicional</th> -->
                                                <th>Cantidad Adicional</th>
                                                <th>Observacion</th>
                                                <th></th>
                                                <th>Stock Actual</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>                                
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label>
                                                Observación General (Justificante)
                                            </label>
                                            <textarea id="soladi_obs" class="form-control"></textarea>
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
                {!!link_to('#',$title='Enviar Solicitud', $attributes=['id'=>'registroSolAdicional','class'=>'btn btn-success','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
$('#soladi_id_nrosol').select2({
    dropdownParent: $('#myCreateInsumoAd'),
    placeholder: "Selec. Nro Salida",
    proveedor: true,
    tokenSeparators: [','],
    ajax: {
        dataType: 'json',
        // url: '{{ url("getReceta") }}',
        url: '{{ url("getNotaSal") }}',
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

var itemAux=[];
$('#soladi_id_nrosol').on('change', function(e){
    var notasal_id = e.target.value;
    $.get('getDataNotaSal?notasal_id='+notasal_id, function(data){
      console.log(data);
      $("#nombre_mercado").val(data[0].merc_nombre);
      $("#nombre_solicitante").val(data[0].prs_nombres+' '+data[0].prs_paterno+' '+data[0].prs_materno);
      $("#nombre_receta").val(data[0].rec_nombre);
      $("#aprsol_id").val(data[0].aprsol_id);
      $("#aprsol_cod_solicitud").val(data[0].aprsol_cod_solicitud);
      $("#rec_id").val(data[0].rec_id);
      $("#merc_id").val(data[0].merc_id);
      $( "#TableSolAdi tbody tr" ).each( function(){ this.parentNode.removeChild( this ); }); 

      var datosJson = JSON.parse(data[0].aprsol_data);
      console.log('Total item: '+datosJson.length);
        for (i = 0; i < datosJson.length; i++){
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
             $("#TableSolAdi").append('<tr class="items_columsSolAdi">' + 
                '<td align="center" width="120px" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ datosJson[i].codigo_insumo + '"></input></td>'+
                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ datosJson[i].descripcion_insumo + '"></input></td>'+
                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ datosJson[i].unidad + '"></input></td>'+
                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ datosJson[i].cantidad+ '"></input></td>'+
                // '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" readonly value="'+ datosJson[i].rango_adicional + '"></input></td>'+
                '<td align="center" style="dislay: none;"><input type="number" name="nro[]" class="form-control" value="0"></input></td>'+
                '<td align="center" style="dislay: none;"><input type="text" name="nro[]" class="form-control" value=""></input></td>'+
                '<td align="center" style="dislay: none;"><input type="hidden" name="nro[]" class="form-control" value="'+datosJson[i].id_insumo+'"></input></td>'+
                '<td align="center" style="dislay: none; background: red;"><input style="background: yellow;" type="text" name="nro[]" class="form-control" readonly value="'+getstockActual(datosJson[i].id_insumo)+'"></input></td>'+'</tr>');
        }
        itemAux = data[0].aprsol_data;
    });
});

</script>
@endpush