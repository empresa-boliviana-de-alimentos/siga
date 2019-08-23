@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.acopio.acopio_almendra.gbSolicitudes.partials.modalCreate')
@include('backend.administracion.acopio.acopio_almendra.gbSolicitudes.partials.modalUpdate')
@include('backend.administracion.acopio.acopio_almendra.gbSolicitudes.partials.modalCreatePre')
<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-1">
                <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ url('AcopioAlmendraMenu') }}"><span class="fa fas fa-align-justify" style="background: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;MENU</h7></a>
                </div>

                <div class="col-md-8">
                     <h4><label for="box-title">SOLICITUDES ALMENDRA</label></h4>
                </div>
                <div class="col-md-2">
                </div>
                <?php
                    $idrol=Session::get('ID_ROL');
                ?>
                <div class="col-md-2">
                    @if($idrol==1 or $idrol==2 or $idrol==9 or $idrol==13)
                <button class="btn btn-warning" data-target="#myCreateSol" data-toggle="modal" style="background:#7ACCCE" type="button">
                    <i class="fa fa-plus">
                    </i>
                    Nuevo
                </button>
                @endif 


                </div>
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

                        <div id="no-more-tables">
                                <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-solicitud" style="width:100%">
                                    <thead class="cf">
                                        <tr>
                                            <th>
                                                Solicitante
                                            </th>
                                            <th>
                                                Solicitud
                                            </th>
                                            <th>
                                                Detalle
                                            </th>
                                            <th>
                                                Monto Solicitado
                                            </th>
                                            <th>
                                                Fecha Solicitud
                                            </th>
                                            <th>
                                                Fecha Asignación
                                            </th>
                                            <th>
                                                Monto Asignado
                                            </th>
                                            <th>
                                                ...
                                            </th>
                                        </tr>
                                    </thead>
                                    <tr>
                                    </tr>
                                </table>
                        </div>
                    </div>
            </div>
        </div>
</div>
@endsection

@push('scripts')

<script>

    $('#lts-solicitud').DataTable( {
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/SolicitudA/create/",
            "columns":[
                {data: 'usr_usuario'},
                {data: 'sol_id'},
                {data: 'sol_detalle'},
                {data: 'sol_monto'},
                {data: 'sol_fecha_reg'},
                {data: 'asig_fecha_reg'},
                {data: 'asig_monto'},
                {data: 'estado'},
        ],
        
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
       
    });

     
    function MostrarRegistroAsig(btn){
            var route = "/SolicitudA/"+btn.value+"/edit";
            $.get(route, function(res){
                 $("#sol_id1").val(res.sol_id);
                 $("#sol_fecha_reg1").val(res.sol_fecha_reg);
                 $("#sol_monto1").val(res.sol_monto);
                 $("#sol_id_usr1").val(res.sol_id_usr);
                 //$("#sol_nombre").val(res.prs_nombres+' '+res.prs_paterno+' '+res.prs_materno);
                 $("#sol_nombre").val(res.usr_usuario);
                 var val = $("#sol_id1").val();
                 console.log (val);
            });
        }
