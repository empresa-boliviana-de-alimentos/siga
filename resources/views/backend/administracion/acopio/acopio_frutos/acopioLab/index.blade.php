@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.acopio.acopio_frutos.acopioLab.partials.modalCreateLAB')
@include('backend.administracion.acopio.acopio_frutos.acopioLab.partials.modalListar')

<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
              <div class="col-md-1">
                <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('AcopioFrutosMenu') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
                </div>  
                <div class="col-md-8">
                     <h4><label for="box-title">Acopio Frutos Ingreso Laboratorio</label></h4>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading text-center">
        <h3 class="panel-title">
            <span>
                <i class="livicon" data-name="edit" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    LISTADO DE ACOPIO LABORATORISTA
            </span>
        </h3>
    </div>
    <div class="panel-body">
        <div id="sample_editable_1_wrapper" class="">
            <table class="table table-striped table-bordered table-hover dataTable no-footer" id="lts-recep" role="grid" style="width:100%"> 
                <thead class="table_head">
                    <tr>
                       {{--  <th class="" style="width:270px;">Opciones</th>
                        <th class="">Nombre Proveedor</th>
                        <th class="">Tipo Fruta</th>
                        <th class="">Cantidad Aprobada</th>
                        <th class="">Lote</th> --}}

                        <th class="" style="width:250px;">Opciones</th>
                        <th class="">Nombre Completo</th>
                        <th class="">CI</th>
                        <th class="">Tel</th>
                        <th class="">Planta</th>   
                    </tr>
               </thead>
           </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#lts-recep').DataTable( {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/AcopioFrutosLab/create",
            "columns":[
                {data: 'acciones', orderable: false, searchable: false},
                {data: 'nombreCompleto'},
                {data: 'prov_ci'},
                {data: 'prov_tel'},
                {data: 'nombre_planta'},
        ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
       
    });

     function Mostrardatlab(btn){
       var route = "/AcopioFrutosLab/"+btn.value+"/edit";
       // console.log(route);
        $.get(route, function(res){
            // $("#cod_prov").val(res.prov_id); 
            $("#prov_id1").val(res.prov_id);
            $("#nombre").val(res.prov_nombre+' '+res.prov_ap+' '+res.prov_am); 
            $("#cod_ci").val(res.prov_ci+' '+res.dep_exp);
            $("#cod_tel").val(res.prov_tel);
            $("#nombre_dep").val(res.dep_nombre);
            $("#rau").val(res.prov_rau); 
            var val =$("#rau").val();
            if (val==1) {
              $("#rau1").val('SI');
            }
            else
            {
              $("#rau1").val('NO');
            }
          });
    }

    function muestrafruta(){

        var fruta = document.getElementById('idtipofru').value;
        console.log(fruta);
        
        if (fruta==2 || fruta==3) {
              $('#datoaddcomp').show();
              $('#datoaddcomp1').show();
              $('#datoaddpiña').hide();
              }else{
                 $('#datoaddcomp').hide();
                 $('#datoaddcomp1').hide();
                 $('#datoaddpiña').hide();
                 if(fruta==1){
                  $('#datoaddpiña').show();
                  }else
                  {
                    $('#datoaddpiña').hide();
                  }
              }
    }

    $("#registro").click(function(){
        var route="/AcopioFrutosLab";
        var token =$("#token").val();
         if (document.getElementById('corona').checked) {
        rate_value = document.getElementById('corona').value;
        rate_value1 = document.getElementById('sincorona').value;
        rate_value1 = 0;
        console.log('valor',rate_value);
        console.log('valor111',rate_value1);
      }else{
        rate_value = document.getElementById('corona').value;
        rate_value = 0;
        rate_value1 = document.getElementById('sincorona').value;
        //rate_value1 = 0;
        console.log('valor',rate_value);
        console.log('valor111',rate_value1);
      }

        $('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'aco_id_prov':$("#prov_id1").val(),
                   'aco_obs' :$("#obs").val(),
                   // 'aco_cantidad' :$("#cant_aprob").val(),
                   'aco_tipo' :$('#idtipofru').val(),
                   'aco_estadofru' :$('#estadofru').val(),
                   'aco_variedad':$('#Variedad').val(),
                   'aco_lac_ph':$('#ph').val(),
                   'aco_lac_aci' :$('#acidez').val(),
                   'aco_fru_brix' :$('#brix').val(),
                   'aco_lac_grma':$('#madurez').val(),
                   'aco_fru_rel' :$('#rel').val(),
                   'aco_lac_asp' :$('#asp').val(),
                   'aco_lac_col' :$('#color').val(),
                   'aco_lac_olo' :$('#olor').val(),
                   'aco_lac_sab' :$('#sabor').val(),
                   'aco_fru_dm'  :$('#dm').val(),
                   'aco_fru_long' :$('#long').val(),
                   'aco_fru_lote' :$('#lote').val(),
                   'aco_fru_mues' :$('#aco_fru_mues').val(),
                  // 'aco_id_recep' :$('#resp').val(),
                   'aco_resp_calidad' :$('#resp').val(),

                   'aco_cant_rep' :$('#aco_fru_acep').val(),
                   'aco_variedad' :$('#Variedad').val(),
                   'aco_fru_calibre' :$('#cod_calibre').val(),
                   'aco_fru_tam' :$('#tam').val(),
                   'aco_fru_categoria' :$('#categoria').val(),

                   'aco_infestfru' :$('#aco_infestfru').val(),
                   'aco_olor' :$('#aco_olor').val(),
                   'aco_extrañosfru' :$('#aco_extrañosfru').val(),
                   'aco_nomchofer' :$('#aco_nomchofer').val(),
                   'aco_placa' :$('#aco_placa').val(),
                   'aco_fru_corona':rate_value,
                   'aco_fru_sincorona':rate_value1
               },
               success: function(data){
                    $("#myCreateLAB").modal('toggle');
                    swal("El Acopio!", "Se ha registrado correctamente!", "success");                    
                },
                error: function(result) {
                        swal("Opss..!", "Succedio un problema al registrar inserte bien los datos!", "error");
                }
        });
     
    });

     function Mostrarcalibre(){
        var idprv = document.getElementById('cod_calibre').value;
        console.log('es el id',idprv);
  
        var route = "AcopioFrutosLabfru/"+idprv+"";
         //console.log(route);
        $.get(route, function(res){
            $("#id_calibre").val(res.calibre_id);
            $("#codigo").val(res.codigo);
            $("#corona").val(res.corona);
            $("#sincorona").val(res.sincorona);
            $("#corona1").val(res.corona);
            $("#sincorona1").val(res.sincorona);
            var cod = $("#codigo").val();
            var cor = $("#corona").val();
            var sincor = $("#sincorona").val();
            console.log(cod);
          });
    }

</script>
@endpush
