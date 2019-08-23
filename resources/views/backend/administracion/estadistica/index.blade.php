@extends('backend.template.app')
@section('main-content')

<div class="container spark-screen">
		<div class="row">
	       <div class="paddingleft_right15">
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-heading text-center">
                                <h3 class="panel-title" style="font-family: 'Arial Black'">
                                    <i class="livicon" data-name="check" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> REPORTES ESTADÍSITICOS
                                </h3>
                            </div>
                            <div class="panel-body" style="background: #e7e9ea;">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                        	<div class="col-lg-1">                                       		
                                        	</div>
                                        	<div class="col-lg-5">
                                        		<div class="row">
                                        			<div class="col-lg-2"></div>
	                                        		<div class="col-lg-8">
	                                        			<div class="hovereffect">
													        <img class="img-responsive" src="img/lacteos.gif" alt="">
													        <div class="overlay">
													           <h2 class="lacteos">ESTADISTICAS LÁCTEOS</h2>
													           <a class="info-lacteos" href="{{ url('EstadisticaLacteos') }}">CLICK PARA INGRESAR</a>
													        </div>
													    </div>
	                                        		</div>
	                                        		<div class="col-lg-2"></div>
                                        		</div>                                        		
                                        	</div>
                                        	<div class="col-lg-5">
                                        		<div class="row">
                                        			<div class="col-lg-2"></div>
	                                        		<div class="col-lg-8">
	                                        			<div class="hovereffect">
													        <img class="img-responsive" src="img/amazonica.gif" alt="">
													        <div class="overlay">
													           <h2 class="amazonica">ESTADÍSTICAS AMAZONICA</h2>
													           <a class="info-amazonica" href="{{ url('EstadisticaAlmendra') }}">CLICK PARA INGRESAR</a>
													        </div>
													    </div>
	                                        		</div>
	                                        		<div class="col-lg-2"></div>
                                        		</div> 
                                        	</div>
                                        	<div class="col-lg-1"></div>
                                        </div>
                                        <div class="row">
                                        	<div class="col-lg-1"></div>
                                        	<div class="col-lg-5">
                                        		<div class="row">
                                        			<div class="col-lg-2"></div>
	                                        		<div class="col-lg-8">
	                                           			<div class="hovereffect">
													        <img class="img-responsive" src="img/endulzantes.gif" alt="">
													        <div class="overlay">
													           <h2 class="endulzantes">ESTADÍSTICAS ENDULZANTES</h2>
													           <a class="info-endulzantes" href="{{ url('EstadisticaMiel') }}">CLICK PARA INGRESAR</a>
													        </div>
													    </div>
	                                        		</div>
	                                        		<div class="col-lg-2"></div>
                                        		</div> 
                                        	</div>
                                        	<div class="col-lg-5">
                                        		<div class="row">
                                        			<div class="col-lg-2"></div>
	                                        		<div class="col-lg-8 ">                                       			
	                                        			<div class="hovereffect">
													        <img class="img-responsive" src="img/fruticola.gif" alt="">
													        <div class="overlay">
													           <h2 class="fruticola">ESTADÍSTICAS FRUTICOLA</h2>
													           <a class="info-fruticola" href="{{ url('EstadisticaFrutos') }}">CLICK PARA INGRESAR</a>
													        </div>
													    </div>
	                                        		</div>
	                                        		<div class="col-lg-2"></div>
                                        		</div> 
                                        	</div>
                                        	<div class="col-lg-1"></div>
                                        </div>                                        
                                    </div>      
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</div>
	</div>
@endsection
