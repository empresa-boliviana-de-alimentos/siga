 @inject('menuPlantas','siga\Http\Controllers\MenuController')
 <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Ocultar/Abrir menu lateral" style="color:#FFFFFF; width:6; height:6;"></div>
              </div>
            <!--logo start-->
            <a href="{{url('/home')}}" class="logo"><img src="../img/siga_logo.png" alt="" width="50px"></a>
            <!--logo end-->
            <!--UFV-->
            <a href="#" class="logo ufv"><i class="fa fa-gg-circle" aria-hidden="true"></i> <strong>UFV: {{ Auth::user()->getUfv() }}</strong></a>
            <!--END UFV-->
            <div class="top-menu">
                <ul class="nav navbar-nav navbar-right top-menu">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <span class="glyphicon glyphicon-user"></span>{{ Auth::user()->usr_usuario}}<span class="caret"></span></a>
                <ul class="dropdown-menu dropdown-cart" role="menu">
              <li>
                <div class="text-center">
                  <span class="text-center">
                    
                        <!-- <img src="../img/demo/avatar.png" alt="" class="text-center" /> -->
                        <img src="/img/demo/avatar.png" alt="" style="height: 10vw; width: 10vw; border: 2px solid #fff;border-radius: 50%;box-shadow: 0 0 5px gray;display: inline-block;margin-left: auto;margin-right: auto;"/><br>
                        <span class="item-info">
                            <span>{{ Session::get('NOMBRES') }} {{ Session::get('PATERNO') }} {{ Session::get('MATERNO') }}</span><br>
                            <!-- <span>{{ Session::get('ROL') }}</span> -->
                            <span>Planta: {{ Session::get('PLANTA') }}</span><br>
                            <span>Rol usuario: {{ Session::get('ROLUSUARIO') }}</span>
                        </span>
                    
                </span>
               </div>
              </li>
              <li class="divider"></li>
              <li><a href="{{ route('cerrar') }}" class="btn btn-default btn-flat">Salir del Sistema</a></li>
          </ul>
        </li>
      </ul>
    </div>
    @php
      $idrol=Session::get('ID_ROL');
    @endphp
    @if($idrol==8 or $idrol==9 or $idrol==22 or $idrol==29)
    <div class="top-menu">
                <ul class="nav navbar-nav navbar-right top-menu">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <img src="/img/icono_plantas.png" width="25" height="25" alt=""> CAMBIO DE PLANTA<span class="caret"></span></a>
                <ul class="dropdown-menu dropdown-cart" role="menu" style="background: #0092ff">
              <li>
                  <!-- <span class="item">
                    <span class="item-left"> -->
                         @foreach ($menuPlantas->menuPlantas() as $menuPl)
                            <li style="border-bottom: solid 1px #000;"><a href="/CambioPlantas/{{$menuPl->id_planta}}" class="cambioPlantasAdminLinea"><img src="/img/icono_plantas.png" width="25" height="25" alt="">&nbsp;&nbsp;<span style="color: white"> {{ $menuPl->nombre_planta }}</span></a></li>
                         @endforeach  
                        
                   <!--  </span>
                </span> -->
              </li>
          </ul>
        </li>
      </ul>
    </div> 
    @endif
    @if($idrol==200)
    <div class="top-menu">
                <ul class="nav navbar-nav navbar-right top-menu">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <span class="glyphicon glyphicon-home"></span> PLANTAS FRUTOS<span class="caret"></span></a>
                <ul class="dropdown-menu dropdown-cart" role="menu">
              <li>
                  <span class="item">
                    <span class="item-left">
                         @foreach ($menuPlantas->menuPlantasFrutos() as $menuPl)
                            <li><a href="/CambioPlantas/{{$menuPl->id_planta}}"><span class="glyphicon glyphicon-home"></span> {{ $menuPl->nombre_planta }}</a></li>
                         @endforeach  
                        
                    </span>
                </span>
              </li>
          </ul>
        </li>
      </ul>
    </div>
    <div class="top-menu">
                <ul class="nav navbar-nav navbar-right top-menu">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <span class="glyphicon glyphicon-home"></span> PLANTAS MIEL<span class="caret"></span></a>
                <ul class="dropdown-menu dropdown-cart" role="menu">
              <li>
                  <span class="item">
                    <span class="item-left">
                         @foreach ($menuPlantas->menuPlantasMiel() as $menuPl)
                            <li><a href="/CambioPlantas/{{$menuPl->id_planta}}"><span class="glyphicon glyphicon-home"></span> {{ $menuPl->nombre_planta }}</a></li>
                         @endforeach  
                        
                    </span>
                </span>
              </li>
          </ul>
        </li>
      </ul>
    </div> 
    <div class="top-menu">
                <ul class="nav navbar-nav navbar-right top-menu">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <span class="glyphicon glyphicon-home"></span> PLANTAS LACTEOS<span class="caret"></span></a>
                <ul class="dropdown-menu dropdown-cart" role="menu">
              <li>
                  <span class="item">
                    <span class="item-left">
                         @foreach ($menuPlantas->menuPlantasLacteos() as $menuPl)
                            <li><a href="/CambioPlantas/{{$menuPl->id_planta}}"><span class="glyphicon glyphicon-home"></span> {{ $menuPl->nombre_planta }}</a></li>
                         @endforeach  
                        
                    </span>
                </span>
              </li>
          </ul>
        </li>
      </ul>
    </div>
    <div class="top-menu">
                <ul class="nav navbar-nav navbar-right top-menu">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <span class="glyphicon glyphicon-home"></span> PLANTAS ALMENDRA<span class="caret"></span></a>
                <ul class="dropdown-menu dropdown-cart" role="menu">
              <li>
                  <span class="item">
                    <span class="item-left">
                         @foreach ($menuPlantas->menuPlantasAlmendra() as $menuPl)
                            <li><a href="/CambioPlantas/{{$menuPl->id_planta}}"><span class="glyphicon glyphicon-home"></span> {{ $menuPl->nombre_planta }}</a></li>
                         @endforeach  
                        
                    </span>
                </span>
              </li>
          </ul>
        </li>
      </ul>
    </div>   
    @endif   
</header>
<style type="text/css">
.ufv {
  width: 200px;
  transform: translateX(-50%);
  left: 50%;
  position: absolute;
}

</style>