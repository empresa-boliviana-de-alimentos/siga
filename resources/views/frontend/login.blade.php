<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
            <title>
                Login de Acceso
            </title>
            {!! Html::style('css/bootstrap.css') !!}
            {!! Html::style('font-awesome/css/font-awesome.css') !!}
            {!! Html::style('css/style.css') !!}
            {!! Html::style('css/style-responsive.css') !!}
        </meta>
    </head>
    <body>
        <div id="login-page">
            <div class="container">
                <form action="{{route('login-post')}}" method="POST" class="form-login">
                   <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <h2 class="form-login-heading">
                        <b>
                            Acceso al Sistema de Correspondencia gggggg
                        </b>
                    </h2>
                    <div class="login-wrap">
                        <hr>
                        </hr>
                        <input autofocus="" name="usr_usuario" class="form-control" placeholder="Usuario" type="text">
                            <br>
                                <input class="form-control" name="password" placeholder="Contraseña" type="password">
                                    <br>
                                    <button class="btn btn-theme btn-block" href="index.html" type="submit">
                                        <i class="fa fa-lock">
                                        </i>
                                        INGRESAR
                                    </button>
                                    <hr>
                                    </hr>
                                </input>
                            </br>
                        </input>
                    </div>
                </form>
            </div>
        </div>
        {!! Html::script('js/jquery.js') !!}
          {!! Html::script('js/bootstrap.min.js') !!}
           {!! Html::script('js/jquery.backstretch.min.js') !!}
        <script>
            $.backstretch("../img/fondo.jpg", {speed: 500});
        </script>
    </body>
</html>