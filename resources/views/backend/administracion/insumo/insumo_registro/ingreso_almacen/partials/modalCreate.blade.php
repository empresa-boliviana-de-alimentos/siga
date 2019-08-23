<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myCreateIngreso" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button" onclick="EliminarPreliminar()">×</button>
                <h4 class="modal-title" id="myModalLabel">
                    Confirmar Ingreso Almacen
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                        {!! Form::open(['id'=>'registro', 'files' => true])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id" name="provid" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Nota Remision:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('carr_ing_rem', null, array('placeholder' => 'Nota Remision','class' => 'form-control','id'=>'carr_ing_rem', 'style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                 <label>
                                                    Lote:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('carr_ing_lote', null, array('placeholder' => 'LOTE','class' => 'form-control','id'=>'carr_ing_lote', 'style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nro Contrato:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::text('carr_ing_nrocontrato', null, array('placeholder' => 'NRO. CONTRATO','class' => 'form-control','id'=>'carr_ing_nrocontrato', 'style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Tipo Ingreso:
                                                </label>
                                                <select class="form-control" id="carr_ing_tiping" name="carr_ing_tiping">
                                                    <option value="">Seleccione un tipo de ingreso</option>
                                                    @foreach($comboIng as $ing)
                                                    <option value="{{$ing->ting_id}}">{{$ing->ting_nombre}}</option>
                                                    @endforeach
                                                </select> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Fecha Remsion:
                                                </label> 
                                                <span class="block input-icon input-icon-right">
                                                    <div class="input-group">
                                                        <input class="form-control datepicker" id="carr_ing_fech" name="carr_ing_fech" type="text">
                                                            <div class="input-group-addon">
                                                                <span class="glyphicon glyphicon-calendar">
                                                                </span>
                                                            </div>
                                                        </input>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Nro Factura:
                                                </label>
                                                <span class="block input-icon input-icon-right">
                                                    {!! Form::number('carr_ing_nrofactura', null, array('placeholder' => 'NRO. FACTURA','class' => 'form-control','id'=>'carr_ing_nrofactura', 'style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <br>
                                            <div class="form-group">
                                                <div class="col-sm-12">                                                    
                                                    <label style="color: blue">
                                                        Tiene Factura marque el checkbok:
                                                    </label>
                                                    <input class="form-check-input" type="checkbox" name="isFile" id="isFile" required>
                                                </div>
                                            </div>
                                     </div>
                                </div>
                                
                                 <div class="row">
                                    <div id="dvOcultarFile" style="display: none;">
                                        <div class="text-center">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="fileinput fileinput-new" id="img-prov" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail" style="width: 100px; height: 100px;">
                                                            </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 120px; max-height: 120px;"></div>
                                                        <div>
                                                            <span class="btn btn-default btn-file">
                                                                <span class="fileinput-new">Seleccione Imagen</span>
                                                                <span class="fileinput-exists">Cambiar</span>
                                                                <input type="file" name="imgFactura"></span>
                                                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </input>
                        </input>
                        <table id="lts-carrconf" class="col-md-12 table-bordered table-striped table-condensed cf" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Insumo</th>
                                    <th>Cantidad</th>
                                    <th>Costo/U. Bs,</th>
                                    <th>Proveedor</th>
                                    <th>Total Bs.</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <th colspan="5" style="text-align:right">Total:</th>
                                <th></th>
                            </tfoot>
                        </table>
                    </hr>
                </div>
            </div>       
            <div class="modal-footer">
                <a style="background:#F5B041"  data-toggle="modal" class="btn btn-danger" id="registroPreliminar"   target="_blank">Reporte Preliminar</a>
                <button class="btn btn-danger" data-dismiss="modal" type="button" onclick="EliminarPreliminar()">
                    Cerrar
                </button>
                {!!link_to('#',$title='Registrar', $attributes=['id'=>'registroIngreso','class'=>'btn btn-success','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript">
$('#isFile').on('click', function(){
    var c = document.getElementById('isFile').checked;
    if (c) {
       $("#dvOcultarFile").show();
    }
    else {
       $("#dvOcultarFile").hide();
    }
});
</script>
@endpush