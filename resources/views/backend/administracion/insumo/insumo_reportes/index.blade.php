@extends('backend.template.app')
@section('main-content')

<div class="container spark-screen">
        <div class="row">
    <div class="paddingleft_right15">
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-heading text-center">
                                <h3 class="panel-title" style="font-family: 'Arial Black'">
                                    <i class="livicon" data-name="check" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>REPORTES ALMACEN
                                </h3>                                
                            </div>
                            <div class="panel-body" style="background: #e7e9ea;">
                                <div class="row">                                    
                                    <div class="col-sm-4 social-buttons">
                                            <li class="dropdown small-box bg-blue-gradient">
                                                <div class="inner">
                                                  <h4> MENSUAL</h4>
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: white;"> SELECCIONE TIPO DE ARCHIVO<span class="caret"></span>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                      <li class="dropdown-submenu">
                                                        <a href="{{url('RpMensual')}}" target="_blank" class="test cambioPlantasLacteos" tabindex="-1" href="#" style="color:white"><span class="fa fa-file-o"></span> PDF</a>
                                                        <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                        </ul>
                                                      </li>
                                                      <li class="dropdown-submenu">
                                                        <a href="{{url('RpMensualExcel')}}" target="_blank" class="test cambioPlantasLacteos" tabindex="-1" href="#" style="color:white"><span class="fa fa-file-excel-o"></span>  EXCEL</a>
                                                        <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                        </ul>
                                                      </li>                                                      
                                                    </ul>
                                                </div>
                                                <div class="icon efectoicon">
                                                    <img src="img/botones/reporte mensual.png" alt="" width="80">
                                                </div>                                              
                                              </li>   
                                            <a href="{{ url('RpCostoAlmacen') }}" target="_blank">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>COSTO MENSUAL</h4>
                                                      <p style="color: #2477bf">.</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/reporte mensual.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                            <!--NUEVO BOTON-->
                                            <li class="dropdown small-box bg-blue-gradient">
                                                <div class="inner">
                                                  <h4> INGRESO POR ALMACÉN</h4>
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: white;"> SELECCIONE UNA OPCIÓN<span class="caret"></span>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                      <li class="dropdown-submenu">
                                                        <a href="{{url('ReporteIngresoAlmacen')}}" class="test cambioPlantasLacteos" tabindex="-1" href="#" style="color:white"><span class="fa fa-file-o"></span> LISTADO INGRESOS</a>
                                                        <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                        </ul>
                                                      </li>
                                                      <li class="dropdown-submenu">
                                                        <a href="{{url('ListaIngresoAlm')}}" class="test cambioPlantasLacteos" tabindex="-1" href="#" style="color:white"><span class="fa fa-file-o"></span> LISTADO INGRESOS DE INSUMOS</a>
                                                        <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                        </ul>
                                                      </li>                                                     
                                                    </ul>
                                                </div>
                                                <div class="icon efectoicon">
                                                    <img src="img/botones/reportes_lacteos.png" alt="" width="80">
                                                </div>                                              
                                              </li>  
                                            <!--END NUEVO BOTON-->
                                             <!--<a href="{{ url('ListaSolicitudAlm') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>SOLICITUD ALMACÉN</h4>
                                                      <p style="color: #2477bf">.</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/reportes_lacteos.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>-->
                                            <li class="dropdown small-box bg-blue-gradient">
                                              <div class="inner">
                                                  <h4> SOLICITUD POR ALMACÉN</h4>
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: white;"> SELECCIONE UNA OPCIÓN<span class="caret"></span>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                      <li class="dropdown-submenu">
                                                        <a href="{{url('ListaSolicitudAlm')}}" class="test cambioPlantasLacteos" tabindex="-1" href="#" style="color:white"><span class="fa fa-file-o"></span> LISTADO SOLICITUDES</a>
                                                        <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                        </ul>
                                                      </li>
                                                      <li class="dropdown-submenu">
                                                        <a href="{{url('ListaSolicitudAlmInsumos')}}" class="test cambioPlantasLacteos" tabindex="-1" href="#" style="color:white"><span class="fa fa-file-o"></span> LISTADO SOLICITUDES POR INSUMOS </a>
                                                        <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                        </ul>
                                                      </li>                                                     
                                                    </ul>
                                                </div>
                                                <div class="icon efectoicon">
                                                    <img src="img/botones/reportes_lacteos.png" alt="" width="80">
                                                </div>                                              
                                            </li>
                                            
                                            <li class="dropdown small-box bg-blue-gradient">
                                              <div class="inner">
                                                  <h4> SALIDA POR ALMACÉN</h4>
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: white;"> SELECCIONE UNA OPCIÓN<span class="caret"></span>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                      <li class="dropdown-submenu">
                                                        <a href="{{url('ListaSalidaAlm')}}" class="test cambioPlantasLacteos" tabindex="-1" href="#" style="color:white"><span class="fa fa-file-o"></span> LISTADO SALIDAS</a>
                                                        <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                        </ul>
                                                      </li>
                                                      <li class="dropdown-submenu">
                                                        <a href="{{url('ListaSalidaAlmInsumos')}}" class="test cambioPlantasLacteos" tabindex="-1" href="#" style="color:white"><span class="fa fa-file-o"></span> LISTADO SALIDAS DE INSUMOS </a>
                                                        <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                        </ul>
                                                      </li>                                                     
                                                    </ul>
                                                </div>
                                                <div class="icon efectoicon">
                                                    <img src="img/botones/reportes_lacteos.png" alt="" width="80">
                                                </div>                                              
                                            </li>                                  
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