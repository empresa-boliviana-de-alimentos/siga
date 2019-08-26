@extends('backend.template.app')

@section('htmlheader_title')
	Home
@endsection

@if(Session::has('message'))
<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</botton>
	{{Session::get('message')}}
</div>
@endif
@section('main-content')
	<div class="container spark-screen">
		<div class="row">
	<div class="paddingleft_right15">
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-heading text-center">
                                <h3 class="panel-title" style="font-family: 'Arial Black'">
                                    <i class="livicon" data-name="check" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> SOLICITUDES
                                </h3>
                               <!--  <span class="pull-right clickable">
                                    <i class="glyphicon glyphicon-chevron-up"></i>
                                </span> -->
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    
                                    <!--start-->
                                    <div class="col-sm-4 social-buttons">
                                        <!-- <h3>MENU</h3> -->
                                        
                                            <a href="{{ url('OrdenProduccion') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>ORDEN DE PRODUCCIÓN</h4>
                                                      <p style="color:#2376bd">.</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/solicitud receta.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                        
                                            <a href="{{ url('RecepcionORP') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>RECEPCIÓN ORP</h4>
                                                      <p style="color:#2376bd">.</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/solicitud receta.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                       
                                            <a href="{{ url('SolOrpReceta') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>SOLICITAR RECETA</h4>
                                                      <p>A ALMACÉN</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/solicitud receta.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                        
                                            <a href="{{ url('solInsumoAd') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>SOLICITUD POR INSUMO</h4>
                                                      <p>ADICIONAL ORP</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/insumo adicional.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                         
                                            <a href="{{url('solTraspaso')}}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>SOLICITUD POR</h4>
                                                      <p>INSUMO TRASPASO</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/traspaso.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                       
                                            <a href="{{url('solMaquila')}}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>SOLICITUD POR</h4>
                                                      <p>INSUMO MAQUILA</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/traspaso.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                        
                                            <a href="{{url('solRecibidas') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>SOLICITUDES</h4>
                                                      <p>RECIBIDAS</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/solicitud recibida.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                                                        
                                    </div>
                                    <div class="col-sm-8">
                                      <div class="row">
                                        <img src="{{ asset('img/solicitudes.jpg') }}" width="100%" height="100%" alt="Imagen Acopio Almendra" class="img-responsive">
                                      </div>
                                      <br><br>                                       
                                      <div class="row">
                                        <div class="col-sm-6">
                                         
                                           
                                        
                                        </div>
                                        <div class="col-sm-6">
                                         
                                        </div>
                                      </div>
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