//obtiene datos de montos solicitados
    function MostrarRegistroAsig2(btn){
            var route = "SolicitudAsoleditar/"+btn.value+"";
            console.log ('resultado id',route);

           // var id2=btn.value;
              // console.log ('resultado id',id2);
          //  $("#sol_id2") = id2;

             //  .val(res.sol_id);
            $.get(route, function(res){
                 $("#sol_id2").val(res.sol_id);
                 $("#sol_fecha_reg2").val(res.sol_fecha_reg);
                 $("#sol_monto2").val(res.sol_monto);
                 $("#sol_detalle2").val(res.sol_detalle);
                 var val = $("#sol_id2").val();
                 console.log ('resultado',val);
            });
        }

        function Limpiar(){
        $("#sol_id1").val("");$("#asig_monto").val("");$("#asig_fecha").val("");$("#asig_obs").val("");$("#asig_fecha_reg").val("");
        }

        $("#registroAsignacion").click(function(){
            var value =$("#sol_id1").val();
            var route="/SolicitudA/"+value+"";
            var token =$("#token").val();
            var monto = document.getElementById('asig_monto').value
            var asig =$("#sol_monto1").val();

            if(monto > asig ){
               alert('El monto es mayor a lo solicitado');
               return;
            }else{
                swal({   title: "Confirmacion de Asignacion de Dinero",
                  text: "Usted esta seguro del monto Asignado?",
                  type: "warning",   
                  showCancelButton: true,
                  confirmButtonColor: "#28A345",
                  confirmButtonText: "Enviar!",
                  closeOnConfirm: true
                },function(){
                    $.ajax({
                    url: route,
                    headers: {'X-CSRF-TOKEN': token},
                    type: 'PUT',
                    dataType: 'json',
                    data: {
                    'asig_id_sol':$("#sol_id1").val(),
                    'asig_monto':$("#asig_monto").val(),
                    'asig_fecha':$("#asig_fecha").val(),
                    'asig_obs':$("#asig_obs").val(),
                    'asig_fecha_reg':$("#asig_fecha").val(),
                    'asig_id_comp':$("#sol_id_usr1").val(),      
                    },
                    success: function(data){
                        $("#myCreatePre").modal('toggle');Limpiar();
                        swal("Acceso!", "registro correcto","success");
                        $('#lts-solicitud').DataTable().ajax.reload();
                    },
                    error: function(result)
                    {
                    swal("Opss..!", "Error al registrar el dato", "error");
                    }
                });
            });
            } 
            
        });

        function LimpiarSol(){
        $("#sol_detalle").val("");$("#sol_centr_acopio").val("");$("#sol_monto").val("");$("#id_municipio").val("");$("#asig_fecha_reg").val("");
        }

        $("#registroSolicitud").click(function(){
            var route="/SolicitudA";
            var token =$("#token").val();
            swal({   title: "Confirmacion de Solicitud de Dinero",
              text: "Usted esta seguro del monto solicitado?",
              type: "warning",   
              showCancelButton: true,
              confirmButtonColor: "#28A345",
              confirmButtonText: "Enviar!",
              closeOnConfirm: true
            },function(){
                $.ajax({
                    url: route,
                    headers: {'X-CSRF-TOKEN': token},
                    type: 'POST',
                    dataType: 'json',
                    data: {
                    'sol_detalle':$("#sol_detalle").val(),
                    'sol_centr_acopio':$("#sol_centr_acopio").val(),
                    'sol_monto':$("#sol_monto").val(),
                    'sol_id_mun':$("#id_municipio").val(),
                    },
                    success: function(data){
                        $("#myCreateSol").modal('toggle');LimpiarSol();
                        swal("Solicitud!", "registro correcto","success");
                        $('#lts-solicitud').DataTable().ajax.reload();
                    },
                    error: function(result)
                    {
                    swal("Opss..!", "Error al registrar el dato", "error");
                    }
                });
            });    
        });

        $("#actualizarSol").click(function(){
        var value = $("#sol_id2").val();
        //console.log(value);
        var route="../SolicitudAsol/"+value+"";
        var token =$("#token").val();
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',
            dataType: 'json',
            data: {
                    'sol_detalle':$("#sol_detalle2").val(),
                    'sol_monto':$("#sol_monto2").val(),
                  },
                        success: function(data){
                $("#myUpdateSol").modal('toggle');
                swal("Solicitud!", "edicion exitosa!", "success");
                $('#lts-solicitud').DataTable().ajax.reload();

            },  error: function(result) {
                 swal("Opss..!", "Edicion rechazada", "error")
            }
        });
        });
</script>
<script type="text/javascript">
    $('.datepicker').datepicker({
                format: "yyyy-mm-dd",
                language: "es",
                autoclose: true
            });
        
            var fecha= new Date();
            var vDia; 
            var vMes;

            if ((fecha.getMonth()+1) < 10) { vMes = "0" + (fecha.getMonth()+1); }
            else { vMes = (fecha.getMonth()+1); }

            if (fecha.getDate() < 10) { vDia = "0" + fecha.getDate(); }
            else{ vDia = fecha.getDate(); }
</script>
@endpush