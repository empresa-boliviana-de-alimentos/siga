@extends('frontend.frmapp')
@section('main-content')
<div class="ms-hero-page-override ms-hero-img-city ms-hero-bg-dark-light">
</div>
<div class="container">
  <div class="row justify-content-md-center">
    <div class="col-lg-6">
      <div class="card card-hero card-primary animated fadeInUp animation-delay-7">
        <div class="card-body">
          <h1 class="color-primary text-center">Iniciar Sesion</h1>
            <form action="{{ route('login') }}" method="post"  class="form-horizontal">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <fieldset>
              <div class="form-group row">
                <label for="inputEmail" class="col-md-3 control-label">Usuario</label>
                <div class="col-md-9">
                  <input type="text" class="form-control" id="usr_usuario" name="usr_usuario" placeholder="Ingrese su usuario">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword" class="col-md-3 control-label">Contraseña
                </label>
                <div class="col-md-9">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña">
                </div>
              </div>
            </fieldset>
            <div class="text-center">
            <a href="{{url('/')}}" class="btn btn-raised btn-danger"><i class="zmdi zmdi-long-arrow-left no-mr ml-1"></i>atras
            </a>
            <button class="btn btn-raised btn-primary">Ingresar
              <i class="zmdi zmdi-long-arrow-right no-mr ml-1"></i>
            </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection