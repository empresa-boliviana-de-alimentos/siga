<div class="modal fade modal-fade-in-scale-up" data-backdrop="static" data-keyboard="false" id="myListar" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    X
                </button>
                <h4 class="modal-title" id="modalLabelfade">
                    <center>LISTADO DE ACOPIO FRUTOS POR PROVEEDOR</center>
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                       {!! Form::open(['id'=>'acopio'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id" name="prsid" type="hidden" value="">
                            <input id="cod_prov1" name="cod_prov1" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-6">
                                         <div class="col-sm-12">
                                            <label>  PROVEEDOR:</label>  
                                            <span class="block input-icon input-icon-right">
                                                {!! Form::text('cod_nom1', null, array('placeholder' => '','maxlength'=>'50','class' => 'form-control','id'=>'cod_nom1', 'disabled'=>'true')) !!}
                                            </span>                            
                                         </div>
                                    </div>
                                </div>

                            </input>
                        </input>
                </div>
                <table class="table table-striped table-bordered table-hover dataTable no-footer" style="font-size:7" id="lts-acoprov">
                    <thead class="table_head">
                    <tr >
                        <th>No</th>
                        <th>Fecha</th>
                        <th>Cantidad</th>  
                        <th>Descarte</th>
                        <th>Total Aprov</th>
                        <th>Precio Unitario</th>
                        <th>Precio Total Bs</th>
                        <th>BOLETA</th>
                    </tr>
                     </thead>
                </table>
            </div>
            
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" style="background:#8A0829" type="button">
                    Salir
                </button>
               <!-- <button class="btn btn-danger" data-dismiss="modal" style="background:#8A0829" type="button">
                    Imprimir Reporte
                </button>-->
                
            </div>
        </div>
    </div>
</div>


@push('scripts')
<script>
    //mostrar listado
    function lstacopiofru(btn)
    {
        var route ="/AcopioFrutos/"+btn.value+"/edit";
        $.get(route, function(res){
            $("#cod_prov1").val(res.prov_id);
            $("#cod_nom1").val(res.prov_nombre+' '+res.prov_ap+' '+res.prov_am);
          
             var codprov = $("#cod_prov1").val();
            console.log(codprov); 

        $('#lts-acoprov').DataTable( {
            "destroy":true,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/AcopioFrutos/lstAcopiosProvfrut/"+$("#cod_prov1").val(),
            "columns":[
               // {data: 'accioness', orderable: false, searchable: false},
                {data: 'dac_id'},
                {data: 'dac_fecha_acop'},
                {data: 'dac_cant_uni'},
                {data: 'dac_tot_descartefru'},
                {data: 'dac_cantaprob'},
                {data: 'dac_preciofru'},
                {data: 'total'},
                {data: 'acciones'}, 
            ],
        "language": {
            "url": "/lenguaje"
        },
         "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
        });

        });
     
    }


</script>

@endpush