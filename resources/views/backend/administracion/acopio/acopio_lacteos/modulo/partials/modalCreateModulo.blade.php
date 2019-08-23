<div class="extended_modals">
<div class="modal" data-backdrop="static" data-keyboard="false" id="myCreateModulo" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    X
                </button>
                <h4 class="modal-titlepanel-title" id="myModalLabel">
                    <center>REGISTRO DE MODULO/CENTRO DE ACOPIO LACTEOS</center>
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                        {!! Form::open(['id'=>'modulo'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id" name="prsid" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <div class="col-sm-12">
                                                    <label>  Nombre de Modulo/Centro Acopio:    </label>
                                                    <span class="block input-icon input-icon-right">
                                                        {!! Form::text('modu_modulo', null, array('placeholder' => 'Ingrese Nombre del Modulo/Centro Acopio','maxlength'=>'20','class' => 'form-control','id'=>'modu_modulo','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                    <div class="col-sm-12"> 
                                                        <label style="color: blue;"><input type="checkbox" name="check" id="check" value="1" onchange="javascript:showContent()" > El modulo Tiene representante? seleccione el check.</label>
                                                    </div>
                                                </div>
                                            <div id="ocultar" style="display: none;">
                                                <div class="col-md-12">
                                                    <div class="col-sm-12">
                                                        <label>  Nombres:    </label>
                                                        <span class="block input-icon input-icon-right">
                                                            {!! Form::text('modu_nombres', null, array('placeholder' => 'Ingrese Nombre(s) ','maxlength'=>'20','class' => 'form-control','id'=>'modu_nombres','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                        </span>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="col-md-6">
                                                    <div class="col-sm-12">
                                                        <label>  Apellido Paterno:    </label>
                                                        <span class="block input-icon input-icon-right">
                                                            {!! Form::text('modu_paterno', null, array('placeholder' => 'Ingrese Apellido Paterno','maxlength'=>'20','class' => 'form-control','id'=>'modu_paterno','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                        </span>
                                                    </div>
                                                </div>
                                        
                                                <div class="col-md-6">
                                                    <div class="col-sm-12">
                                                        <label>  Apellido Materno:    </label>
                                                        <span class="block input-icon input-icon-right">
                                                            {!! Form::text('modu_materno', null, array('placeholder' => 'Ingrese Apellido Materno ','maxlength'=>'20','class' => 'form-control','id'=>'modu_materno','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                        </span>
                                                     </div>
                                                </div>
                                            
                                                <div class="col-md-6">
                                                    <div class="col-sm-12">
                                                        <label>
                                                            CI:
                                                        </label>
                                                        <span class="block input-icon input-icon-right">
                                                            {!! Form::text('modu_ci', null, array('placeholder' => 'Ingrese CI ','maxlength'=>'20','class' => 'form-control','id'=>'modu_ci')) !!}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="col-sm-12">
                                                        <label>
                                                            Telefono:
                                                        </label>
                                                        <span class="block input-icon input-icon-right">
                                                            {!! Form::number('modu_telefono', null, array('placeholder' => 'Ingrese CI ','maxlength'=>'20','class' => 'form-control','id'=>'modu_telefono')) !!}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="col-sm-12">
                                                    <label>
                                                        Dirección:
                                                    </label>
                                                    <span class="block input-icon input-icon-right">
                                                        {!! Form::text('modu_direccion', null, array('placeholder' => 'Ingrese dirección del Modulo/Centro Acopio ','maxlength'=>'20','class' => 'form-control','id'=>'modu_direccion','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                    </span>
                                                </div>
                                            </div>                                        
                                        </div>
                                    </div>                                                                    
                                </div>                             
                        </input>
                    </hr>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registroModulo','class'=>'btn btn-success','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>


</div>
@push('scripts')
<script>
    function showContent() {
        element = document.getElementById("ocultar");
        check = document.getElementById("check");
        if (check.checked) {
            element.style.display='block';
        }
        else {
            element.style.display='none';
            $('#modu_nombres').val('');
            $('#modu_paterno').val('');
            $('#modu_materno').val('');
            $('#modu_ci').val('');
            $('#modu_telefono').val('');
        }
    }
</script>
@endpush