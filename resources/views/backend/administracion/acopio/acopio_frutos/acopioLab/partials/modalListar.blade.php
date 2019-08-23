<div class="modal fade modal-fade-in-scale-up" data-backdrop="static" data-keyboard="false" id="myListaDetalleLab" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    X
                </button>
                <h4 class="modal-title" id="modalLabelfade">
                    <center>LISTADO DE ACOPIO FRUTOS DETALLE LABORATORIO</center>
                </h4>
            </div>
             <div class="panel-body">
               <!-- <div class="caption">
                       {!! Form::open(['id'=>'acopio'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="cod_rec1" name="cod_rec1" type="hidden" value="">
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
                </div>-->
                <div id="sample_editable_1_wrapper" class="">
                    <table class="table table-striped table-bordered table-hover dataTable no-footer" id="lts-detallelab" role="grid"> 
                        <thead class="table_head">
                            <tr>
                                <th class="sorting">#</th>
                                <th class="sorting">Nombre Proveedor</th>
                                <th class="sorting">Lote</th>
                                <th class="sorting">Cantidad Aprobada</th>
                                <th class="sorting">Tipo Fruta</th>
                                <th class="sorting">Estado</th>
                            </tr>
                       </thead>
                   </table>
                </div>
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

  function lstacopiofrutPlanta(btn)
    {
        var route = "/AcopioFrutosLab/"+btn.value+"/edit";
        $.get(route, function(res){
            $("#cod_rec1").val(res.dac_id);
            $("#cod_nom1").val(res.prov_nombre+' '+res.prov_ap+' '+res.prov_am); 
            var dat = $("#cod_rec1").val();
            console.log(dat); 
          });

        //document.getElementById('cod_prov1').value=btn.value;
        $('#lts-detallelab').DataTable( {
            "destroy":true,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/AcopioFrutosLab/lstAcopiosRecfru/"+btn.value,
            "columns":[
               // {data: 'accioness', orderable: false, searchable: false},
                {data: 'aco_id'},
                {data: 'nombrecompleto'},
                {data: 'aco_fru_lote'},
                {data: 'aco_cantidad'},
                {data: 'tipfr_nombre'},
                {data: 'estado'},
        ],
        "language": {
            "url": "/lenguaje"
        },
         "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
        });
    
    }


</script>

@endpush