<div class="modal fade modal-default" id="modalReglas" data-backdrop="static" data-keyboard="false" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12 container-fluit">
            <div class="panel panel-info">
              <div class="panel-heading">
                <h4>
                    <small>
                    <!--<div class="btn-group pull-right" data-toggle="buttons">
                    <label class="btn btn-default" data-dismiss="modal">Cerra</label>
                    <label class="btn btn-primary" onclick="modificarEjecutar();">Actualizar</label>
                    <label class="btn btn-warning" onclick="ejecutarRegaNegocio();">Ejecutar</label>
                    </div>-->
                    <div class="pull-right"><button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <a type = "button" class = "btn btn-primary" id="reglaActualizar" onclick="modificarEjecutar();">Actualizar</a>
                    <button type = "button" class = "btn btn-warning" id="reglallamar" onclick="ejecutarRegaNegocio();">Ejecutar</button></div></small>
                    Ejecutar Regla de Negocio
                </h4>
                <input id="tipo" name="hid" type="hidden">
                <input id="cant" name="hid" type="hidden">
              </div>
            </div>
              <div class="panel-body">
                 {!! Form::open(['class'=>'form-horizontal','id'=>'niveles'])!!}
                  <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <div class="col-md-10" >
                            <label class="control-label col-md-4">
                                Reglas de Negocio:
                            </label>
                            <div class="col-md-8">
                                <div id="datoscombo"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="cargaregla"></div>
                    </div> 
                    <div class="form-group">
                      <h4 style="color:#0B610B" align="center">Resultado</h4><HR>
                      <div id="cargacodigo"></div>
                    </div>
                  </input> 
                {!! Form::close() !!}
              </div>
          </div>
        </div>
        
      </div>
      
    </div>
  </div>
</div>
@push('scripts')
<script>

  function SeleccionarReglas()
    {
      var htmlUnidades='';
      $.ajax({
            url: "v1_0/reglaNegocio/get_Combo",
            headers: {'X-CSRF-TOKEN': $("#token").val()},
            type: 'GET',
            dataType: 'json',
            success: function(data){
                htmlUnidades = '<select class="js-example-basic-single form-control" id="s_regla" name="s_regla" onChange="cargarRegla();">';
                htmlUnidades +='<option value=0>-- Seleccionar --</option>';
                for (var i = 0; i < data.length; i++) {
                  if(data[i].workspace == $('#ctp_id').val() ){
                    htmlUnidades +='<option value='+data[i]._re_id+'>'+data[i]._re_id+' - '+data[i]._re_pro_nombre+' (V '+data[i]._re_pro_version+')</option>';
                  }
                }
                htmlUnidades += '</select>';
                $('#datoscombo').html(htmlUnidades);
            },  error: function(result) {
                console.log(result);
            }
      });
      cargarRegla();
    }

</script>
@endpush
