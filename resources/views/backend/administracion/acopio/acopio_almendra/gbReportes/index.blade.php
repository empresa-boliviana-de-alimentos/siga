@extends('backend.template.app')
@section('main-content')

<div class="container spark-screen">
		<div class="row">
	<div class="paddingleft_right15">
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-heading text-center">
                                <h3 class="panel-title" style="font-family: 'Arial Black'">
                                    <i class="livicon" data-name="check" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> REPORTES ACOPIO ALMENDRA
                                </h3>
                                
                            </div>
                            <div class="panel-body" style="background: #e7e9ea;">
                                <div class="row">
                                    <!--start-->
                                    <?php
                                         $idrol=Session::get('ID_ROL');
                                    ?>
                                    <div class="col-sm-4 social-buttons">
                                        <!-- <h3>REPORTES ALMENDRA</h3> -->
                                            
                                            <a href="{{ url('ReporteRecursos') }}" target="_blank">
                                              <div class="small-box bg-green-gradient efectoboton">
                                                <div class="inner">
                                                  <h4>RECURSOS</h4>
                                                  <p>REPORTE DE RECURSOS</p>
                                                </div>
                                                <div class="icon efectoicon">
                                                  <img src="img/botones/reportes_almendra.png" alt="" width="80">
                                                </div>
                                              </div>
                                            </a>
                                            
                                            <a href="{{ url('ReporteAcopio') }}" target="_blank">
                                              <div class="small-box bg-green-gradient efectoboton">
                                                <div class="inner">
                                                  <h4>ACOPIOS</h4>
                                                  <p>REPORTE DE ACOPIOS PDF</p>
                                                </div>
                                                <div class="icon efectoicon">
                                                  <img src="img/botones/reportes_almendra.png" alt="" width="80">
                                                </div>
                                              </div>
                                            </a>
                                            @if($idrol==13)
                                            <a href="{{ url('ReporteAcopioZona') }}" target="_blank">
                                              <div class="small-box bg-green-gradient efectoboton">
                                                <div class="inner">
                                                  <h4>ACOPIOS ZONA</h4>
                                                  <p>REPORTE DE ACOPIOS PDF</p>
                                                </div>
                                                <div class="icon efectoicon">
                                                  <img src="img/botones/reportes_almendra.png" alt="" width="80">
                                                </div>
                                              </div>
                                            </a>
                                            @endif
                                            @if($idrol==1 or $idrol==3 or $idrol==9 or $idrol==13)
                                            
                                            <a href="{{ url('ReporteAcopioExcel') }}">
                                              <div class="small-box bg-green-gradient efectoboton">
                                                <div class="inner">
                                                  <h4>ACOPIOS</h4>
                                                  <p>REPORTE DE ACOPIOS EXCEL</p>
                                                </div>
                                                <div class="icon efectoicon">
                                                  <img src="img/botones/reportes_almendra.png" alt="" width="80">
                                                </div>
                                              </div>
                                            </a>
                                            @endif     
                                    </div>
                                    <div class="col-sm-8">
                                        <img src="{{ asset('img/reportes_almendra.jpg') }}" alt="Imagen Acopio Almendra" class="img-responsive">    
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