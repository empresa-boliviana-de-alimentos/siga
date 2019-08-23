@inject('menuPlantasMiel','siga\Http\Controllers\MenuController')
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
                         <i class="livicon" data-name="check" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>ACOPIO MIEL
                    </h3>
                </div>
                <div class="panel-body" style="background: #e7e9ea;">
                    <div class="row">
                        <!--start-->
                        <div class="col-sm-4 social-buttons" >
                            <!-- <h3>MENU</h3>
                                 -->
                                @php
                                  $idrol=Session::get('ID_ROL');
                                @endphp
                                @if($idrol == 1)                                
                                    <li class="dropdown small-box bg-brown-gradient ">
                                        <div class="inner">
                                            <h4>CAMBIO DE PLANTA</h4>
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: white;"> SELECCIONE UNA PLANTA<span class="caret"></span>
                                            </a>
                                            <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #ff883e ">
                                              <li>
                                                  <!-- <span class="item">
                                                    <span class="item-left"> -->
                                                         @foreach ($menuPlantasMiel->menuPlantasMiel() as $menuPl)
                                                            <li style="border-bottom: solid 1px #000;"><a href="/CambioPlantasAdministrador/{{$menuPl->id_planta}}/3" class="cambioPlantasMiel"><img src="/img/icono_plantas.png" width="25" height="25" alt="">&nbsp;&nbsp;<span style="color: white"> {{ $menuPl->nombre_planta }}</span></a></li>
                                                         @endforeach                                                 
                                                    <!-- </span>
                                                </span> -->
                                              </li>
                                            </ul>
                                        </div>
                                        <div class="icon efectoicon">
                                            <img src="img/botones/almacenes_cambio_miel.png" alt="" width="80">
                                        </div>
                                    </li>                                
                                @endif
                                <a href="{{ url('ProveedorMiel') }}">
                                    <div class="small-box bg-brown-gradient efectoboton">
                                        <div class="inner">
                                            <h4>PROVEEDORES</h4>
                                            <p>REGISTRO DE PROVEEDORES</p>
                                        </div>
                                        <div class="icon efectoicon">
                                            <img src="img/botones/proveedores_miel.png" alt="" width="80">
                                        </div>
                                    </div>
                                </a>
                                
                                <a href="{{ url('AcopioMiel') }}">
                                    <div class="small-box bg-brown-gradient efectoboton">
                                        <div class="inner">
                                            <h4>REGISTRO DE ACOPIOS</h4>
                                            <p>FONDOS EN AVANCE</p>
                                        </div>
                                        <div class="icon efectoicon">
                                            <img src="img/botones/acopio_miel.png" alt="" width="80">
                                        </div>
                                    </div>
                                </a>
                        
                                <a href="{{ url('AcopioMielConvenio') }}">
                                    <div class="small-box bg-brown-gradient efectoboton">
                                        <div class="inner">
                                            <h4>REGISTRO DE ACOPIOS</h4>
                                            <p>CONVENIOS</p>
                                        </div>
                                        <div class="icon efectoicon">
                                            <img src="img/botones/acopio_miel.png" alt="" width="80">
                                        </div>
                                    </div>
                                </a>
                                
                                <a href="{{ url('AcopioMielProduccion') }}">
                                    <div class="small-box bg-brown-gradient efectoboton">
                                        <div class="inner">
                                            <h4>REGISTRO DE ACOPIOS</h4>
                                            <p>PRODUCCION PROPIA</p>
                                        </div>
                                        <div class="icon efectoicon">
                                            <img src="img/botones/acopio_miel.png" alt="" width="80">
                                        </div>
                                    </div>
                                </a>
                                
                                

                                
                            
                        </div>
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-12">
                                    <img src="{{ asset('img/acopio_miel.jpg') }}" alt="Imagen Acopio Almendra" class="img-responsive">
                                </div>
                            </div>
                            <br><br>
                            <div class="row">
                                <div class="col-sm-6">
                                    <a href="{{ url('AcopioReportes') }}">
                                        <div class="small-box bg-brown-gradient efectoboton">
                                            <div class="inner">
                                                <h4>REPORTES</h4>
                                                <p>REPORTES ACOPIO MIEL</p>
                                            </div>
                                            <div class="icon efectoicon">
                                                <img src="img/botones/reportes_miel.png" alt="" width="80">
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-6">
                                    <a href="{{ url('AcopioMielEnvioAlm') }}">
                                        <div class="small-box bg-brown-gradient efectoboton">
                                            <div class="inner">
                                                <h4>ENVIO ALMACEN</h4>
                                                <p>ENVIO DE MATERIA PRIMA</p>
                                            </div>
                                            <div class="icon efectoicon">
                                                <img src="img/botones/envios_miel.png" alt="" width="80">
                                            </div>
                                        </div>
                                    </a>
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
