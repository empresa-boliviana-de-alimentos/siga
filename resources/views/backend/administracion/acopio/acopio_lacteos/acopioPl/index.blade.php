@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.acopio.acopio_lacteos.acopioPl.partials.modalCreate')
@include('backend.administracion.acopio.acopio_lacteos.acopioPl.partials.modalVerCreate')
{{-- <div class="box box-default box-solid"> --}}
    <div class="box-header with-border">
        <div class="col-md-1">
                <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('acopio_lacteos') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
        </div>  
        <!-- <div class="col-md-1">
            <a class="btn btn-primary" href="BoletaAcopiodiaPlan" target="_blank" class="btn btn-primary fa fa-print">Generar Reporte Diario</a>
        </div> -->
        <td><center> <h2>Acopios Lacteos Control de Calidad  </h2></center><td>
          <div class="btn pull-right col-md-4">
            <a href="BoletaAcopiodiaConCal" target="_blank" class="btn btn-primary btn-lg fa fa-file-pdf-o" style="color:#ffffff"> Generar Reporte Diario</a>
          </div>
    </div>
{{-- </div> --}}
<div class="panel panel-danger table-edit">
    
    <div class="panel-body">
        <div id="sample_editable_1_wrapper" class="">
            <table class="table table-striped table-bordered table-hover dataTable no-footer" id="lts-recep" role="grid" style="width: 100%"> 
                <thead class="table_head">
                    <tr>
                        <th class="sorting">Opciones</th>
                        <th class="sorting">Fecha</th>
                        <th class="sorting">Nombre Recep.</th>
                        <th class="sorting">Cantidad Leche (Lts)</th>
                        <th class="sorting">Observaciones</th>
                        <th class="sorting">PLANTA</th>
                                              
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
            "ajax": "/AcopioLacteosPlantas/create",
            "columns":[
                {data: 'acciones', orderable: false, searchable: false},
                {data: 'detlac_fecha'},
                {data: 'nombreCompleto'},
                // {data: 'modulo_ci'},
                // {data: 'modulo_estado'},
                {data: 'detlac_cant'},
                {data: 'detlac_obs'},
                {data: 'planta'},
        ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
       
    });

    /*$("#registro").click(function(){
        var route="/AcopioLacteos";
        var token =$("#token").val();
        //$('#myCreate').html('<div><img src="../img/ajax-loader.gif"/></div>');
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {'cod_prov':$("#cod_prov").val(),
                   'aco_apr' :$("#aco_apr").val(),
                   'aco_hrs' :$("#aco_hrs").val(),
                   'aco_can' :$('#aco_can').val(),
                   'aco_obs' :$('#aco_obs').val(),
                   'aco_tenv':$('#aco_tenv').val(),
                   'aco_cond':$('#aco_cond').val(),
                   'aco_tem' :$('#aco_tem').val(),
                   'aco_sng' :$('#aco_sng').val(),
                   'aco_palc':$('#aco_palc').val(),
                   'aco_asp' :$('#aco_asp').val(),
                   'aco_col' :$('#aco_col').val(),
                   'aco_olo' :$('#aco_olo').val(),
                   'aco_sab' :$('#aco_sab').val()},
               success: function(data){
                    $("#myCreateRCA").modal('toggle');
                    swal("El Acopio!", "Se ha registrado correctamente!", "success");                    
                },
                error: function(result) {
                        swal("Opss..!", "Succedio un problema al registrar inserte bien los datos!", "error");
                }
        });
    });
*/

 //FUNCION QUE PERMITE MOSTRAR EL NOMBRE DEL PROVEEDOR EN LISTADO   
  /*  function MostrarCantidades(){
        var route = "/AcopioLacteos/sumacantleche";
        $.get(route, function(res){
            $("#cod_usu").val(res.usr_id);
            $("#cod_nomb").val(res.usr_usuario);
           // $("#cod_ap1").val(res.prov_ap);
            //$("#cod_am1").val(res.prov_am); 
          });
    }*/
  

  $("#registroaco").click(function(){
        var route="/AcopioLacteosPlantas";
        var token =$("#token").val();
        // var asig =$("#lab_cant").val();
        // var cantidad = parseFloat(asig);
        // console.log(cantidad);
       // var cantidad = document.getElementById('lab_cant').value;
      //  var cant1 = cantidad;

        // var cant = document.getElementById('lab_cant_rep').value;
        // var cant1 = parseFloat(cant);
        // console.log(cant1);

        // if(cant1 > cantidad)
        // {
        //     //console.log(cantidad);
        //     //console.log(cant);
        // swal('La cantidad es mayor!!!!!');
        //     return;
        // }else{ 
        //     if(cant<0){
        //         swal('La cantidad es negativa!!!!!');
        //         return;
        //     }else{

                $.ajax({
                    url: route,
                    headers: {'X-CSRF-TOKEN': token},
                    type: 'POST',
                    dataType: 'json',
                    data: {
                           'lab_detlac_id'  :$("#idrec").val(),
                           'lab_rec'  :$("#lab_rec").val(),
                           'certificacion_aceptacion'  :$("#lab_apr").val(),
                           'lab_cant' :$("#lab_cant").val(),
                           'condiciones_higiene' :$('#lab_cond').val(),
                           'tram'  :$('#lab_tra').val(),
                           'responsable_analisis'  :$('#lab_enc').val(),
                           'lab_obs'  :$('#lab_obs').val(),
                           'temperatura'  :$('#lab_tem').val(),
                           'acidez'  :$('#lab_aci').val(),
                           'ph'   :$('#lab_ph').val(),
                           'sng'  :$('#lab_sng').val(),
                           'densidad'  :$('#lab_den').val(),
                           'materia_grasa' :$('#lab_mgra').val(),
                           'prueba_alcohol' :$('#lab_palc').val(),
                           'prueba_antibiotico' :$('#lab_pant').val(),
                           'aspecto'  :$('#lab_asp').val(),
                           'color'  :$('#lab_col').val(),
                           'olor'  :$('#lab_olo').val(),
                           'sabor'  :$('#lab_sab').val(),
                           'cantidad_recep'  :$('#lab_cant_rep').val(),
                           'id_modulo':$('#idrec').val()},
                       success: function(data){
                            $("#myCreatePl").modal('toggle');
                            swal("El Acopio!", "Se ha registrado correctamente!", "success");  
                            $('#lts-recep').DataTable().ajax.reload();                  
                        },
                        error: function(result) {
                            var errorCompleto='Tiene los siguientes errores: ';
                            $.each(result.responseJSON.errors,function(indice,valor){
                               errorCompleto = errorCompleto + valor+' ' ;                       
                            });
                            swal("Opss..., Hubo un error!",errorCompleto,"error");
                        }
                });
            // }
        // }
    });



