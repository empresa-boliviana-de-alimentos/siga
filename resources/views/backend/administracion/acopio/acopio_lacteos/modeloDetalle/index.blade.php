@extends('backend.template.app')
@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-1">
                <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('AcopioRecepcion') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;ATRAS</h7></a>
                </div>
                <div class="col-md-8">
                     <h4><label for="box-title">&nbsp;&nbsp; LISTA DETALLADA DE ACOPIO MODULO:  {{$modell_mod->modulo_nombre}}  {{$modell_mod->modulo_paterno}} {{$modell_mod->modulo_materno}}</label></h4>
                </div>
                <div class="col-md-2">
                </div>
                <input type="hidden" id="recmod_id" name="recmod_id" value="{{$recmod_id}}">
            </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border"></div>
                    <div class="box-body">
                        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-proveedorDell" style="width: 100%">
                            <thead class="cf">
                               <tr>
                                <th class="sorting"></th>
                                {{-- <th class="sorting">No</th> --}}
                                <th class="sorting">Fecha</th>
                                <th class="sorting">Cantidad</th>
                                <th class="sorting">Obs</th>
                                <th class="sorting">Turno</th>
                                <th class="sorting">Cert. Aceptacion</th>
                            </tr>
                            </thead>
                            <tr>
                            </tr>
                    </table>
                </div>    
            </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    ListarmodulosDetalle();
});
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