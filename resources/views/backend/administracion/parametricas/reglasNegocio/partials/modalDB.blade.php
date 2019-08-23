<div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="modalDB" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 container-fluit">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h4>
                                    <small>
                                    <div class="pull-right"><button class="btn btn-default" data-dismiss="modal" onclick="" type="button">
                                    Cerrar
                                    </button>
                                    <a type = "button" class = "btn btn-primary" id="btn_conexion" style="background:#43a047" onclick="conexionDB();">Conectar</a></div></small>
                                    Conectar a Base de Datos
                                </h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            {!! Form::open(['class'=>'form-horizontal','id'=>'reglas'])!!}
                            <form class="form-horizontal">
                                <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label class="col-md-1" for="">
                                        Gestor DB:
                                    </label>
                                    <div class="col-md-5">
                                        {!! Form::text('gertor',null, array('maxlength'=>'40','class' => 'form-control mayusculas','id'=>'r_gertor','name'=>'r_gertor')) !!}
                                    </div>
                                    <label class="col-md-1" for="">
                                        Puerto:
                                    </label>
                                    <div class="col-md-5">
                                        {!! Form::text('puerto',null, array('maxlength'=>'6','class' => 'form-control mayusculas','id'=>'r_puerto','name'=>'r_puerto')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-1" for="">
                                        Servidor:
                                    </label>
                                    <div class="col-md-5">
                                        {!! Form::text('servidor',null, array('maxlength'=>'40','class' => 'form-control mayusculas','id'=>'r_servidor','name'=>'r_servidor')) !!}
                                    </div>
                                    <label class="col-md-1" for="">
                                        Nombre DB:
                                    </label>
                                    <div class="col-md-5">
                                        {!! Form::text('nombredb',null, array('maxlength'=>'50','class' => 'form-control mayusculas','id'=>'r_nombredb','name'=>'r_nombredb')) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-1" for="">
                                        Usuario:
                                    </label>
                                    <div class="col-md-5">
                                        {!! Form::text('usuariodb',null, array('maxlength'=>'50','class' => 'form-control mayusculas','id'=>'r_usuariodb','name'=>'r_usuariodb')) !!}
                                    </div>
                                    <label class="col-md-1" for="">
                                        Contraseña:
                                    </label>
                                    <div class="col-md-5">
                                        <input class="form-control" id="r_passworddb" name="r_passworddb" placeholder="" type="password" ></input>
                                    </div>
                                </div>
                                <div class="">
                                    <div id="resultadoConn"></div>
                                </div>
                                </input>
                            </form>
                        </div>
                        
                    </div>
            
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>

</script>
@endpush