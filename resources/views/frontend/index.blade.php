@extends('frontend.frmapp')
@section('main-content')
<div class="ms-hero ms-hero-material">
        <span class="ms-hero-bg"></span>
        <div class="container">
          <div class="row">
            <div class="col-xl-6 col-lg-7">
              <div id="carousel-hero" class="carousel slide carousel-fade" data-ride="carousel" data-interval="8000">
                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                  <div class="carousel-item active">
                    <div class="carousel-caption">
                      <div class="ms-hero-material-text-container">
                        <header class="ms-hero-material-title animated slideInLeft animation-delay-5">
                          <h1 class="animated fadeInLeft animation-delay-15 font-smoothing">Sistema Integrado
                            <strong>Gestion de Almacenes</strong> - EBA</h1>
                          <h2 class="animated fadeInLeft animation-delay-18">Empresa Boliviana 
                            <span class="color-warning">de Alimentos</span> y Derivados.</h2>
                        </header>
                        <ul class="ms-hero-material-list">
                          <li class="">
                            <div class="ms-list-icon animated zoomInUp animation-delay-18">
                              <span class="ms-icon ms-icon-circle ms-icon-xlg color-warning shadow-3dp">
                                <i class="zmdi zmdi-airplane"></i>
                              </span>
                            </div>
                            <div class="ms-list-text animated fadeInRight animation-delay-19">Registro actualizacion y eliminacion de productos en almacenes.
                            Busquedas, consultas por tipos de productos, Reportes, Estadisticas e indicadores de almacenamiento por gestion</div>
                          </li>
                        </ul>
                        <div class="ms-hero-material-buttons text-right">
                          <div class="ms-hero-material-buttons text-right">
                            <a href="{{url('/sesion')}}" class="btn btn-warning btn-raised animated fadeInLeft animation-delay-24 mr-2">
                              <i class="zmdi zmdi-settings"></i>INCIAR SESION</a>
                            <a href="{{url('/sesion')}}" class="btn btn-success btn-raised animated fadeInRight animation-delay-24">
                              <i class="zmdi zmdi-download"></i>PRODUCTOS</a>
                          </div>
                        </div>
                      </div>
                      <!-- ms-hero-material-text-container -->
                    </div>
                  </div>
                  <div class="carousel-item">
                    <div class="carousel-caption">
                      <div class="ms-hero-material-text-container">
                        <header class="ms-hero-material-title animated slideInLeft animation-delay-5">
                          <h1 class="animated fadeInLeft animation-delay-15">
                            <strong>Modulo Acopio</strong></h1>
                          <h2 class="animated fadeInLeft animation-delay-18">Se diferencia por el tipo de acopio de Almendra, Lacteos, Citricos y Miel
                            <span class="color-warning"></span> .</h2>
                        </header>
                        <ul class="ms-hero-material-list">
                          <li class="">
                            <div class="ms-list-icon animated zoomInUp animation-delay-18">
                              <span class="ms-icon ms-icon-circle ms-icon-xlg color-info shadow-3dp">
                                <i class="zmdi zmdi-city"></i>
                              </span>
                            </div>
                            <div class="ms-list-text animated fadeInRight animation-delay-19">Productos almendra, miel, lacteos, citricos, stevia ,acopio, presupuesto, proveedores, reportes, pagos y reporte de acopio general.</div>
                          </li>
                        </ul>
                        <div class="ms-hero-material-buttons text-right">
                          <div class="ms-hero-material-buttons text-right">
                            <a href="{{url('/sesion')}}" class="btn btn-warning btn-raised animated fadeInLeft animation-delay-24 mr-2">
                              <i class="zmdi zmdi-settings"></i>INICIAR SESION</a>
                            <a href="{{url('/session')}}" class="btn btn-success btn-raised animated fadeInRight animation-delay-24">
                              <i class="zmdi zmdi-download"></i>PRODUCTOS</a>
                          </div>
                        </div>
                      </div>
                      <!-- ms-hero-material-text-container -->
                    </div>
                  </div>
                  <div class="carousel-item">
                    <div class="carousel-caption">
                      <div class="ms-hero-material-text-container">
                        <header class="ms-hero-material-title animated slideInLeft animation-delay-5">
                          <h1 class="animated fadeInLeft animation-delay-15">
                            <strong>Modulo Insumos</strong>.</h1>
                          <h2 class="animated fadeInLeft animation-delay-18">Se registrara en inicio de la produccion y las normas existentes entre la materia prima y producto terminado y su uso para otra produccion.
                            <span class="color-warning"></span>.</h2>
                        </header>
                        <ul class="ms-hero-material-list">
                          <li class="">
                            <div class="ms-list-icon animated zoomInUp animation-delay-18">
                              <span class="ms-icon ms-icon-circle ms-icon-xlg color-danger shadow-3dp">
                                <i class="zmdi zmdi-cutlery"></i>
                              </span>
                            </div>
                            <div class="ms-list-text animated fadeInRight animation-delay-19">Insumos, Solicitudes, Kardex, Reportes.</div>
                          </li>
                        </ul>
                        <div class="ms-hero-material-buttons text-right">
                          <a href="{{url('/sesion')}}" class="btn btn-warning btn-raised animated fadeInLeft animation-delay-24 mr-2">
                            <i class="zmdi zmdi-settings"></i>INICIAR SESION</a>
                          <a href="{{url('/session')}}" class="btn btn-success btn-raised animated fadeInRight animation-delay-24">
                            <i class="zmdi zmdi-download"></i>PRODUCOS</a>
                        </div>
                      </div>
                      <!-- ms-hero-material-text-container -->
                    </div>
                  </div>
                  <div class="carousel-controls">
                    <!-- Controls -->
                    <a class="left carousel-control animated zoomIn animation-delay-30" href="#carousel-hero" role="button" data-slide="prev">
                      <i class="zmdi zmdi-chevron-left"></i>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control animated zoomIn animation-delay-30" href="#carousel-hero" role="button" data-slide="next">
                      <i class="zmdi zmdi-chevron-right"></i>
                      <span class="sr-only">Next</span>
                    </a>
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                      <li data-target="#carousel-hero" data-slide-to="0" class="animated fadeInUpBig animation-delay-27 active"></li>
                      <li data-target="#carousel-hero" data-slide-to="1" class="animated fadeInUpBig animation-delay-28"></li>
                      <li data-target="#carousel-hero" data-slide-to="2" class="animated fadeInUpBig animation-delay-29"></li>
                    </ol>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-6 col-lg-5">
              <div class="ms-hero-img animated zoomInUp animation-delay-30">
                <img src="img/inicio1.jpg" alt="" class="img-fluid" >
                <div id="carousel-hero-img" class="carousel carousel-fade slide" data-ride="carousel" data-interval="3000">
                  <!-- Indicators -->
                  <ol class="carousel-indicators carousel-indicators-hero-img">
                    <li data-target="#carousel-hero-img" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-hero-img" data-slide-to="1"></li>
                    <li data-target="#carousel-hero-img" data-slide-to="2"></li>
                  </ol>
                  <!-- Wrapper for slides -->
                  <div class="carousel-inner" role="listbox">
                    <div class="ms-hero-img-slider carousel-item active">
                      <img src="img/inicio1.jpg" alt="" class="img-fluid"> </div>
                    <div class="ms-hero-img-slider carousel-item">
                      <img src="img/inicio2.jpg" alt="" class="img-fluid"> </div>
                    <div class="ms-hero-img-slider carousel-item">
                      <img src="img/inicio3.jpg" alt="" class="img-fluid"> </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- container -->
      </div>
      <!-- ms-hero ms-hero-black -->
      <div class="container mt-4">
        <div class="row">
          <div class="ms-feature col-xl-3 col-lg-6 col-md-6 card wow flipInX animation-delay-4">
            <div class="text-center card-body">
              <span class="ms-icon ms-icon-circle ms-icon-xxlg color-info">
                <img src="img/eba.png" alt="" style="height: 5vw; width: 5vw; border: 2px solid #fff;border-radius: 50%;box-shadow: 0 0 5px gray;display: inline-block;margin-left: auto;margin-right: auto;">
              </span>
              <h4 class="color-info">Almendra</h4>
              <p class="">La almendra con calidad de exportación a tu alcance, en nuestras tiendas.</p>
              <a href="https://www.eba.com.bo/lineas-de-negocios__trashed/frutos-amazonicos-2/" target="_blank" class="btn btn-info btn-raised">Ver Amazonica</a>
            </div>
          </div>
          <div class="ms-feature col-xl-3 col-lg-6 col-md-6 card wow flipInX animation-delay-8">
            <div class="text-center card-body">
              <span class="ms-icon ms-icon-circle ms-icon-xxlg color-warning">
                <img src="img/miel.jpg" alt="" style="height: 5vw; width: 5vw; border: 2px solid #fff;border-radius: 50%;box-shadow: 0 0 5px gray;display: inline-block;margin-left: auto;margin-right: auto;">
              </span>
              <h4 class="color-warning">Miel de aveja</h4>
              <p class="">La miel naturalmente elaborada para el consumo diario.</p>
              <a href="https://www.eba.com.bo/lineas-de-negocios__trashed/endulzantes_bebidas/" target="_blank" class="btn btn-warning btn-raised">Ver Endulzantes</a>
            </div>
          </div>
          <div class="ms-feature col-xl-3 col-lg-6 col-md-6 card wow flipInX animation-delay-10">
            <div class="text-center card-body">
              <span class="ms-icon ms-icon-circle ms-icon-xxlg color-success">
                <img src="img/lacteo.jpg" alt="" style="height: 5vw; width: 5vw; border: 2px solid #fff;border-radius: 50%;box-shadow: 0 0 5px gray;display: inline-block;margin-left: auto;margin-right: auto;">
              </span>
              <h4 class="color-success">Lacteos</h4>
              <p class="">La leche y los productos lacteos son alimentos que tienen un perfil nutricional que los hace adecuados para la poblacion general..</p>
              <a href="https://www.eba.com.bo/lineas-de-negocios__trashed/lacteos/" target="_blank" class="btn btn-success btn-raised">Ver Lacteos</a>
            </div>
          </div>
          <div class="ms-feature col-xl-3 col-lg-6 col-md-6 card wow flipInX animation-delay-6">
            <div class="text-center card-body">
              <span class="ms-icon ms-icon-circle ms-icon-xxlg  color-danger">
                <img src="img/stevia.jpg" alt="" style="height: 5vw; width: 5vw; border: 2px solid #fff;border-radius: 50%;box-shadow: 0 0 5px gray;display: inline-block;margin-left: auto;margin-right: auto;">
              </span>
              <h4 class="color-danger">Frutos</h4>
              <p class="">El nectar o jugo envasado es una bebida que contiene parte de la pulpa de la fruta finamente ... Los nectares generalmente son elaborados con frutas de pulpa.</p>
              <a href="https://www.eba.com.bo/catalogo-de-productos/" target="_blank" class="btn btn-danger btn-raised">Ver Fruticolas</a>
            </div>
          </div>
        </div>
      </div>
      <!-- container -->
      @endsection