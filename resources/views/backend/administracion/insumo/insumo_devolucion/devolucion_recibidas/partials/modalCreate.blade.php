<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myCreateRecibidas" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel">
                    Aprobar Devolucion 
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                      {!! Form::open(['id'=>'proveedor'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="dev_id1" name="dev_id1" type="hidden" value="">
                                <div class="row">
                                      <div class="col-md-12">
                                          <div class="box">
                                              <div class="box-header with-border"></div>
                                                  <div class="box-body">
                                                    <div class="col-md-6">
                                                          <div class="form-group">
                                                              <div class="col-sm-12">
                                                                <label>
                                                                    Nombre Receta:
                                                                </label>
                                                                <input type="text" name="nom_rec1" id="nom_rec1" class="form-control" placeholder="">
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="col-md-3">
                                                          <div class="form-group">
                                                              <div class="col-sm-12">
                                                                <label>
                                                                    N° SALIDA:
                                                                </label>
                                                                <input type="text" name="num_salida1" id="num_salida1" class="form-control" placeholder="3" 
                                                                >
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="col-md-3">
                                                          <div class="form-group">
                                                              <div class="col-sm-12">
                                                                <label>
                                                                    N° Lote:
                                                                </label>
                                                                <input type="text" name="dev_nombre" id="dev_nombre" class="form-control" >
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                          <div class="form-group">
                                                              <div class="col-sm-12">
                                                                <label>
                                                                    Solicitante:
                                                                </label>
                                                                <input type="text" name="dev_solicitante" id="dev_solicitante" class="form-control" >
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <br>
                                                    <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-devolucionDetalleRec">
                                                          <thead class="cf">
                                                              <tr>
                                                                  <th>
                                                                      Codigo Insumo
                                                                  </th>
                                                                  <th>
                                                                      Insumo
                                                                  </th>
                                                                  <th>
                                                                      Unidad
                                                                  </th>
                                                                  <th>
                                                                      Cantidad
                                                                  </th>
                                                                  <th>
                                                                      Rango
                                                                  </th>
                                                                  <th>
                                                                      Adicion
                                                                  </th>
                                                                  <th>
                                                                      Devolucion
                                                                  </th>
                                                              </tr>
                                                          </thead>
                                                  </table>
                                              </div>    
                                          </div>
                                  </div>
                              </div>
                            </input>
                        </input>
                    </hr>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" type="button">
                    Cancelar
                </button>
                {!!link_to('#',$title='Rechazar', $attributes=['id'=>'rechazoInsumoAdi','class'=>'btn btn-warning','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
                {!!link_to('#',$title='Aprobar', $attributes=['id'=>'aprobDevoluciones','class'=>'btn btn-success','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

 

