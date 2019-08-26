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
                                    <!--start-->
                                    
                                    <div class="col-sm-4 social-buttons">
                                        
                                            <!--<a href="{{ url('ListKardex') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>KARDEX</h4>
                                                      <p>POR INSUMO</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/reportes_lacteos.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>-->
                                            
                                            <!--<a href="{{ url('RpInventarioGeneral') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>INVENTARIO GENERAL</h4>
                                                      <p style="color: #2477bf">GENERAL</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/reportes_lacteos.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>-->
                                            
                                          
                                            <a href="{{ url('RpMensual') }}" target="_blank">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <!--<h4>REPORTE</h4>
                                                      <p>MENSUAL</p>-->
                                                      <h4>MENSUAL</h4>
                                                      <p style="color: #2477bf">.</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/reporte mensual.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                             
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
                                             
                                            <a href="{{ url('ListaIngresoAlm') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>INGRESO POR ALMACÉN</h4>
                                                      <p style="color: #2477bf">.</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/reportes_lacteos.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                             <a href="{{ url('ListaSolicitudAlm') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>SOLICITUD ALMACÉN</h4>
                                                      <p style="color: #2477bf">.</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/reportes_lacteos.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="{{ url('ListaSalidaAlm') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>SALIDA POR ALMACÉN</h4>
                                                      <p style="color: #2477bf">.</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/reportes_lacteos.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                            <!--<a href="{{ url('RptIngresoGeneralInsumo') }}" target="_blank">
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