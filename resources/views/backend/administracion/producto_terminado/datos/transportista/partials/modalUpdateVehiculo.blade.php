<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="myUpdateVehiculos" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 container-fluit">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4>
                                    Formulario Modificar Vehículos
                                </h4>
                            </div>
                            <div class="panel-body">
                                {!! Form::open(['id'=>'vehiculo1'])!!}
                                <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                                <input id="id1" type="hidden">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="col-sm-14">
                                            <div class="form-group">
                                                   {!!Form::label('u_placa','Placa:')!!}
                                                   <input class ="form-control" onkeyUp="this.value=this.value.toUpperCase();" id="u_placa1" name="veh_placa">
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-md-4">
                                        <div class="col-sm-14">
                                            <div class="form-group">
                                                   {!!Form::label('u_mar','Marca:')!!}
                                                   <input class ="form-control" onkeyUp="this.value=this.value.toUpperCase();" id="u_mar1" name="veh_marca">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-sm-14">
                                            <div class="form-group">
                                                   {!!Form::label('u_mod','Modelo:')!!}
                                                   {!! Form::text('veh_modelo', null, array('placeholder' => 'Modelo','class' => 'form-control','id'=>'u_mod1')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="col-md-14">
                                            <div class="form-group">
                                              {!!Form::label('u_tip','Tipo:')!!}
                                              <input class ="form-control" onkeyUp="this.value=this.value.toUpperCase();" id="u_tip1" name="veh_tipo">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-14">
                                            <div class="form-group">
                                              {!!Form::label('u_chas','Chasis:')!!}
                                              <input class ="form-control" onkeyUp="this.value=this.value.toUpperCase();" id="u_chas1" name="veh_chasis">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="col-md-14">
                                            <div class="form-group">
                                              {!!Form::label('u_ros_soat','Roseta Soat:')!!}
                                              {!! Form::text('veh_roseta_soat', null, array('placeholder' => 'Roseta Soat','class' => 'form-control','id'=>'u_ros_soat1')) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                        <div class="col-md-4">
                                            <div class="col-sm-14">
                                                <div class="form-group">
                                                {!!Form::label('u_ros_ins','Roseta Inspeccion:')!!}
                                                {!! Form::text('veh_roseta_inspeccion', null, array('placeholder' => 'Roseta Inspeccion','class' => 'form-control','id'=>'u_ros_ins1')) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="col-sm-14">
                                                <div class="form-group">
                                                {!!Form::label('u_res_tra','Restriccion Transito:')!!}
                                                <input class ="form-control" onkeyUp="this.value=this.value.toUpperCase();" id="u_res_tra1" name="veh_restriccion_transito">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="col-sm-14">
                                                <div class="form-group">
                                                    {!!Form::label('u_res_gam','Restriccion Municipio:')!!}
                                                    <input class ="form-control" onkeyUp="this.value=this.value.toUpperCase();" id="u_res_gam1" name="veh_restriccion_gamlp">
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                         </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="col-md-14">
                    <button class="btn btn-default" data-dismiss="modal" type="button" onclick = "Limpiar()">
                        Cerrar
                    </button>
                    {!!link_to('#',$title='Modificar', $attributes=['id'=>'actualizar','class'=>'btn btn-primary'], $secure=null)!!}
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>
</div>
