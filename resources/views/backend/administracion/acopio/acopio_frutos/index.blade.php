<!-- 63@extends('backend.template.app')

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
@section('main-content') -->
@inject('menuPlantasFrutos','siga\Http\Controllers\MenuController')
@extends('backend.template.app')
@section('main-content')

    <div class="container spark-screen">
        <div class="row">
    <div class="paddingleft_right15">
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-heading  text-center">
                                <h3 class="panel-title" style="font-family: 'Arial Black'">
                                    <i class="livicon" data-name="check" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> ACOPIO FRUTOS
                                </h3>
                                
                            </div>
                            <div class="panel-body" style="background: #e7e9ea;">
                                <div class="row">

                                    <?php
                                         $idrol=Session::get('ID_ROL');
                                    ?>
                                    <!--start-->
                                    <div class="col-sm-4 social-buttons">
                                        @if($idrol == 1)                                
                                              <li class="dropdown small-box bg-yellow-gradient ">
                                                  <div class="inner">
                                                      <h4>CAMBIO DE PLANTA</h4>
                                                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: white;"> SELECCIONE UNA PLANTA<span class="caret"></span>
                                                      </a>
                                                      <ul class="dropdown-menu " role="menu" style="background: #f7be63">
                                                        <li>
                                                            <!-- <span class="item"> -->
                                                              <!-- <span class="item-left"> -->
                                                                   @foreach ($menuPlantasFrutos->menuPlantasFrutos() as $menuPl)
                                                                      <li style="border-bottom: solid 1px #dc921d;"><a href="/CambioPlantasAdministrador/{{$menuPl->id_planta}}/4" class="cambioPlantasFrutos"><img src="/img/icono_plantas.png" width="25" height="25" alt="">&nbsp;&nbsp;<span style="color: white"> {{ $menuPl->nombre_planta }}</span></a></li>
                                                                   @endforeach                                                 
                                                              <!-- </span> -->
                                                          <!-- </span> -->
                                                        </li>
                                                      </ul>
                                                  </div>
                                                  <div class="icon efectoicon">
                                                      <img src="img/botones/almacenes_cambio_frutos.png" alt="" width="80">
                                                  </div>
                                              </li>                                
                                          @endif
                                         @if($idrol==1 or $idrol==25 or $idrol==22)
                                        
                                            <a href="{{ url('ProveedorFrutos') }}">
                                                <div class="small-box bg-yellow-gradient efectoboton">
                                                    <div class="inner">
                                                        <h4>PROVEEDORES</h4>
                                                        <p>REGISTRO DE PROVEEDORES</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                        <img src="img/botones/proveedores_frutos.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a> 
                                            @endif 

                                            @if($idrol==1 or $idrol==26 or $idrol==22)
                                            <a href="{{ url('AcopioFrutosLab') }}">
                                                <div class="small-box bg-yellow-gradient efectoboton">
                                                    <div class="inner">
                                                        <h4>ANALISIS LABORATORIO</h4>
                                                        <p>REGISTRO DE ANALISIS</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                        <img src="img/botones/acopio_frutos.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                             @endif 

                                            @if($idrol==1 or $idrol==28 or $idrol==22)
                                            <a href="{{ url('AcopioFrutos') }}">
                                                <div class="small-box bg-yellow-gradient efectoboton">
                                                    <div class="inner">
                                                        <h4>ACOPIO RECEPCIÓN</h4>
                                                        <p>REGISTRO DE RECEPCIÓN ACOPIOS</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                        <img src="img/botones/acopio_frutos.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                             @endif 
                                            

                                        
                                            

                                            @if($idrol==1 or $idrol==27 or $idrol==22)

                                            <a href="{{ url('AcopioFrutosEnvioAlm') }}">
                                                <div class="small-box bg-yellow-gradient efectoboton">
                                                    <div class="inner">
                                                        <h4>ENVIO ALMACEN</h4>
                                                        <p>ENVIO DE MATERIA PRIMA</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                        <img src="img/botones/envios_frutos.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                            @endif 
                                                                                   
                                    </div>
                                    <div class="col-sm-8">
                                        <img src="{{ asset('img/acopio_frutos.jpg') }}" alt="Imagen Acopio Almendra" class="img-responsive">    
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
