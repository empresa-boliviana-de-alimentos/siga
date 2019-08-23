@extends('backend.template.app')
@section('main-content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
              <div class="col-md-1">
                <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('AcopioFrutosLab') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;ATRAS</h7></a>
                </div>  
                <div class="col-md-8">
                     <h4><label for="box-title">LISTADO DE ACOPIO FRUTOS DETALLE LABORATORIO</label></h4>
                </div>
                 <input type="" id="lab_id" name="lab_id" value="{{$lab_id}}">
            </div>
            </div>
        </div>
    </div>
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
                                <th class="sorting">Fecha</th>
                                <th class="sorting">Lote</th>
                                <th class="sorting">Cantidad de muestra</th>
                                <th class="sorting">Tipo Fruta</th>
                                <th class="sorting">Estado</th>
                            </tr>
                       </thead>
                   </table>
                </div>
            </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    lstAcopiosRecfru();
});
   function lstAcopiosRecfru()
    {
       console.log($("#lab_id").val());
        // var route = "/AcopioFrutosLab/"+btn.value+"/edit";
        // $.get(route, function(res){
        //     $("#cod_rec1").val(res.dac_id);
        //     $("#cod_nom1").val(res.prov_nombre+' '+res.prov_ap+' '+res.prov_am); 
        //     var dat = $("#cod_rec1").val();
        //     console.log(dat); 
        //   });

        //document.getElementById('cod_prov1').value=btn.value;
        $('#lts-detallelab').DataTable( {
            "destroy":true,
            "responsive": true,
            "processing": true,
            "serverSide": true,
             "ajax":{
               url : "/listarDetallelab/"+$("#lab_id").val(),
               type: "GET",
               data: {"lab_id": $("#lab_id").val()}
             },

            "columns":[
               // {data: 'accioness', orderable: false, searchable: false},
                // {data: 'aco_id'},
                {data: 'aco_fecha_acop'},
                {data: 'aco_fru_lote'},
                {data: 'aco_fru_mues'},
                {data: 'tipfr_nombre'},
                {data: 'estado'},
        ],
        "language": {
            "url": "/lenguaje"
        },
         "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "All"]],
        });
    
    }




    function  ListarmodulosDetalle() {
    console.log($("#recmod_id").val());
    $('#lts-proveedorDell').DataTable( {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax":{
               url : "/listarModDet/"+$("#recmod_id").val(),
               type: "GET",
               data: {"recmod_id": $("#recmod_id").val()}
             },

            // "ajax": "listarModuloCreate/"+$("#id_modulo").val()
            "columns":[
                {data: 'acciones'},
                // {data: 'recmod_id_mod'},
                {data: 'recmod_fecha'},
                {data: 'recmod_cant_recep'},
                {data: 'recmod_obs'},
                {data: 'turno'},
                {data: 'aceptacion'},
        ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
       
    });
}  
</script>
@endpush
