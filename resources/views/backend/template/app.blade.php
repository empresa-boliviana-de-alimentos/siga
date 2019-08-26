<!DOCTYPE html>
<html lang="es">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('backend.template.partials.htmlheader')
    <body>
        @include('backend.template.partials.mainheader')
        @include('backend.template.partials.sidebar')

        <div id="app">
            <section id="main-content">
                <section class="wrapper">
                    @yield('main-content')
                </section>
            </section>
        </div>
        @section('scripts')
            @include('backend.template.partials.scripts')
        @show
    </body>
</html>
