<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myCreateDevolucion" tabindex="-5">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel">
                    Devolucion Insumos
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                      {!! Form::open(['id'=>'proveedor'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="aprsol_id" name="aprsol_id" type="hidden" value="">
                                <div class="row">
                                      <div class="col-md-12">
                                          <div class="box">
                                              <div class="box-header with-border"></div>
                                                  <div class="box-body">
                                                    <div class="col-md-3">
                                                          <div class="form-group">
                                                              <div class="col-sm-12">
                                                                <label>
                                                                    N° LOTE:
                                                                </label>
                                                                <input type="text" name="lote" id="lote" class="form-control" placeholder="">
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="col-md-3">
                                                          <div class="form-group">
                                                              <div class="col-sm-12">
                                                                <label>
                                                                    N° SALIDA:
                                                                </label>
                                                                <input type="text" name="num_saldia" id="num_saldia" class="form-control" placeholder="3" 
                                                                >
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="col-md-6">
                                                          <div class="form-group">
                                                              <div class="col-sm-12">
                                                                <label>
                                                                    NOMBRE:
                                                                </label>
                                                                <input type="text" name="dev_nombre" id="dev_nombre" class="form-control" >
                                                              </div>
                                                          </div>
                                                      </div>
                                              </div>    
                                          </div>
                                  </div>
                              </div>
                              <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-devolucionDetalle">
                                <thead class="cf">
                                    <tr class="item_dev">
                                        <th>#</th>
                                        <th>Insumo</th>
                                        <th>Unidad</th>
                                        <th>Cantidad</th>
                                        <th>Rango</th>
                                        <th>Adicion</th>
                                        <th>Devolucion</th>
                                    </tr>
                                  </thead>
                                </table>
                              <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <label>
                                                    Observaciones Justificadas:
                                                </label> 
                                                 {!! Form::textarea('res.obs', null, array('placeholder' => ' ','class' => 'form-control','id'=>'obs', 'rows'=>'2','required','style'=>'text-transform:uppercase;', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();')) !!} 
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
                {!!link_to('#',$title='Devolucion', $attributes=['id'=>'registroDev','class'=>'btn btn-success','style'=>''], $secure=null)!!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

 

