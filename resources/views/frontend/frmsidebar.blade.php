<header class="ms-header ms-header-primary">
        <!--ms-header-primary-->
        <div class="container container-full">
          <div class="ms-title">
            <a href="index-2.html">
              <img src="img/email/EBA2019.png" alt="" style="height: 5vw; width: 5vw; border: 2px solid #fff;border-radius: 50%;box-shadow: 0 0 5px gray;display: inline-block;margin-left: auto;margin-right: auto;">
              <h1 class="animated fadeInRight animation-delay-6">
                <span>SIGA</span>
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
                <strong>SIGA</strong>
              </span>
            </a>
          </div>
          <div class="collapse navbar-collapse" id="ms-navbar">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                  <a href="{{url('/')}}" class="nav-link dropdown-toggle animated fadeIn animation-delay-7">Inicio
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle animated fadeIn animation-delay-7" data-toggle="dropdown" data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-name="page">Acerca de 
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle animated fadeIn animation-delay-8" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" data-name="portfolio">Ayuda
                  <i class="zmdi zmdi-chevron-down"></i>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a class="dropdown-item" href="portfolio-filters_sidebar.html">
                      <i class="zmdi zmdi-card-membership"></i>Video Tutorial</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="/manuales/manual_siga_v3.pdf" target="_blanck">
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
    