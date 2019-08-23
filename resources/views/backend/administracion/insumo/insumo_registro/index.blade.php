@inject('menuPlantasInsumos','siga\Http\Controllers\MenuController')
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
<style>
.dropdown-submenu {
  position: relative;
}

.dropdown-submenu .dropdown-menu {
  top: 0;
  left: 100%;
  margin-top: -1px;
}
</style>
	<div class="container spark-screen">
		<div class="row">
	<div class="paddingleft_right15">
                    <div class="row">
                        <div class="panel panel-default">
                            <div class="panel-heading text-center">
                                <h3 class="panel-title" style="font-family: 'Arial Black'">
                                    <i class="livicon" data-name="check" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> REGISTROS
                                </h3>
                                <!-- <span class="pull-right clickable">
                                    <i class="glyphicon glyphicon-chevron-up"></i>
                                </span> -->
                            </div>
                            <!-- <div class="alert alert-success">
                              <a href="{{ url('UfvInsumo') }}" class="alert-link">No olvide registrar el UFV</a>
                            </div> -->
                            <div class="panel-body">
                                <div class="row">
                                    <?php
                                        $idrol=Session::get('ID_ROL');
                                    ?>
                                    <!--start-->                                    
                                    <div class="col-sm-4 social-buttons">
                                        @if($idrol == 1000)                              
                                              <li class="dropdown small-box bg-blue-gradient ">
                                                  <div class="inner">
                                                      <h4>CAMBIO DE PLANTA</h4>
                                                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: white;"> SELECCIONE UNA PLANTA<span class="caret"></span>
                                                      </a>
                                                      <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                        <li>
                                                            <!-- <span class="item">
                                                              <span class="item-left"> -->
                                                                   @foreach ($menuPlantasInsumos->menuPlantasInsumos() as $menuPl)
                                                                      <li style="border-bottom: solid 1px #000;"><a href="/CambioPlantasAdministrador/{{$menuPl->id_planta}}/2" class="cambioPlantasLacteos"><img src="/img/icono_plantas.png" width="25" height="25" alt="">&nbsp;&nbsp;<span style="color: white">{{ $menuPl->nombre_planta }}</span></a></li>
                                                                   @endforeach                                                 
                                                              <!-- </span>
                                                          </span> -->
                                                        </li>
                                                      </ul>
                                                  </div>
                                                  <div class="icon efectoicon">
                                                      <img src="img/botones/almacenes_cambio_lacteos.png" alt="" width="80">
                                                  </div>
                                              </li>
                                          @endif
                                          @if($idrol == 1)   
                                              <li class="dropdown small-box bg-blue-gradient">
                                                <div class="inner">
                                                  <h4>CAMBIO DE PLANTA</h4>
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: white;"> SELECCIONE UNA PLANTA<span class="caret"></span>
                                                    </a>
                                                    <!--<ul class="dropdown-menu">-->
                                                    <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                      <li class="dropdown-submenu">
                                                        <a class="test cambioPlantasLacteos" tabindex="-1" href="#" style="color:white">LACTEOS<span class="caret"></span></a>
                                                        <!--<ul class="dropdown-menu">-->
                                                        <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                          <!--<li style="border-bottom: solid 1px #000;"><a tabindex="-1" href="#"><img src="/img/icono_plantas.png" width="25" height="25" alt="">Achacachi</a></li>
                                                          <li style="border-bottom: solid 1px #000;"><a tabindex="-1" href="#"><img src="/img/icono_plantas.png" width="25" height="25" alt="">San lorenzo</a></li>-->
                                                          @foreach ($menuPlantasInsumos->menuPlantasLacteos() as $menuPl)
                                                              <li style="border-bottom: solid 1px #000;"><a href="/CambioPlantasAdministrador/{{$menuPl->id_planta}}/2" class="cambioPlantasLacteos"><img src="/img/icono_plantas.png" width="25" height="25" alt="">&nbsp;&nbsp;<span style="color: white">{{ $menuPl->nombre_planta }}</span></a></li>
                                                          @endforeach                                                
                                                        </ul>
                                                      </li>
                                                      <li class="dropdown-submenu">
                                                        <a class="test cambioPlantasLacteos" tabindex="-1" href="#" style="color:white">ALMENDRA <span class="caret"></span></a>
                                                        <!--<ul class="dropdown-menu">-->
                                                        <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                          <!--<li style="border-bottom: solid 1px #000;"><a tabindex="-1" href="#"><img src="/img/icono_plantas.png" width="25" height="25" alt="">El Sena</a></li>
                                                          <li style="border-bottom: solid 1px #000;"><a tabindex="-1" href="#"><img src="/img/icono_plantas.png" width="25" height="25" alt="">Riberalta</a></li>-->
                                                          @foreach ($menuPlantasInsumos->menuPlantasAlmendra() as $menuPl)
                                                              <li style="border-bottom: solid 1px #000;"><a href="/CambioPlantasAdministrador/{{$menuPl->id_planta}}/1" class="cambioPlantasLacteos"><img src="/img/icono_plantas.png" width="25" height="25" alt="">&nbsp;&nbsp;<span style="color: white">{{ $menuPl->nombre_planta }}</span></a></li>
                                                          @endforeach                                               
                                                        </ul>
                                                      </li>
                                                      <li class="dropdown-submenu">
                                                        <a class="test cambioPlantasLacteos" tabindex="-1" href="#" style="color:white">MIEL <span class="caret"></span></a>
                                                        <!--<ul class="dropdown-menu">-->
                                                        <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                          @foreach ($menuPlantasInsumos->menuPlantasMiel() as $menuPl)
                                                              <li style="border-bottom: solid 1px #000;"><a href="/CambioPlantasAdministrador/{{$menuPl->id_planta}}/3" class="cambioPlantasLacteos"><img src="/img/icono_plantas.png" width="25" height="25" alt="">&nbsp;&nbsp;<span style="color: white">{{ $menuPl->nombre_planta }}</span></a></li>
                                                          @endforeach                                                  
                                                        </ul>
                                                      </li>
                                                      <li class="dropdown-submenu">
                                                        <a class="test cambioPlantasLacteos" tabindex="-1" href="#" style="color:white">FRUTOS <span class="caret"></span></a>
                                                        <!--<ul class="dropdown-menu">-->
                                                        <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #39b6ff">
                                                          @foreach ($menuPlantasInsumos->menuPlantasFrutos() as $menuPl)
                                                              <li style="border-bottom: solid 1px #000;"><a href="/CambioPlantasAdministrador/{{$menuPl->id_planta}}/4" class="cambioPlantasLacteos"><img src="/img/icono_plantas.png" width="25" height="25" alt="">&nbsp;&nbsp;<span style="color: white">{{ $menuPl->nombre_planta }}</span></a></li>
                                                          @endforeach                                   
                                                        </ul>
                                                      </li>
                                                    </ul>
                                                  <!--</div>-->
                                                </div>
                                                <div class="icon efectoicon">
                                                    <img src="img/botones/almacenes_cambio_lacteos.png" alt="" width="80">
                                                </div>
                                              
                                              </li>                                
                                          @endif
                                         @if($idrol==1 or $idrol==20)
                                            <a href="{{ url('ProveedorInsumo') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>PROVEEDORES</h4>
                                                      <p>REGISTRO DE PROVEEDORES</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/proveedores_lacteos.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                        @endif                                    
                                         
                                            
                                         <!-- @if($idrol==1 or $idrol==20)
                                            <a href="{{url('ServicioInsumo')}}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>SERVICIOS</h4>
                                                      <p>REGISTRO DE SERVICIOS</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/servicios.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                        @endif --> 
                                        
                                         @if($idrol==1 or $idrol==20)
                                            <a href="{{url('Insumo') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>INSUMOS/ENVASES</h4>
                                                      <p>REGISTRO DE INSUMOS</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/insumos.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                        @endif 
                                            
                                            @if($idrol==1 or $idrol==19)
                                            <!--<a href="{{url('IngresoAlmacen') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>INGRESO ALMACEN</h4>
                                                      <p>INGRESO INSUMOS ALMACEN</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/ingreso almacen.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>-->
                                            @endif 
                                            
                                            @if($idrol==1 or $idrol==19)
                                            <!--<a href="{{url('IngresoPrima') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>INGRESO MATERIA PRIMA</h4>
                                                      <p>INGRESO ALMACEN</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/ingreso materia prima.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>-->
                                            @endif 
                                            @if($idrol==1 or $idrol==20)
                                            <a href="{{ url('UfvInsumo') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>UFV</h4>
                                                      <p>REGISTRO DE UFV</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/ufv.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                            @endif
                                            @if($idrol==1 or $idrol==20)
                                            <a href="{{url('DatosInsumo') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>DATOS GENERALES</h4>
                                                      <p>REGISTRO DE DATOS</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/datos.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                            @endif  
                                            
                                         <!-- @if($idrol==1 or $idrol==20)
                                            <a href="{{url('DatosInsumo') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>DATOS</h4>
                                                      <p>REGISTRO DE DATOS</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/datos.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                        @endif  -->
                                        
                                    </div>
                                    <div class="col-sm-8">
                                      <div class="row">
                                        <div class="col-sm-12">
                                            <img src="{{ asset('img/registros.jpg') }}" width="100%" height="100%" alt="Imagen Registro de Insumos" class="img-responsive">
                                        </div>
                                      </div> 
                                      <br><br>                                       
                                      <div class="row">
                                        <div class="col-sm-6">
                                          @if($idrol==1 or $idrol==20)
                                            <!--<a href="{{url('ServicioInsumo')}}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>SERVICIOS</h4>
                                                      <p>REGISTRO DE SERVICIOS</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/servicios.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>-->
                                        @endif 
                                        </div>
                                        <div class="col-sm-6">
                                          @if($idrol==1 or $idrol==20)
                                            <!--<a href="{{url('DatosInsumo') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>DATOS</h4>
                                                      <p>REGISTRO DE DATOS</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/datos.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>-->
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
  @push('scripts')
  <script>
$(document).ready(function(){
  $('.dropdown-submenu a.test').on("click", function(e){
    $(this).next('ul').toggle();
    e.stopPropagation();
    e.preventDefault();
  });
});
</script>



@endpush
