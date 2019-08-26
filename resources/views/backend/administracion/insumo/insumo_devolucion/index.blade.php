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
                                    <i class="livicon" data-name="check" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> REGISTRO DEVOLUCIONES
                                </h3>
                                
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    
                                    <!--start-->
                                    <div class="col-sm-4 social-buttons">
                                
                                         
                                            <a href="{{ url('DevolucionInsumo') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>DEVOLUCIÓN</h4>
                                                      <p>INSUMO SOBRANTE</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/sobrante.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                       
                                            <a href="{{ url('DevolucionDefectuoso') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>DEVOLUCIONES</h4>
                                                      <p>DEFECTUOSA</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/devolucion recibida.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a> 
                                         
                                            <a href="{{ url('DevolucionRecibida') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>DEVOLUCIONES</h4>
                                                      <p>RECIBIDAS</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/devolucion recibida.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a> 
                                        
                                    </div>
                                    <div class="col-sm-8">
                                        <img src="{{ asset('img/devoluciones.jpg') }}" width="100%" height="100%" alt="Imagen Registro de Insumos" class="img-responsive">
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
