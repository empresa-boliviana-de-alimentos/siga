<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="myUserCreate" tabindex="-5">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
         <div class="modal-body">
          <div class="row">
           <div class="col-xs-12 container-fluit">
               <div class="panel panel-warning">
                <div class="panel-heading">
                    <h4>
                        Registrar Usuario
                    </h4>
                </div>
                <div class="panel-body"> 
                    <div class="caption">
                        <hr>
                        {!! Form::open(['id'=>'regUser'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                        <input id="id" name="usr_id" type="hidden" value="">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label class="control-label">
                                        Nombre:
                                    </label>
                                    {!! Form::text('usr_usuario', null, array('placeholder' => 'Nombre de Opcion','class' => 'form-control','name'=>'usr_usuario','id'=>'usuario')) !!}
                                </div>
                                <div class="form-group">
                                    <label class="control-label">
                                        Contrasena:
                                    </label>
                                    {!! Form::text('usr_clave', null, array('placeholder' => 'Ingrese la Contraseña','class' => 'form-control','name'=>'usr_clave','id'=>'clave')) !!}
                                </div>
                                <div class="form-group">
                                    <label>
                                        Grupo:
                                    </label>
                                    {!! Form::Label('item','Personas:')!!}
                                    {!! Form::select('prs_id', $persona, null,['class'=>'form-control','name'=>'usr_prs_id', 'id'=>'usr_prs_id']) !!}
                                </div>
                                <div class="form-group">
                                    <label>
                                        Area Produccion:
                                    </label>
                                    {!! Form::Label('item','Linea Trabajo:')!!}
                                    <select name="usr_linea_trabajo" id="usr_linea_trabajo" class="form-control" onchange="muestraturno()">
                                        <option value="0">Seleccione</option>
                                        <option value="1">Almendra</option>
                                        <option value="2">Lacteos</option>
                                        <option value="3">Miel</option>
                                        <option value="4">Frutos</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>
                                        Planta:
                                    </label>
                                    <!-- {!! Form::Label('item','Planta:')!!}
                                    {!! Form::select('usr_planta_id', $planta, null,['class'=>'form-control','name'=>'usr_planta_id', 'id'=>'usr_planta_id']) !!} -->
                                    <select name="usr_planta_id" id="usr_planta_id" class="form-control"></select>
                                </div>
                                <div class="form-check" id="checkZona" style="display: none;">
                                    <input type="checkbox" class="form-check-input" id="subscribe">
                                    <label class="form-check-label" for="exampleCheck1">Selecciona el Check Si el usuario es de Acopio</label>
                                </div>
                                <div class="form-group" id="zonaAccion" style="display: none;">
                                    
                                    <label>
                                        ZONA DE ACCION DE ACOPIO:
                                    </label>                                    
                                    <select name="usr_zona_id" id="usr_zona_id" class="form-control">
                                        <option value="">Selecione zona de accion</option>
                                        <option value="1">A - RIBERALTA</option>
                                        <option value="2">B - EL SENA</option>
                                        <option value="3">C - COBIJA</option>
                                    </select>
                                </div>

                                <div class="form-group" id="turno" style="display: none;">
                                    <label>
                                        TURNO:
                                    </label>                                    
                                    <select name="usr_id_turno" id="usr_id_turno" class="form-control">
                                        <option value="">Selecione turno</option>
                                        <option value="1">MAÑANA</option>
                                        <option value="2">TARDE</option>
                                    </select>
                                </div>
                            </input>
                        </div>

                    </div>
                </input>
            </input>
        </hr>
    </div>
</div>
</div>
</div>
</div>
<div class="modal-footer">
    <button class="btn btn-default" data-dismiss="modal" type="button">
        Cerrar
    </button>
    {!!link_to('#',$title='Registrar', $attributes=['id'=>'registroUsuario','class'=>'btn btn-warning'], $secure=null)!!}                 
    {!! Form::close() !!}
</div>
</div>
</div>
</div>
</div>
@push('scripts')
<script type="text/javascript">
$('#usr_linea_trabajo').on('change', function(e){
    console.log(e);
    var linea_trabajo = e.target.value;
    $.get('/ajax-planta?linea_id='+linea_trabajo, function(data){
         console.log(data);
        $('#usr_planta_id').empty();
        $('#usr_planta_id').append('<option value="0">Seleccione</option>');
        $.each(data, function(index, asocObj){
            $('#usr_planta_id').append('<option value="'+asocObj.id_planta+'">'+asocObj.nombre_planta+'</option>');
            console.log(asocObj.id_planta);
        });
    });
    if ($(this).val()==1) {
        $('#checkZona').show();
        $('#subscribe').on('change',function(){
            if (this.checked) {
             $('#zonaAccion').show();
            } else {
             $('#zonaAccion').hide();
            }  
          })
        console.log('ESTA EN ALMENDRA DEBE ESTAR LA PREGUNTA DEL ACOPIO');
        
    } else {
        $('#checkZona').hide();
        console.log('NO ESTA EN ALMENDRA DESAPARECERA LA PREGUNTA DEL ACOPIO');
        $('#zonaAccion').hide();
    }
});


function muestraturno(){

    var idlinea = document.getElementById('usr_linea_trabajo').value;
    console.log(idlinea);
    
    if (idlinea==2) {
        $('#turno').show();
       
    }else{
      
       $('#turno').hide();  
    }
}
</script>
@endpush
