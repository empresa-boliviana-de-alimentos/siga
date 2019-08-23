@extends('backend.template.app')

@section('main-content')
@if(Session::has('message'))
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    {{Session::get('message')}}
    </div>
  @endif
<div class="col-md-5 col-md-offset-3">
  <div class="thumbnail">
    <div class="caption">
      <h3 class="text-center"><b>Editar Grupo</b></h3><hr>
          {!! Form::model($grupo,['route' => ['Grupo.update',$grupo->grp_id],'method'=>'PUT'])!!}
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">

                  {!!Form::label('nombre', 'Nombre de grupo:')!!}
                  {!! Form::text('grp_grupo', null, ['placeholder' => 'Ingrese el nombre de grupo','class'=>'form-control']) !!}

                   {!!Form::label('imagen', 'Ruta Imagen:')!!}
                   {!! Form::text('grp_imagen', null, ['placeholder' => 'Ruta del icono de imagen','class'=>'form-control']) !!}

                  {!!Form::label('fecha1', 'fecha registro:')!!}
                  {!! Form::text('grp_registrado', null, ['placeholder' => 'Ingrese el nombre de Opcion','class'=>'form-control']) !!}

                  {!!Form::label('fecha2', 'Fecha edicion:')!!}
                  {!! Form::text('grp_modificado', null, ['placeholder' => 'Ingrese el nombre de Opcion','class'=>'form-control']) !!}

                   {!!Form::label('usuarioId', 'Codigo de usuario:')!!}
                   {!! Form::text('grp_usr_id', null, ['placeholder' => 'Ingrese el nombre de Opcion','class'=>'form-control']) !!}

                   {!!Form::label('estado', 'Estado:')!!}
                  {!! Form::text('grp_estado', null, ['placeholder' => 'Ingrese el nombre de Opcion','class'=>'form-control']) !!}

                   <div class="col-xs-12 col-sm-12 col-md-12 text-center"><hr>

                   <p align="right"> <a href="{{ route('Grupo.index') }}" class="btn btn-primary" style="background:#A5A5B2">&nbsp;Cerrar</a>
                    <button type="submit" class="btn btn-primary" style="background:#61BC8C">Modificar</button></p>
            </div>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
</div>


@endsection
