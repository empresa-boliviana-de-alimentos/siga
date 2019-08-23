

     <div class="modal fade bs-example-modal-md in" id="nuevoMunicipio" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Nuevo Municipio</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['id'=>'municipio1'])!!}
                    <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                    <input id="id" name="id_municipio" type="hidden" value="">
                        <fieldset>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-3 control-label text-right" for="name">Nombre del municipio:</label>
                                <div class="col-md-9">
                                    {!! Form::text('nombre_municipio', null, array('placeholder' => 'Ingrese dirección','maxlength'=>'50','class' => 'form-control','id'=>'nombre_municipio','onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="col-md-3 control-label text-right" for="name">Departamento:</label>
                                <div class="col-md-9">
                                   <select class="form-control" id="id_depto" name="id_depto">
                                        <option value="1">
                                            La Paz
                                        </option>
                                        <option value="2">
                                            Oruro
                                        </option>
                                        <option value="3">
                                            Potosi
                                        </option>
                                        <option value="4">
                                            Tarija
                                        </option>
                                        <option value="5">
                                            Santa Cruz
                                        </option>
                                        <option value="6">
                                            Cochabamba
                                        </option>
                                        <option value="7">
                                            Beni
                                        </option>
                                        <option value="8">
                                            Pando
                                        </option>
                                        <option value="9">
                                            Chuquisaca
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
                    {!!link_to('#',$title='Registrar', $attributes=['id'=>'registroMunicipio','class'=>'btn btn-primary','style'=>'background:#57BC90'], $secure=null)!!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>