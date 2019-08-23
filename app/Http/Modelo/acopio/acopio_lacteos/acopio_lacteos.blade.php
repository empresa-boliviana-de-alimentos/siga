@extends('admin.app')
@section('main-content')
<div class="row">
	<div class="paddingleft_right15">
                    <div class="row">
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="livicon" data-name="check" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> ACOPIO LACTEOS
                                </h3>
                                <span class="pull-right clickable">
                                    <i class="glyphicon glyphicon-chevron-up"></i>
                                </span>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <!--start-->
                                    <div class="col-sm-4 social-buttons">
                                        <h3>MENU</h3>
                                            <a href="{{ url('ProveedorL') }}" class="list-group-item visitor">
                                                <p class="pull-right">
                                                    <i class="fa fa-users f"></i>
                                                </p>
                                                <h4 class="list-group-item-heading count">PROVEEDORES</h4>
                                                <p class="list-group-item-text">________________________</p>
                                            </a>
                                            <br>
                                            <a href="{{ url('AcopioLacteos') }}" class="list-group-item facebook-like">
                                                <p class="pull-right">
                                                    <i class="fa fa-coffee f"></i>
                                                </p>
                                                <h4 class="list-group-item-heading count">ACOPIO CENTROS</h4>
                                                <p class="list-group-item-text">______________</p>
                                            </a>
                                            <br>
                                            <a href="{{ url('AcopioLacteosPlantas') }}" class="list-group-item facebook-like">
                                                <p class="pull-right">
                                                    <i class="fa fa-coffee f"></i>
                                                </p>
                                                <h4 class="list-group-item-heading count">ACOPIO PLANTA</h4>
                                                <p class="list-group-item-text">______________</p>
                                            </a>
                                            <br>
                                            <a href="{{ url('SoliAcopioAlmendra') }}" class="list-group-item google-plus">
                                                <p class="pull-right">
                                                    <i class="fa fa-file f"></i>
                                                </p>
                                                <h4 class="list-group-item-heading count">SOLICITUD</h4>
                                                <p class="list-group-item-text">___________________</p>
                                            </a>
                                            <br>
                                            <a href="{{ url('ReporAcopioAlmendra') }}" class="list-group-item twitter">
                                                <p class="pull-right">
                                                    <i class="fa fa-print f"></i>
                                                </p>
                                                <h4 class="list-group-item-heading count">REPORTES</h4>
                                                <p class="list-group-item-text ">__________________</p>
                                            </a>
                                        
                                    </div>
                                    <div class="col-sm-8">
                                        <img src="{{ asset('img/4.jpg') }}" alt="Imagen Acopio Lacteos" class="img-responsive">    
                                    </div>
                                    
                                </div>
                                <!--end-->
                            </div>
                        </div>
                    </div>
                </div>
</div>
@endsection

