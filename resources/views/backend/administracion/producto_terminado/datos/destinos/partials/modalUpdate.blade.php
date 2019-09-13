<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="myUpdateDestino" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4>
                                    Formulario de Actualización (Destino):
                                </h4>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12 container-fluit">
                                    <form class="form-horizontal" id="formid">
                                       <input type="text" name="de_id1" id="de_id1">
                                       <input type="hidden" name="csrf-token" value="{{ csrf_token() }}" id="token">
                                        <div class="form-group">
                                            <label class="col-md-3" for="">
                                                Linea de Trabajo:
                                            </label>
                                            <div class="col-md-9">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    {!! Form::select('de_linea_trabajo1', $lineaTrabajo, null,['class'=>'form-control','name'=>'de_linea_trabajo1', 'id'=>'de_linea_trabajo1']) !!}
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-home">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3" for="">
                                                Planta:
                                            </label>
                                            <div class="col-md-9">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    {!! Form::select('de_planta_id1', $planta, null,['class'=>'form-control','name'=>'de_planta_id1', 'id'=>'de_planta_id1']) !!}
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-home">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3" for="">
                                                Departamento:
                                            </label>
                                            <div class="col-md-9">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    {!! Form::select('de_departamento1', $departamento, null,['class'=>'form-control','name'=>'de_departamento1', 'id'=>'de_departamento1']) !!}
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-globe">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3" for="">
                                                Nombre:
                                            </label>
                                            <div class="col-md-9">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    <input class="form-control" id="de_nombre1" name="de_nombre1"  type="text"/>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-file-text-o">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3" for="">
                                                Mercado:
                                            </label>
                                            <div class="col-md-9">
                                                <span class="block input-icon input-icon-right">
                                                </span>
                                                <div class="input-group">
                                                    <input class="form-control" id="de_mercado1" name="de_mercado1"  type="text"/>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-shopping-cart">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" onclick="limpiarform();" type="button">
                    Cerrar
                </button>
                {!!link_to('#',$title='Modificar', $attributes=['id'=>'actualizar','class'=>'btn btn-success'], $secure=null)!!}
            </div>
        </div>
    </div>
</div>
@push('scripts')

@endpush
