@extends('backend.template.app')
@section('main-content')
	<div class="container spark-screen">
		<div class="row">
	<div class="paddingleft_right15">
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-heading text-center">
                                <h3 class="panel-title" style="font-family: 'Arial Black'">
                                    <i class="livicon" data-name="check" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> <strong>DATOS</strong>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <?php
                                        $idrol=Session::get('ID_ROL');
                                    ?>
                                    
                                    <div class="col-sm-4 social-buttons">
                                        
                                            <a href="{{ url('Menutransportista') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>TRANSPORTISTA</h4>
                                                      <p style="color:#2376bd">.</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/solicitud receta.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="{{ url('MenuCanastillos') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>CANASTILLOS</h4>
                                                      <p style="color:#2376bd">.</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/solicitud receta.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="{{ url('MenuDestinos') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>DESTINOS</h4>
                                                      <p style="color:#2376bd">.</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/solicitud receta.png" alt="" width="80">
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
                                          @if($idrol==1 or $idrol==20)
                                            
                                        @endif 
                                        </div>
                                        <div class="col-sm-6">
                                          @if($idrol==1 or $idrol==20)
                                            
                                        @endif 
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
