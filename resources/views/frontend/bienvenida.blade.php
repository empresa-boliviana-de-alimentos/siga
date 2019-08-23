<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#333">
    <title>Sistema Gestion de Almacenes</title>
    <meta name="description" content="Material Style Theme">
    <link rel="shortcut icon" href="img/siga_logo_color.png">
     {!! Html::style('css/preload.min.css') !!}
     {!! Html::style('css/plugins.min.css') !!}
     {!! Html::style('css/style.light-blue-500.min.css') !!}
     {!! Html::style('css/preload.min.css') !!}
     {!! Html::style('css/width-boxed.min.css') !!}
  </head>
  <body>
    <div id="ms-preload" class="ms-preload">
      <div id="status">
        <div class="spinner">
          <div class="dot1"></div>
          <div class="dot2"></div>
        </div>
      </div>
    </div>
    <div>
      <header class="ms-header ms-header-primary">
        <!--ms-header-primary-->
        <div class="container container-full">
          <div class="ms-title">
            <a href="index-2.html">
              <img src="img/email/logosedem.png" alt="" style="height: 5vw; width: 5vw; border: 2px solid #fff;border-radius: 50%;box-shadow: 0 0 5px gray;display: inline-block;margin-left: auto;margin-right: auto;">
              <h1 class="animated fadeInRight animation-delay-6">
                <span>Siaco</span>
              </h1>
            </a>
          </div>
          <div class="header-right">
            <ul class="navbar-nav">
              @if (Auth::guest())
              <li class="nav-item dropdown">
                <a href="{{ url('/sesion') }}" class="nav-link dropdown-toggle animated fadeIn animation-delay-7" data-toggle="dropdown" data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-name="home">Iniciar sesion
                </a>
              </li>
              @else
                <li class="nav-item dropdown">
                  <a href="#" class="nav-link dropdown-toggle animated fadeIn animation-delay-8" data-toggle="dropdown" data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-name="portfolio">{{ Auth::user()->usr_usuario }}
                    <i class="zmdi zmdi-chevron-down"></i>
                  </a>
                  <ul class="dropdown-menu">
                  <li>
                    <a class="dropdown-item" href="portfolio-filters_sidebar.html">
                      <i class="zmdi zmdi-card-membership"></i>Video Tutorial</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="portfolio-filters_sidebar.html">
                      <i class="zmdi zmdi-card-membership"></i>Video Tutorial</a>
                  </li>
                </ul>
              </li>
              @endif
            </ul>
        </div>
        </div>
      </header>
      <nav class="navbar navbar-expand-md  navbar-static ms-navbar ms-navbar-primary">
        <div class="container container-full">
          <div class="navbar-header">
            <a class="navbar-brand" href="index-2.html">
              <img src="img/email/EBA2019.png" alt="" style="height: 5vw; width: 5vw; border: 2px solid #fff;border-radius: 50%;box-shadow: 0 0 5px gray;display: inline-block;margin-left: auto;margin-right: auto;">
              <span class="ms-title">
                <strong>Siaco</strong>
              </span>
            </a>
          </div>
          <div class="collapse navbar-collapse" id="ms-navbar">
            <ul class="navbar-nav">
              <li class="nav-item dropdown active">
                  <a href="#" class="nav-link dropdown-toggle animated fadeIn animation-delay-7" data-toggle="dropdown" data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-name="home">Inicio
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle animated fadeIn animation-delay-7" data-toggle="dropdown" data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-name="page">Acerca de 
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle animated fadeIn animation-delay-8" data-toggle="dropdown" data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-name="portfolio">Ayuda
                  <i class="zmdi zmdi-chevron-down"></i>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a class="dropdown-item" href="portfolio-filters_sidebar.html">
                      <i class="zmdi zmdi-card-membership"></i>Video Tutorial</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="portfolio-filters_topbar.html">
                      <i class="zmdi zmdi-view-agenda"></i>Manual de Usuario</a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
          <a href="javascript:void(0)" class="ms-toggle-left btn-navbar-menu">
            <i class="zmdi zmdi-menu"></i>
          </a>
        </div>
        <!-- container -->
      </nav>
      <div class="ms-hero-page ms-hero-img-coffee ms-hero-bg-dark no-pb overflow-hidden ms-bg-fixed">
        <div class="container">
          <div class="text-center color-white">
            <span class="ms-logo ms-logo-whit animated bounceInDown animation-delay-5">S</span>
            <h1 class="animated bounceInDown animation-delay-6">SIACO</h1>
            <p class="lead lead-lg animated bounceInDown animation-delay-7">SISTEMA DE AUTOMATICO DE CORRESPONDENCIA</p>
          </div>
          <div class="img-browser-container mt-6">
            <img src="assets/img/demo/safariBig1.png" alt="" class="img-fluid center-block index-1 img-browser animated slideInUp">
            <img src="assets/img/demo/safariBig3.png" alt="" class="img-fluid center-block img-browser img-browser-left img-browser-left">
            <img src="assets/img/demo/safariBig2.png" alt="" class="img-fluid center-block img-browser img-browser-right img-browser-right"> </div>
        </div>
      </div>
      <div class="ms-hero-img-beach ms-hero-bg-info ms-bg-fixed pt-2 pb-2">
        <div class="container">
          <div class="text-center mb-4">
           <p class="lead color-light mw-800 center-block wow fadeInUp animation-delay-4"></p>
          </div>
          <div class="text-center ms-margin">
            <a href="javascript:void(0)" class="btn btn-primary btn-raised btn-app wow zoomInUp animation-delay-2">
              <div class="btn-container">
                <i class="fa fa-search"></i>
                <span>Correspondencia</span>
                <br>
                <strong>Buscar</strong>
              </div>
            </a>
            <a href="javascript:void(0)" class="btn btn-primary btn-raised btn-app wow zoomInUp animation-delay-3">
              <div class="btn-container">
                <i class="fa fa-user"></i>
                <span>Iniciar Sesion</span>
                <br>
                <strong>Login</strong>
              </div>
            </a>
            <a href="javascript:void(0)" class="btn btn-primary btn-raised btn-app wow zoomInUp animation-delay-3">
              <div class="btn-container">
                <i class="fa fa-file"></i>
                <span>Tipo de Correspondencias</span>
                <br>
                <strong>Documentos</strong>
              </div>
            </a>
        </div>
        </div>
      </div>
      <footer class="ms-footer">
        <div class="container">
          <p>Copyright &copy; siaco - eba 2018</p>
        </div>
      </footer>
      <div class="btn-back-top">
        <a href="#" data-scroll id="back-top" class="btn-circle btn-circle-primary btn-circle-sm btn-circle-raised ">
          <i class="zmdi zmdi-long-arrow-up"></i>
        </a>
      </div>
    </div>
    <!-- ms-site-container -->
    <div class="ms-slidebar sb-slidebar sb-left sb-style-overlay" id="ms-slidebar">
      <div class="sb-slidebar-container">
          <div class="ms-slidebar-title">
            <form class="search-form">
              <input id="search-box-slidebar" type="text" class="search-input" placeholder="Search..." name="q" />
              <label for="search-box-slidebar">
                <i class="zmdi zmdi-search"></i>
              </label>
            </form>
            <div class="ms-slidebar-t">
                <img src="img/email/LogoEBA2019.png" alt="" style="height: 5vw; width: 5vw; border: 2px solid #fff;border-radius: 50%;box-shadow: 0 0 5px gray;display: inline-block;margin-left: auto;margin-right: auto;">
                <span>Siaco</span>
            </div>
          </div>
        <ul class="ms-slidebar-menu" id="slidebar-menu" role="tablist" aria-multiselectable="true">
          <li class="card" role="tab" id="sch1">
            <a class="collapsed" role="button" data-toggle="collapse" href="#sc1" aria-expanded="false" aria-controls="sc1">
              <i class="zmdi zmdi-home"></i>Inicio</a>
          </li>
          <li class="card" role="tab" id="sch2">
            <a class="collapsed" role="button" data-toggle="collapse" href="#sc2" aria-expanded="false" aria-controls="sc2">
              <i class="zmdi zmdi-desktop-mac"></i> Acerca de  </a>
            
          </li>
          <li class="card" role="tab" id="sch4">
            <a class="collapsed" role="button" data-toggle="collapse" href="#sc4" aria-expanded="false" aria-controls="sc4">
              <i class="zmdi zmdi-edit"></i>Ayuda</a>
            <ul id="sc4" class="card-collapse collapse" role="tabpanel" aria-labelledby="sch4" data-parent="#slidebar-menu">
              <li>
                <a href="blog-sidebar.html">Video Tutorial</a>
              </li>
              <li>
                <a href="blog-sidebar2.html">Manual de Usuario</a>
              </li>
          </li>
        </ul>
      </div>
    </div>
    {!! Html::script('js/plugins.min.js') !!}
    {!! Html::script('js/app.min.js') !!}
    {!! Html::script('js/configurator.min.js') !!}
    <script>
      (function(i, s, o, g, r, a, m)
      {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function()
        {
          (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
          m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
      })(window, document, 'script', '../../../../www.google-analytics.com/analytics.js', 'ga');
      ga('create', 'UA-90917746-2', 'auto');
      ga('send', 'pageview');
    </script>
  </body>
</html>