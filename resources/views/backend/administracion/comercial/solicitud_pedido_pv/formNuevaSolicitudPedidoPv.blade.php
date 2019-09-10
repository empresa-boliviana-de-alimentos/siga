@extends('backend.template.app')
@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="container col-lg-12" style="background: white;">
            <?php $now = new DateTime('America/La_Paz');?>
            <div class="text-center">
                <h3 style="color:#2067b4"><strong>SOLICITAR PEDIDO PARA PUNTO DE VENTA</strong></h3>
            </div>
            <form action="{{url('RegistrarSolicitudPedidoPv')}}" class="form-horizontal" method="POST">
                {{ csrf_field() }}   
                <input id="fecha_resgistro" name="fecha_resgistro" type="hidden" value="<?php echo $now->format('d-m-Y H:i:s'); ?>">
                <input type="hidden" name="nro_acopio" id="nro_acopio" value="">                    
                <div class="col-md-12">
                    <div class="col-md-6">
                        <label>
                            Solicitante:
                        </label>
                        <input type="" name="" class="form-control" value="{{$solicitante->prs_nombres}} {{$solicitante->prs_paterno}} {{$solicitante->prs_materno}}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label>
                            Punto de Venta:
                        </label>
                        <input type="text" name="" class="form-control" value="{{$punto_venta->nombre_planta}}" readonly>
                    </div>
                </div>                
                <div class="col-md-12">
                    <h4><strong>DETALLE SOLICITUD</strong></h4>
                </div>
                <div class="col-md-12">
                    <producto-comercialpv :lista="{{$listarProducto}}" nombre="productos" ></producto-comercialpv>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label>
                            Observaciones:
                        </label>
                        <textarea class="form-control" name="observacion"></textarea>
                    </div>
                </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-right">
                            <a class="btn btn-danger btn-lg" href="{{ url('SolPedidoPvComercial') }}" type="button">
                            Cerrar
                            </a>
                            <input type="submit"  value="Registrar" class="btn btn-success btn-lg">
                            </div>
                        </div>
                    </div>

            </form>

        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>

</script>
@endpush
