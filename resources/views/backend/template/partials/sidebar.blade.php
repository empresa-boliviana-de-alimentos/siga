@inject('menu','siga\Http\Controllers\MenuController')
<style type="text/css">
    #sidebar {
    height: 100%;
    overflow-y: scroll;
}
</style>
<aside>
    <div class="nav-collapse " id="sidebar">
        <ul class="sidebar-menu" id="nav-accordion">
            <p class="centered">
                <a href="{{url('/home')}}">
                    <img class="img-rounded" src="/img/LogoEBA2019.png" width="150"/>
                </a>
            </p>
            <h5 class="centered">
                SISTEMA GESTION DE ALMACENES - EBA<br>
                PLANTA: {{ Session::get('PLANTA') }} <br>
                {{ Auth::User()->usr_usuario }}
            </h5>
             @foreach ($menu->submenus() as $link01)
                @php
                    $grupo01=0;
                    $grupo01= $link01->grp_id;
                @endphp
            <li class="sub-menu">
                <a href="#">
                    <i class="{{$link01->grp_imagen}}" aria-hidden="true"></i>
                    <span>
                        {{ $link01->grp_grupo }}
                    </span>
                </a>
                <ul class="sub">
                    @foreach ($menu->links($grupo01) as $link02) 
                    <li>
                        <a href="{{ url($link02->opc_contenido) }}">
                            <i class="fa fa-arrow-right"></i>{{ $link02->opc_opcion }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </li>
            @endforeach   
        </ul>
    </div>
</aside>
@push('scripts')
<script>
</script>
@endpush