<div class="modal fade modal-default" id="myCreateVehiculos" data-backdrop="static" data-keyboard="false" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12 container-fluit">
            <div class="panel panel-primary">
              <div class="panel-heading">
                <h4>Formulario de Registro Vehiculos</h4>
              </div>
              <div class="panel-body">
                  {!! Form::open(['id'=>'vehiculo'])!!}
                  <input type="hidden" name="csrf-token" value="{{ csrf_token() }}" id="token">
                  <div class="row">
                      <div class="col-md-4">
                          <div class="col-sm-14">
                            <div class="form-group">
                                      {!!Form::label('Placa','Placa:')!!}
                                      {!! Form::text('veh_placa', null, array('placeholder' => 'Placa ','maxlength'=>'20','class' => 'form-control','id'=>'u_placa')) !!}
                            </div>
                          </div>
                      </div>
                      <div class="col-md-4">
                            <div class="col-sm-14">
                              <div class="form-group">
                                      {!!Form::label('Marca','Marca:')!!}
                                      {!! Form::text('veh_marca', null, array('placeholder' => 'Marca','class' => 'form-control','id'=>'u_marca')) !!}
                              </div>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="col-sm-14">
                            <div class="form-group">
                                      {!!Form::label('Modelo','Modelo:')!!}
                                      {!! Form::text('veh_modelo', null, array('placeholder' => 'Modelo','class' => 'form-control','id'=>'u_modelo')) !!}
                            </div>
                          </div>
                      </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                      <div class="col-md-14">
                         <div class="form-group">
                          {!!Form::label('Tipo','Tipo:')!!}
                          {!! Form::text('veh_tipo', null, array('placeholder' => 'Tipo de vehiculo','class' => 'form-control','id'=>'u_tipo')) !!}
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="col-md-14">
                        <div class="form-group">
                          {!!Form::label('Chasis','Chasis:')!!}
                          {!! Form::text('veh_chasis', null, array('placeholder' => 'Chasis de l vehiculo','class' => 'form-control','id'=>'u_chasis')) !!}
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="col-md-14">
                        <div class="form-group">
                          {!!Form::label('Roseta Soat','Roseta Soat:')!!}
                          {!! Form::text('veh_roseta_soat', null, array('placeholder' => 'Roseta Soat','class' => 'form-control','id'=>'u_roseta_soat')) !!}
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                      <div class="col-md-14">
                       <!-- {!!Form::label('Roseta Inspeccion','Roseta Inspeccion:')!!}-->
                          <div class="form-group">
                            <!-- {!! Form::radio('veh_roseta_inspeccion','Si', ['class'=>'form-control','id'=>'u_roseta_inspeccion']) !!} Si
                             {!! Form::radio('veh_roseta_inspeccion','No',['class'=>'form-control','id'=>'u_roseta_inspeccion']) !!} No-->
                             {!!Form::label('Roseta Inspeccion','Roseta Inspeccion:')!!}
                            {!! Form::text('veh_roseta_inspeccion', null, array('placeholder' => 'Roseta Inspeccion','class' => 'form-control','id'=>'u_roseta_inspeccion')) !!}
                          </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="col-md-14">
                        <div class="form-group">
                          {!!Form::label('Restriccion Transito','Restriccion Transito:')!!}
                          {!! Form::text('veh_restriccion_transito', null, array('placeholder' => 'Restriccion Transito','class' => 'form-control','id'=>'u_restriccion_transito')) !!}
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4">
                       <div class="col-md-14">
                        <div class="form-group">
                          {!!Form::label('Restriccion Municipio','Restriccion Municipio:')!!}
                          {!! Form::text('veh_restriccion_gamlp', null, array('placeholder' => 'Restriccion Municipio','class' => 'form-control','id'=>'u_restriccion_gamlp')) !!}
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
              <button type="button" class="btn btn-danger"  data-dismiss="modal" onclick = "Limpiar()">Cerrar</button>
              {!!link_to('#',$title='Registrar', $attributes=['id'=>'registro','class'=>'btn btn-primary'], $secure=null)!!}
              {!! Form::close() !!}
            </div>
          </div>
    </div>
  </div>
</div>

