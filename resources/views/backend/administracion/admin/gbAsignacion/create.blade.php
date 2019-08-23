@extends('backend.template.app')
@section('main-content')
@if(Session::has('message'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </botton>
    {{Session::get('message')}}
</div>

@endif
<div class="col-md-5 col-md-offset-3">
    <div class="thumbnail">
        <div class="caption">
            <h3 class="text-center"> <b> REGISTRO GRUPOS</b></h3><hr>
            {!! Form::open(array('route' => 'Grupo.store','method'=>'POST','class'=>'')) !!}
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" name="csrf-token" value="{{ csrf_token() }}" id="token">
                    <div class="form-group">
                        <strong>Nombre de grupo:</strong>
                        {!! Form::text('grp_grupo', null, array('placeholder' => 'Nombre de Grupo','class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                      <strong>Imagen:</strong>
                      {!! Form::text('grp_imagen', null, array('placeholder' => 'Nombre de la ruta','class' => 'form-control')) !!}
                  </div>
                  <div class="form-group">
                    <strong>Usuario Id:</strong>
                    {!! Form::text('grp_usr_id', null, array('placeholder' => 'Id usuario','class' => 'form-control')) !!}
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 text-center"><hr>

                   <p align="right">

                    <a href="{{ route('Grupo.index') }}" class="btn btn-default">&nbsp; Cerrar</a>
                    <button type="submit" class="btn btn-warning" style="background:#61BC8C">Guardar</button></p>
                </div>
            </div>
        </div>
    </div>
    @endsection