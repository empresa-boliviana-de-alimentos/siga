@extends('layouts.print')

@section('content')
<table class="table-info align-top no-padding no-margins border">
    <tr>
        <td class="text-center bg-grey-darker text-xs text-white ">Emitido por:</td>
        <td colspan="3" class="text-xs uppercase"> {{$per}}</td>
    </tr>
    <tr>
        <td  class="text-center bg-grey-darker text-xs text-white">Fecha Emisión:</td>
        <td colspan="3" class="text-xs uppercase"> {{date('d/m/Y')}}</td>
    </tr>

</table>
<br>
<table class="table-info w-100">
  <thead class="bg-grey-darker">
    <tr class="font-medium text-white text-sm">
      <td class="px-15 py text-center text-xxs ">
        Nro.
      </td>
      <td class="px-15 py text-center text-xxs">
        Receta
      </td>
      <td class="px-15 py text-center  text-xxs">
        Codigo
      </td>
      <td class="px-15 py text-center text-xxs">
        Nro. Orden
      </td>
      <td class="px-15 py text-center text-xxs">
        lote
      </td>
      <td class="px-15 py text-center text-xxs ">
        Fecha Vencimiento
      </td>
      <td class="px-15 py text-center  text-xxs">
        Fecha Ingreso
      </td>
      <td class="px-15 py text-center text-xxs">
        Cantidad
      </td>
      <td class="px-15 py text-center text-xxs">
        Costo
      </td>
      <td class="px-15 py text-center text-xxs">
        Planta
      </td>     
    </tr>
  </thead>
  <tbody>
  <?php 
      $nro = 0;
      $totalCantidad = 0;
      $totaCost = 0;
      $totaSalida = 0;
      $totaSaldo = 0;
    ?>
    @foreach($ingresoOrp as $key => $ig)
      <?php 
        $nro = $nro + 1;
      ?>
      <tr>      
        <td class="px-15 py text-center text-xxs">{{$nro}}</td>
        <td class="px-15 py text-center text-xxs">
        @if($ig->sab_id == 1)
          {{$ig->rece_nombre.' '.$ig->rece_presentacion}}
        @else
          {{$ig->rece_nombre.' '.$ig->sab_nombre.' '.$ig->rece_presentacion}}
        @endif
        </td>
        <td class="px-15 py text-center text-xxs">{{$ig->rece_codigo}}</td>
        <td class="px-15 py text-center text-xxs">{{$ig->orprod_nro_orden}}</td> 
        <td class="px-15 py text-center text-xxs">{{$ig->ipt_lote}}</td>
        <td class="px-15 py text-center text-xxs">{{$ig->ipt_fecha_vencimiento}}</td>
        <td class="px-15 py text-center text-xxs">{{date('d/m/Y',strtotime($ig->ipt_registrado))}}</td>
        <td class="px-15 py text-center text-xxs">{{$ig->ipt_cantidad}}</td>
        <td class="px-15 py text-center text-xxs">{{$ig->ipt_costo_unitario}}</td>
        <td class="px-15 py text-center text-xxs">{{$ig->nombre_planta}}</td> 
      </tr> 
    @endforeach
  </tbody>
</table>
@endsection
