<div class="modal fade modal-fade-in-scale-up" data-backdrop="static" data-keyboard="false" id="myListar" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    X
                </button>
                <h4 class="modal-title" id="modalLabelfade">
                    <center>LISTADO DE ACOPIO LACTEOS POR PROVEEDOR</center>
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                       {!! Form::open(['id'=>'acopio'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id" name="prsid" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-12">
                                         <div class="col-sm-12">
                                            <label>  PROVEEDOR:</label>  
                                           
                                            <input id="cod_prov1" name="cod_prov1" type="hidden" value="">
                                            <input id="cod_nom1" name="cod_nom1" disabled="true">
                                            <input id="cod_ap1" name="cod_ap1" disabled="true">
                                            <input id="cod_am1" name="cod_am1" disabled="true">                                 
                                        </div>
                                    </div>
                                    
                                </div>

                            </input>
                        </input>
                </div>
                <table class="table table-striped table-bordered table-hover dataTable no-footer" style="font-size:7" id="lts-acoprov">
                    <thead class="table_head">
                    <tr >
                        <th >No</th>
                        <th>Fecha</th>
                        <th>Hora</th>  
                        <th>Cant</th>
                        <th>Temp</th>
                        <th>SNG</th>
                        <th>PAL</th>
                        <th>Aspecto</th>
                        <th>Color</th>
                        <th>Olor</th>
                        <th>Sabor</th>
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
    function lstacopiolact(btn)
    {
        var route = "/AcopioLacteos/"+btn.value+"/edit";
        $.get(route, function(res){
            $("#cod_prov1").val(res.prov_id);
            $("#cod_nom1").val(res.prov_nombre);
            $("#cod_ap1").val(res.prov_ap);
            $("#cod_am1").val(res.prov_am);  
          });

        //document.getElementById('cod_prov1').value=btn.value;
        $('#lts-acoprov').DataTable( {
            "destroy":true,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/AcopioLacteos/lstAcopiosProvlact/"+btn.value,
            "columns":[
               // {data: 'accioness', orderable: false, searchable: false},
                {data: 'dac_id'},
                {data: 'dac_fecha_acop'},
                {data: 'dac_hora'},
                {data: 'dac_cant_uni'},
                {data: 'dac_tem'},
                {data: 'dac_sng'},
                {data: 'pruebaalco'},
                {data: 'aspecto'},
                {data: 'color'},
                {data: 'olor'},
                {data: 'sabor'},
        ],
        "language": {
            "url": "/lenguaje"
        },
         "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
        });
     
    }


</script>

@endpush