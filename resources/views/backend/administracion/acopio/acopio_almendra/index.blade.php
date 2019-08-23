@inject('menuPlantasAlmendra','siga\Http\Controllers\MenuController')
@extends('backend.template.app')
@section('main-content')

<div class="container spark-screen">
		<div class="row">
	       <div class="paddingleft_right15">
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-heading text-center">
                                <h3 class="panel-title" style="font-family: 'Arial Black'">
                                    <i class="livicon" data-name="check" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> ACOPIO ALMENDRA
                                </h3>
                            </div>
                            <div class="panel-body" style="background: #e7e9ea;">
                                
                                <div class="row">
                                    <!--start-->
                                    <?php
                                         $idrol=Session::get('ID_ROL');
                                ?>
                                    <div class="col-sm-4 social-buttons">
                                          
                                          @if($idrol == 1)                                
                                              <li class="dropdown small-box bg-green-gradient ">
                                                  <div class="inner">
                                                      <h4>CAMBIO DE PLANTA</h4>
                                                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: white;">SELECCIONE UNA PLANTA<span class="caret"></span>
                                                      </a>
                                                      <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #51d669">
                                                        <li>
                                                          <!-- <span class="item">
                                                            <span class="item-left"> -->
                                                              @foreach ($menuPlantasAlmendra->menuPlantasAlmendra() as $menuPl)
                                                                <li style="border-bottom: solid 1px #000;"><a href="/CambioPlantasAdministrador/{{$menuPl->id_planta}}/1" class="cambioPlantasAlmendra"><img src="/img/icono_plantas.png" width="25" height="25" alt="">&nbsp;&nbsp;<span style="color: white">{{ $menuPl->nombre_planta }}</span></a></li>
                                                              @endforeach                                                 
                                                            <!-- </span>
                                                          </span> -->
                                                        </li>
                                                      </ul>
                                                  </div>
                                                  <div class="icon efectoicon">
                                                      <img src="img/botones/almacenes_cambio_almendra.png" alt="" width="80">
                                                  </div>
                                              </li>                                
                                          @endif
                                          @if($idrol==1 or $idrol==2 or $idrol==9 or $idrol==13)
                                            <a href="{{ url('Proveedor') }}">
                                              <div class="small-box bg-green-gradient efectoboton">
                                                <div class="inner">
                                                  <h4>PROVEEDORES</h4>
                                                  <p>REGISTRO DE PROVEEDORES</p>
                                                </div>
                                                <div class="icon efectoicon">
                                                  <img src="img/botones/proveedores_almendra.png" alt="" width="80">
                                                </div>
                                              </div>
                                            </a>
                                        @endif 
                                            
                                        @if($idrol==1 or $idrol==2 or $idrol==9 or $idrol==13)
                                        <a href="{{ url('Acopio') }}" class="small-box-footer">
                                            <div class="small-box bg-green-gradient efectoboton">
                                                <div class="inner">
                                                  <h4>ACOPIOS</h4>
                                                  <p>REGISTRO DE ACOPIOS</p>
                                                </div>
                                                <div class="icon efectoicon">
                                                  <img src="img/botones/acopio_almendra.png" alt="" width="80">
                                                </div>                                                
                                            </div>
                                        </a>
                                        @endif  
                                                                  
                                        @if($idrol==1 or $idrol==2 or $idrol==3 or $idrol==13)
                                        <a href="{{ url('SolicitudA') }}" class="small-box-footer">
                                            <div class="small-box bg-green-gradient efectoboton">
                                                <div class="inner">
                                                  <h4>SOLICITUDES</h4>
                                                  <p>REGISTRO DE SOLICITUDES</p>
                                                </div>
                                                <div class="icon efectoicon">
                                                  <img src="img/botones/solicitud_almendra.png" alt="" width="80">
                                                </div>
                                            </div>
                                        </a>
                                        @endif
                                        @if($idrol==1 or $idrol==2 or $idrol==9 or $idrol==3 or $idrol==13)
                                        <a href="{{ url('ReportesA') }}" class="small-box-footer">
                                            <div class="small-box bg-green-gradient efectoboton">
                                                <div class="inner">
                                                  <h4>REPORTES</h4>
                                                  <p>REPORTES ALMENDRA</p>
                                                </div>
                                                <div class="icon efectoicon">
                                                  <img src="img/botones/reportes_almendra.png" alt="" width="80">
                                                </div>
                                              </div>
                                        </a>                                        
                                        @endif
                                        @if($idrol==2)
                                        <a href="{{ url('SolicitudCambio') }}" class="small-box-footer">
                                            <div class="small-box bg-green-gradient efectoboton">
                                                <div class="inner">
                                                  <h4>CAMBIOS</h4>
                                                  <p>Y/O MODIFICACIONES</p>
                                                </div>
                                                <div class="icon efectoicon">
                                                  <img src="img/botones/reportes_almendra.png" alt="" width="80">
                                                </div>
                                            </div>
                                        </a>
                                        @endif
                                        @if($idrol==13)
                                        <a href="{{ url('SolicitudRecibidaCambio') }}" class="small-box-footer">
                                            <div class="small-box bg-green-gradient efectoboton">
                                                <div class="inner">
                                                  <h4>SOLICITUDES CAMBIOS</h4>
                                                  <p>Y/O MODIFICACIONES</p>
                                                </div>
                                                <div class="icon efectoicon">
                                                  <img src="img/botones/reportes_almendra.png" alt="" width="80">
                                                </div>
                                            </div>
                                        </a>
                                        @endif
                                        @if($idrol==33)
                                        <a href="{{ url('SolicitudRecibidaCambioGerente') }}" class="small-box-footer">
                                            <div class="small-box bg-green-gradient efectoboton">
                                                <div class="inner">
                                                  <h4>SOLICITUDES CAMBIOS</h4>
                                                  <p>Y/O MODIFICACIONES</p>
                                                </div>
                                                <div class="icon efectoicon">
                                                  <img src="img/botones/reportes_almendra.png" alt="" width="80">
                                                </div>
                                            </div>
                                        </a>
                                        @endif                         
                                        
                                    </div>
                                    <div class="col-sm-8">
                                      <div class="row">
                                        <img src="{{ asset('img/acopio_almendra.jpg') }}" alt="Imagen Acopio Almendra" class="img-responsive">
                                      </div>
                                      <br>
                                      @if($idrol==1)
                                      <div class="row">
                                          <div class="col-sm-6">
                                            <a href="{{ url('SolicitudRecibidaCambioGerente') }}" class="small-box-footer">
                                                <div class="small-box bg-green-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>SOLICITUDES CAMBIOS</h4>
                                                      <p>Y/O MODIFICACIONES</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/reportes_almendra.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                          </div>
                                      </div>
                                      @endif 
                                      @if($idrol==1 or $idrol==2 or $idrol==9 or $idrol==13)
                                      <!-- <div class="row">
                                          <div class="col-sm-6">
                                            <a href="{{ url('DevolucionDinero') }}" class="small-box-footer">
                                            <div class="small-box bg-green-gradient efectoboton">
                                                <div class="inner">
                                                  <h4>DEVOLUCIONES (PRUEBA)</h4>
                                                  <p>DEVOLUCIONES DE DINERO SOBRANTE</p>
                                                </div>
                                                <div class="icon efectoicon">
                                                  <img src="img/botones/envios_almendra.png" alt="" width="80">
                                                </div>                                                
                                              </div>
                                        </a>
                                          </div>
                                          <div class="col-sm-6">
                                            <a href="{{ url('EnvioAcopioAlm') }}" class="small-box-footer">
                                            <div class="small-box bg-green-gradient efectoboton">
                                                <div class="inner">
                                                  <h4>ENVIO ALMACEN (PRUEBA)</h4>
                                                  <p>ENVIO DE CASTAÑA</p>
                                                </div>
                                                <div class="icon efectoicon">
                                                  <img src="img/botones/envios_almendra.png" alt="" width="80">
                                                </div>                                                
                                              </div>
                                        </a>  
                                          </div>
                                      </div> -->
                                      @endif      
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
