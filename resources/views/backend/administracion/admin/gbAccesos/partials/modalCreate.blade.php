<div class="modal fade modal-primary" data-backdrop="static" data-keyboard="false" id="myCreate" tabindex="-5">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">
                    ×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Registrar Accesos
                </h4>
            </div>
            <div class="modal-body">
                <div class="caption">
                    <hr>
                        {!! Form::open(['id'=>'acceso'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                         <input id="id" name="prsid" type="hidden" value="">
                            <div class="row">
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <div class="col-sm-12">
                                          <label>
                                              Opciones:
                                          </label>
                                          <span class="block input-icon input-icon-right">
                                              <select class="form-control" id="opc_id" name="opc_id" placeholder="Elija un valor">
                                                  @foreach($data as $opcion)
                                                  <option value="{{$opcion->opc_id}}">
                                                      {{$opcion->opc_opcion}}
                                                  </option>
                                                  @endforeach
                                              </select>
                                          </span>
                                      </div>
                                  </div>
                              </div>


                              <div class="col-md-4">
                                  <div class="form-group">
                                      <div class="col-sm-12">
                                          <label>
                                              Rol:
                                          </label>
                                          <span class="block input-icon input-icon-right">
                                              <select class="form-control" id="rls_id" name="rls_id" placeholder="Elija un valor">
                                                  @foreach($data as $rol)
                                                  <option value="{{$rol->rls_id}}">
                                                      {{$rol->rls_rol}}
                                                  </option>
                                                  @endforeach
                                              </select>
                                          </span>
                                      </div>
                                  </div>
                              </div>

                              <div class="col-md-4">
                                  <div class="form-group">
                                      <div class="col-sm-12">
                                          <label>
                                              Usuario:
                                          </label>
                                          <span class="block input-icon input-icon-right">
                                              <select class="form-control" id="usr_id" name="usr_id" placeholder="Elija un valor">
                                                  @foreach($data as $usuario)
                                                  <option value="{{$usuario->usr_id}}">
                                                      {{$usuario->usr_usuario}}
                                                  </option>
                                                  @endforeach
                                              </select>
                                          </span>
                                      </div>
                                  </div>
                              </div>

                        </input>
                  </div>
              </div>
              <div class="modal-footer">
                  <button class="btn btn-default" data-dismiss="modal" style="background:#A5A5B2" type="button">
                      Cerrar
                  </button>
                  {!!link_to('#',$title='Registrar', $attributes=['id'=>'registro','class'=>'btn btn-primary','style'=>'background:#57BC90'], $secure=null)!!}
                  {!! Form::close() !!}
              </div>
          </div>
      </div>
  </div>
