@extends('backend.template.app')
@section('main-content')

<div class="container spark-screen">
        <div class="row">
    <div class="paddingleft_right15">
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-heading text-center">
                                <h3 class="panel-title" style="font-family: 'Arial Black'">
                                    <i class="livicon" data-name="check" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>REPORTES GENERAL
                                </h3>
                                
                            </div>
                            <div class="panel-body" style="background: #e7e9ea;">
                                <div class="row">
                                    <!--start-->
                                    <?php
                                         $idrol=Session::get('ID_ROL');
                                    ?>
                                    <div class="col-sm-4 social-buttons">
                                            
                                            <a href="{{ url('RpInventarioGeneral') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>INVENTARIO GENERAL</h4>
                                                      <p style="color: #2477bf">GENERAL</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/reportes_lacteos.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>

                                            <li class="dropdown small-box bg-blue-gradient">
                                                <div class="inner">
                                                  <h4> INGRESO GENERAL</h4>
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: white;"> SELECCIONE TIPO DE ARCHIVO<span class="caret"></span>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                      <li class="dropdown-submenu">
                                                        <a href="{{url('ListarReporteGralIngreso')}}" class="test cambioPlantasLacteos" tabindex="-1" href="#" style="color:white"><span class="fa fa-file-o"></span> LISTADO GENERAL</a>
                                                        <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                        </ul>
                                                      </li>
                                                      <li class="dropdown-submenu">
                                                        <a href="{{url('ReportePdfIngresoGral')}}" target="_blank" class="test cambioPlantasLacteos" tabindex="-1" href="#" style="color:white"><span class="fa fa-file-o"></span>  PDF GENERICO</a>
                                                        <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                        </ul>
                                                      </li>
                                                      <li class="dropdown-submenu">
                                                        <a href="{{url('ReporteExcelIngresoGral')}}" target="_blank" class="test cambioPlantasLacteos" tabindex="-1" href="#" style="color:white"><span class="fa fa-file-excel-o"></span>  EXCEL GENERICO</a>
                                                        <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                        </ul>
                                                      </li>                                                      
                                                    </ul>
                                                </div>
                                                <div class="icon efectoicon">
                                                    <img src="img/botones/reportes_lacteos.png" alt="" width="80">
                                                </div>                                              
                                              </li>                                    
                                            <!--<a href="{{ url('ListarReporteGralIngreso') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>INGRESO GENERAL</h4>
                                                      <p style="color: #2477bf">.</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/reportes_lacteos.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>-->
                                            <li class="dropdown small-box bg-blue-gradient">
                                                <div class="inner">
                                                  <h4> SOLICITUD GENERAL</h4>
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: white;"> SELECCIONE TIPO DE ARCHIVO<span class="caret"></span>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                      <li class="dropdown-submenu">
                                                        <a href="{{url('ListarReporteGralSolicitudes')}}" class="test cambioPlantasLacteos" tabindex="-1" href="#" style="color:white"><span class="fa fa-file-o"></span> LISTADO GENERAL</a>
                                                        <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                        </ul>
                                                      </li>
                                                      <li class="dropdown-submenu">
                                                        <a href="{{url('ReportePdfSolicitudGral')}}" target="_blank" class="test cambioPlantasLacteos" tabindex="-1" href="#" style="color:white"><span class="fa fa-file-o"></span>  PDF GENERICO</a>
                                                        <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                        </ul>
                                                      </li>
                                                      <li class="dropdown-submenu">
                                                        <a href="{{url('ReporteExcelSolicitudGral')}}" target="_blank" class="test cambioPlantasLacteos" tabindex="-1" href="#" style="color:white"><span class="fa fa-file-excel-o"></span>  EXCEL GENERICO</a>
                                                        <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                        </ul>
                                                      </li>                                                      
                                                    </ul>
                                                </div>
                                                <div class="icon efectoicon">
                                                    <img src="img/botones/reportes_lacteos.png" alt="" width="80">
                                                </div>                                              
                                              </li>  
                                            <!--<a href="{{ url('ListarReporteGralSolicitudes') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>SOLICITUD GENERAL</h4>
                                                      <p style="color: #2477bf">.</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/reportes_lacteos.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>-->
                                            <li class="dropdown small-box bg-blue-gradient">
                                                <div class="inner">
                                                  <h4> SALIDA GENERAL</h4>
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: white;"> SELECCIONE TIPO DE ARCHIVO<span class="caret"></span>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                      <li class="dropdown-submenu">
                                                        <a href="{{url('ListarReporteGralSalidas')}}" class="test cambioPlantasLacteos" tabindex="-1" href="#" style="color:white"><span class="fa fa-file-o"></span> LISTADO GENERAL</a>
                                                        <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                        </ul>
                                                      </li>
                                                      <li class="dropdown-submenu">
                                                        <a href="{{url('ReportePdfSalidasGral')}}" target="_blank" class="test cambioPlantasLacteos" tabindex="-1" href="#" style="color:white"><span class="fa fa-file-o"></span>  PDF GENERICO</a>
                                                        <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                        </ul>
                                                      </li>
                                                      <li class="dropdown-submenu">
                                                        <a href="{{url('ReporteExcelSalidasGral')}}" target="_blank" class="test cambioPlantasLacteos" tabindex="-1" href="#" style="color:white"><span class="fa fa-file-excel-o"></span>  EXCEL GENERICO</a>
                                                        <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                        </ul>
                                                      </li>                                                      
                                                    </ul>
                                                </div>
                                                <div class="icon efectoicon">
                                                    <img src="img/botones/reportes_lacteos.png" alt="" width="80">
                                                </div>                                              
                                              </li>  
                                            <!--<a href="{{ url('ListarReporteGralSalidas') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>SALIDA GENERAL</h4>
                                                      <p style="color: #2477bf">.</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/reportes_lacteos.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>-->
                                            <!--<li class="dropdown small-box bg-blue-gradient">
                                                <div class="inner">
                                                  <h4> SALIDA GENERAL</h4>
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: white;"> SELECCIONE TIPO DE ARCHIVO<span class="caret"></span>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                      <li class="dropdown-submenu">
                                                        <a href="#" target="_blank" class="test cambioPlantasLacteos" tabindex="-1" href="#" style="color:white"><span class="fa fa-file-o"></span> LISTADO GENERAL</a>
                                                        <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                        </ul>
                                                      </li>
                                                      <li class="dropdown-submenu">
                                                        <a href="#" target="_blank" class="test cambioPlantasLacteos" tabindex="-1" href="#" style="color:white"><span class="fa fa-file-o"></span>  PDF GENERICO</a>
                                                        <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                        </ul>
                                                      </li>
                                                      <li class="dropdown-submenu">
                                                        <a href="#" target="_blank" class="test cambioPlantasLacteos" tabindex="-1" href="#" style="color:white"><span class="fa fa-file-excel-o"></span>  EXCEL GENERICO</a>
                                                        <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                        </ul>
                                                      </li>                                                      
                                                    </ul>
                                                </div>
                                                <div class="icon efectoicon">
                                                    <img src="img/botones/reportes_lacteos.png" alt="" width="80">
                                                </div>                                              
                                              </li>-->  
                                            <!--<a href="#">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>ORP - PEDIDOS</h4>
                                                      <p style="color: #2477bf">.</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/reportes_lacteos.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>-->
                                    </div>
                                    <div class="col-sm-8">
                                      <div class="row">
                                        <div class="col-sm-12"></div>
                                        <img src="{{ asset('img/reportes.jpg') }}" alt="Imagen Acopio Almendra" width="100%" height="100%" class="img-responsive"> 
                                      </div>
                                      <br>
                                                                                
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