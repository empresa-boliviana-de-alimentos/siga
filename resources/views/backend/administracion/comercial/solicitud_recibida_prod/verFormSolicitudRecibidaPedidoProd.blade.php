@extends('backend.template.app')
<style type="text/css" media="screen">
  .table-condensed>thead>tr>th, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>tbody>tr>td, .table-condensed>tfoot>tr>td{
    padding: 1px;
}
table.dataTable tbody th, table.dataTable tbody td {
    padding: 8px 10px;
    color: dimgrey;
    font-size: 8px;
}
table {
  border-collapse: separate;
  border-spacing: 0 5px;
}

th {
  background-color:#2067b4;
  color: white;
}
tbody td {
  background-color: #EEEEEE;
}

</style>
@section('main-content')
<div class="row">
    <div class="col-md-12">
        <div class="container col-lg-12" style="background: white;">
            <?php $now = new DateTime('America/La_Paz');?>
            <div class="text-center">
                <h3 style="color:#2067b4"><strong>VER ORDEN DE PEDIDO</strong></h3>
            </div>
            <form action="{{url('RegistrarAprobSolicitudPedidoProd')}}" class="form-horizontal" method="POST">
                {{ csrf_field() }}  
                <input id="fecha_resgistro" name="fecha_resgistro" type="hidden" value="<?php echo $now->format('d-m-Y H:i:s'); ?>">
                <input type="hidden" name="solprod_id" id="solprod_id" value="{{$solprod->solprod_id}}">                    
                <div class="col-md-12">
                    <div class="col-md-4">
                        <label>
                            Solicitante:
                        </label>
                        <input type="" name="" class="form-control" value="{{$solprod->prs_nombres.' '.$solprod->prs_paterno.' '.$solprod->prs_materno}}" readonly>
                    </div>
                    <div class="col-md-2">
                        <label>
                            Nro Solicitud:
                        </label>
                        <input type="text" name="" class="form-control" value="{{$solprod->solprod_nro_solicitud}}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label>
                            Fecha Solicitud:
                        </label>
                        <input type="text" name="" class="form-control" value="{{date('d-m-Y',strtotime($solprod->solprod_registrado))}}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label>
                            Fecha Posible Entrega:
                        </label>
                        <input type="text" name="" class="form-control" value="{{date('d-m-Y',strtotime($solprod->solprod_fecha_posent))}}" readonly>
                    </div>
                </div>
                              
                <div class="col-md-12 text-center">
                    <h4><strong>DETALLE PEDIDO</strong></h4>
                </div>
                <div class="col-md-12">
                    <table class="table">
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">COD PRODUCTO</th>
                            <th class="text-center">PRODUCTO</th>
                            <th class="text-center">UNIDAD MEDIDA</th>
                            <th class="text-center">CANTIDAD</th>
                            <th class="text-center">CANT. TONELADA</th>
                        </tr>
                        <?php 
                            $nro = 0; 
                            $total_tonelada = 0;
                        ?>
                        @foreach($detsolprod as $det)
                        <?php 
                            $nro = $nro + 1; 
                            $total_tonelada = $total_tonelada + $det->detsolprod_tonelada;
                        ?>
                        <tr>
                            <td class="text-center">{{$nro}}</td>
                            <td class="text-center">{{$det->prod_codigo}}</td>
                            <td class="text-center">
                            @if($det->sab_id == 1)
                                {{$det->rece_nombre.' '.$det->rece_presentacion}}
                            @else
                                {{$det->rece_nombre.' '.$det->sab_nombre.' '.$det->rece_presentacion}}
                            @endif
                            </td>
                            <td class="text-center">{{$det->umed_nombre}}</td>
                            <td class="text-center">{{$det->detsolprod_cantidad}}</td>
                            <td class="text-center">{{$det->detsolprod_tonelada}}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td class="text-center" colspan="5" style="background-color:#2067b4; color: white;"><strong>TOTAL TONELADAS APROX.</strong></td>
                            <td class="text-center">{{number_format($total_tonelada,2,'.',',')}}</td>
                        </tr>
                    </table>
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
                            <a class="btn btn-danger btn-lg" href="{{ url('SolRecibidasProdComercial') }}" type="button">
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
