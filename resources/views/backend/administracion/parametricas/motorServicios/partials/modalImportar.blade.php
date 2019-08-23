<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="modalImportar" tabindex="-1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h4>
              <small>
                <div class="pull-right">
                  <div class="pull-right" id="idbotonUP"></div>
                </div>
              </small>
              <i class="fa fa-database"></i> Importar Base de datos 
            </h4>
            <input id="upid" name="id" value="id" type="hidden" class="form-control">
          </div>
        </div>
      </div>
      <div class="modal-body">
        <div class="row"> 
          <input id="token" name="token" type="hidden" value="{{ csrf_token() }}">
            <label class="col-md-2 control-label">Archivo</label>
              <div class="form-group">
                <div class="col-md-8">
                <input type="file" class="form-control" id="file" name="file">
              </div>
            </div> 
        </div>
      </div>
      <div class="modal-footer">
       <button class  ="btn btn-primary" id ="btnImportar" name ="btnImportar" title ="Importar base de datos" onclick="importarDB();">Importar</button>
        <button class="btn btn-default" data-dismiss="modal" onclick="limpiar();" type="button">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

function obtenerDatos(e) 
{
  var i='';
  var file = e.target.files[0];
  console.log("file",file);
  if (!file)
  {
    return;
  }
  var lector = new FileReader();
  lector.onload = function(e)
  {
    var contenido = e.target.result;
    almacenarContenido(contenido);
  };
  lector.readAsText(file);
}
function cargando(){
      var texto   = $("<div>", {
             text    : "PROCESANDO....",
                id      : "myEstilo",
                css     : {
                "font-size" : "30px",
                    "position": "relative",
                    "width": "500px",
                    "height": "300px",
                    "left": "180px",
                    "top":"50px"
                },
                fontawesome : "fa fa-spinner"
            });
            $.LoadingOverlay("show",{
                    custom  : texto,
                    color:"rgba(255, 255, 255, 0.8)",
            });
}
var rpImportacion = false;
function almacenarContenido(contenido) 
{
  console.log("cccccc",contenido);
  cargando();
  var file      = contenido;
  var parseFile = JSON.parse(file);
  var parseData = JSON.parse(parseFile.data[0].sp_exp_motor_idintegrity);
  if(parseData != null ){
    console.log("parseData",parseData);
    var servicio  = JSON.stringify(parseData.servicio[0]);
    var id        = JSON.stringify(parseData.servicio[0].srv_id);
    var catalogo  = JSON.stringify(parseData.catalogo[0]);
    var codigo    = JSON.stringify(parseData.codigo);
    var route     = "v1_0/motorServicios/postImportar";

    $.ajax({
      type    : 'POST',
      data    :  {id,servicio,catalogo,codigo},
      url     :  route,
      headers : {'X-CSRF-TOKEN': $("#token").val()},
      dataType: 'json',
      success: function(data)
      {
        console.log(data);
        $.LoadingOverlay("hide");
        //swal("Servicio!", " Importación realizada correctamente!", "success");
        //setTimeout(function(){ location.reload(true); }, 4000);
        rpImportacion = true;
      },
      error: function(result)
      {
        console.log('Error',result);
        swal("Error!", " Se presento un problema al realizar la Importación!", "error");
        $.LoadingOverlay("hide");
      }
    });
  }else{
      swal("Error!", " El archivo no cuenta con los registros necesarios para la Importación!", "error");
      $.LoadingOverlay("hide");
  }
  
}
function limpiar()
{
  $('#file').val('');
  //$('#importar_id').val('');
}

document.getElementById('file').addEventListener('change', obtenerDatos, false);  

function importarDB()
{ 
  //var id = $("#importar_id").val();
  //alert(rpImportacion);
  if(rpImportacion){

    swal("Servicio!", " Importación realizada correctamente!", "success"); 
    $('#modalImportar').modal('hide');  
    limpiar();
    setTimeout(function(){ location.reload(true); }, 5000);

  }
  //$('select').val($(''))
}
</script>
