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
                                    <i class="livicon" data-name="check" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> INGRESOS
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                          
                                    <div class="col-sm-4 social-buttons">

                                            
                                            
                                            <a href="{{url('IngresoAlmacen') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>INGRESO ALMACEN</h4>
                                                      <p>INGRESO INSUMOS ALMACEN</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/ingreso almacen.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>
                                           
                                            <a href="{{url('IngresoPrima') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>INGRESO MATERIA PRIMA</h4>
                                                      <p>INGRESO ALMACEN</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/ingreso materia prima.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>    
                                            
                                            <a href="{{url('IngresoTraspaso') }}">
                                                <div class="small-box bg-blue-gradient efectoboton">
                                                    <div class="inner">
                                                      <h4>INGRESO INSUMO</h4>
                                                      <p>POR TRASPASOS</p>
                                                    </div>
                                                    <div class="icon efectoicon">
                                                      <img src="img/botones/ingreso materia prima.png" alt="" width="80">
                                                    </div>
                                                </div>
                                            </a>    
                                        
                                    </div>
                                    <div class="col-sm-8">
                                      <div class="row">
                                        <div class="col-sm-12">
                                            <img src="{{ asset('img/registros.jpg') }}" width="100%" height="100%" alt="Imagen Registro de Insumos" class="img-responsive">
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