//FUNCION QUE PERMITE MOSTRAR EL NOMBRE DEL PROVEEDOR EN REGISTRO
    function Mostrardat(btn){
        var route = "/AcopioLacteosPlantas/"+btn.value+"/edit";
        console.log('esto es', btn.value);
        $.get(route, function(res){
          console.log(res);
             $("#idrec").val(res.detlac_id);
             $("#lab_rec").val(res.prs_nombres+' '+res.prs_paterno+' '+res.prs_materno);
             $("#lab_cant").val(res.detlac_cant);
            // if (res.cantidad_total == null) {
            //   console.log("Es nulo");
            //   $("#lab_cant").val(0);
            //   $("#lab_rec").val(res.recepcionista);
            //   $("#id_modulo_recep").val(res.id_modulo);
            // }else{
            //   $("#lab_cant").val(res.cantidad_total);
            //   $("#lab_rec").val(res.recepcionista);
            //   $("#id_modulo_recep").val(res.id_modulo);
            // }
            //$("#lab_id_rec").val(res.detlac_id_rec);
            //$("#cod_am").val(res.prov_am); 
          });
    }

     function MostrardatosLab(btn){
        var route = "/AcopioLacteosLabVer/"+btn.value+"/";
        console.log('esto es del lab', btn.value);
        $.get(route, function(res){
          console.log(res);
             // $("#idrec").val(res.detlac_id);
             // $("#lab_rec").val(res.prs_nombres+' '+res.prs_paterno+' '+res.prs_materno);
             $("#idetlac1").val(res.aco_detlac_id)
             $("#lab_rec1").val(res.prs_nombres+' '+res.prs_paterno+' '+res.prs_materno)
             $("#lab_apr1").val(res.aco_cert)
             $("#lab_hr1").val(res.aco_fecha_reg)
             $("#lab_cant1").val(res.aco_cantidad)
             $("#lab_cond1").val(res.aco_con_hig)
             $("#lab_tra1").val(res.aco_tram)
             $("#lab_enc1").val(res.aco_resp_calidad)
             $("#lab_obs1").val(res.aco_obs)
             $("#lab_tem1").val(res.aco_lac_tem)
             $("#lab_aci1").val(res.aco_lac_aci)
             $("#lab_ph1").val(res.aco_lac_ph)
             $("#lab_sng1").val(res.aco_lac_sng)
             $("#lab_den1").val(res.aco_lac_den)
             $("#lab_mgra1").val(res.aco_lac_mgra)
             $("#lab_palc1").val(res.aco_lac_palc)
             $("#lab_pant1").val(res.aco_lac_pant)
             $("#lab_asp1").val(res.aco_lac_asp)
             $("#lab_col1").val(res.aco_lac_col)
             $("#lab_olo1").val(res.aco_lac_olo)
             $("#lab_sab1").val(res.aco_lac_sab)
          });
    }
     

</script>
@endpush
