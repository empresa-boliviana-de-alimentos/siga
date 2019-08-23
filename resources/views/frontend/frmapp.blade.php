<!DOCTYPE html>
<html lang="es">
    @include('frontend.frmheader')
    <body>
    <div id="ms-preload" class="ms-preload">
      <div id="status">
        <div class="spinner">
          <div class="dot1"></div>
          <div class="dot2"></div>
          <div class="dot3"></div>
        </div>
      </div>
    </div>
        @include('frontend.frmsidebar')
        @yield('main-content')
        @section('scripts')
            @include('frontend.frmscripts')
        @show
        @include('frontend.frmfooter')
    </body>
</html>