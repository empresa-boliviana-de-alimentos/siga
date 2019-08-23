<!DOCTYPE html>
<html lang="es">
    @include('backend.template.partials.htmlheader')
    <body>
        @include('backend.template.partials.mainheader')
        @include('backend.template.partials.sidebar')
        <section id="main-content">            
            <section class="wrapper">
                @yield('main-content')
            </section>
        </section>
        @section('scripts')
            @include('backend.template.partials.scripts')
        @show
    </body>
</html>