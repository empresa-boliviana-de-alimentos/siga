@extends('backend.template.app')
@section('main-content')

<div class="container spark-screen">
        <div class="row">
    <div class="paddingleft_right15">
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-heading text-center">
                                <h3 class="panel-title" style="font-family: 'Arial Black'">
                                    <i class="livicon" data-name="check" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>REPORTES ACOPIO MIEL
                                </h3>
                                
                            </div>
                            <div class="panel-body" style="background: #e7e9ea;">
                                <div class="row">
                                    <!--start-->
                                    <?php
                                         $idrol=Session::get('ID_ROL');
                                ?> 

                                    <div class="col-sm-4 social-buttons">
                                         @if($idrol==6)
                                            <a href="{{ url('AcopioReportesFondos') }}" target="_blank">
                                                <div class="small-box bg-brown-gradient efectoboton">
                                                    <div class="inner">
                                                        <h4>REPORTE</h4>
                                                        <p>FONDOS EN AVANCE PDF</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                        <img src="img/botones/reportes_miel.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                        @if($idrol==1 or $idrol==8 or $idrol==24)    
                                            <a href="{{ url('AcopioReportesFondosPlantas') }}" target="_blank">
                                                <div class="small-box bg-brown-gradient efectoboton">
                                                    <div class="inner">
                                                        <h4>REPORTE PLANTAS</h4>
                                                        <p>FONDOS EN AVANCE PDF</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                        <img src="img/botones/reportes_miel.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                        @if($idrol==1 or $idrol==8 or $idrol==24)    
                                            <a href="{{ url('AcopioReportesConvenio') }}" target="_blank">
                                                <div class="small-box bg-brown-gradient efectoboton">
                                                    <div class="inner">
                                                        <h4>REPORTE</h4>
                                                        <p>CONVENIOS PDF</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                        <img src="img/botones/reportes_miel.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                        @if($idrol==6)     
                                            <a href="{{ url('AcopioReportesProduccion') }}" target="_blank">
                                                <div class="small-box bg-brown-gradient efectoboton">
                                                    <div class="inner">
                                                        <h4>REPORTE</h4>
                                                        <p>PRODUCCIÓN PROPIA PDF</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                        <img src="img/botones/reportes_miel.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                        @if($idrol==1 or $idrol==8 or $idrol==24)     
                                            <a href="{{ url('AcopioReportesProduccionPlantas') }}" target="_blank">
                                                <div class="small-box bg-brown-gradient efectoboton">
                                                    <div class="inner">
                                                        <h4>REPORTE PLANTAS</h4>
                                                        <p>PRODUCCIÓN PROPIA PDF</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                        <img src="img/botones/reportes_miel.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                        @endif
                                    </div>
                                    <div class="col-sm-8">
                                        <img src="{{ asset('img/miel_reportes.jpg') }}" alt="Imagen Acopio Almendra" class="img-responsive">    
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