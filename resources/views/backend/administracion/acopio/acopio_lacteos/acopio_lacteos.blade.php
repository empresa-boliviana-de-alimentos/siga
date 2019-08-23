@inject('menuPlantasLacteos','siga\Http\Controllers\MenuController')
@extends('backend.template.app')
@section('main-content')
<div class="container spark-screen">
        <div class="row">
           <div class="paddingleft_right15">
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-heading text-center">
                                <h3 class="panel-title" style="font-family: 'Arial Black'">
                                    <i class="livicon" data-name="check" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> ACOPIO LACTEOS
                                </h3>
                            </div>
                            <div class="panel-body" style="background: #e7e9ea;">
                                <div class="row">
                                    <!--start-->
                                     <?php
                                         $idrol=Session::get('ID_ROL');
                                    ?>

                                    <div class="col-sm-4 social-buttons">
                                          <!-- <h3>MENU</h3> -->
                                            
                                           <!--  <a href="{{ url('ProveedorL') }}">
                                              <div class="small-box bg-blue-gradient efectoboton">
                                                <div class="inner">
                                                  <h4>PROVEEDORES</h4>
                                                  <p>REGISTROS DE PROVEEDORES</p>
                                                </div>
                                                <div class="icon efectoicon">
                                                  <img src="img/botones/proveedores_lacteos.png" alt="" width="80">
                                                </div>
                                              </div>
                                            </a> -->
                                          @if($idrol == 1)                                
                                              <li class="dropdown small-box bg-blue-gradient ">
                                                  <div class="inner">
                                                      <h4>CAMBIO DE PLANTA</h4>
                                                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: white;"> SELECCIONE UNA PLANTA<span class="caret"></span>
                                                      </a>
                                                      <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                        <li>
                                                            <!-- <span class="item">
                                                              <span class="item-left"> -->
                                                                   @foreach ($menuPlantasLacteos->menuPlantasLacteos() as $menuPl)
                                                                      <li style="border-bottom: solid 1px #000;"><a href="/CambioPlantasAdministrador/{{$menuPl->id_planta}}/2" class="cambioPlantasLacteos"><img src="/img/icono_plantas.png" width="25" height="25" alt="">&nbsp;&nbsp;<span style="color: white">{{ $menuPl->nombre_planta }}</span></a></li>
                                                                   @endforeach                                                 
                                                              <!-- </span>
                                                          </span> -->
                                                        </li>
                                                      </ul>
                                                  </div>
                                                  <div class="icon efectoicon">
                                                      <img src="img/botones/almacenes_cambio_lacteos.png" alt="" width="80">
                                                  </div>
                                              </li>                                
                                          @endif
                                          @if($idrol==1 or $idrol==7 or $idrol==23 or $idrol==29)
                                            <a href="{{ url('ModuloLacteos') }}">
                                              <div class="small-box bg-blue-gradient efectoboton">
                                                <div class="inner">
                                                  <h4>CENTROS ACOPIOS/MODULOS</h4>
                                                  <p>ACOPIO CENTROS</p>
                                                </div>
                                                <div class="icon efectoicon">
                                                  <img src="img/botones/acopio_lacteos.png" alt="" width="80">
                                                </div>
                                              </div>
                                            </a>
                                           @endif 

                                           @if($idrol==1 or $idrol==30 or $idrol==23 or $idrol==29)
                                            <a href="{{ url('AcopioRecepcion') }}">
                                              <div class="small-box bg-blue-gradient efectoboton">
                                                <div class="inner">
                                                  <h4>RECEPCIÓN PLANTA</h4>
                                                  <p>ACOPIO PLANTA</p>
                                                </div>
                                                <div class="icon efectoicon">
                                                  <img src="img/botones/acopio_planta_lacteos.png" alt="" width="80">
                                                </div>
                                              </div>
                                            </a>
                                            @endif
                                            
                                            @if($idrol==1 or $idrol==5 or $idrol==23 or $idrol==29)
                                            <a href="{{ url('AcopioLacteosPlantas') }}">
                                              <div class="small-box bg-blue-gradient efectoboton">
                                                <div class="inner">
                                                  <h4>CONTROL DE CALIDAD</h4>
                                                  <p>ACOPIO CONTROL</p>
                                                </div>
                                                <div class="icon efectoicon">
                                                  <img src="img/botones/acopio_planta_lacteos.png" alt="" width="80">
                                                </div>
                                              </div>
                                            </a>
                                            @endif

                                            @if($idrol==1 or $idrol==4 or $idrol==23 or $idrol==29)
                                            <a href="{{ url('AcopioLacteosEnvioAlm') }}">
                                              <div class="small-box bg-blue-gradient efectoboton">
                                                <div class="inner">
                                                  <h4>ENVIO ALMACEN</h4>
                                                  <p>ENVIO DE MATERIA PRIMA</p>
                                                </div>
                                                <div class="icon efectoicon">
                                                  <img src="img/botones/envios_lacteos.png" alt="" width="80">
                                                </div>
                                              </div>
                                            </a>
                                            @endif
                                    </div>
                                    <div class="col-sm-8">
                                        <img src="{{ asset('img/acopio_lacteos.jpg') }}" alt="Imagen Acopio Lacteos" class="img-responsive">    
                                    </div>
                                    
                                </div>
                                <!--end-->
                            </div>
                        </div>
                    </div>
                </div>
</div>
    </div>

@endsection

