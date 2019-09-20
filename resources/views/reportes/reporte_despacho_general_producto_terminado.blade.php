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
        Producto
      </td>
      <td class="px-15 py text-center  text-xxs">
        Cod. Orp
      </td>
      <td class="px-15 py text-center text-xxs">
        Cod. Salida
      </td>
      <td class="px-15 py text-center text-xxs">
        Cantidad
      </td>
      <td class="px-15 py text-center text-xxs ">
        Origen
      </td>
      <td class="px-15 py text-center  text-xxs">
        Destino
      </td>
      <td class="px-15 py text-center text-xxs">
        Linea
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
    @foreach($despachoORP as $key => $ig)
      <?php 
        $nro = $nro + 1;
      ?>
      <tr>      
        <td class="px-15 py text-center text-xxs">{{$nro}}</td>
        <td class="px-15 py text-center text-xxs">
          {{$ig->rece_nombre}}
        </td>
        <td class="px-15 py text-center text-xxs">{{$ig->rece_codigo}}</td>
        <td class="px-15 py text-center text-xxs">{{$ig->dao_codigo_salida}}</td> 
        <td class="px-15 py text-center text-xxs">{{$ig->dao_cantidad}}</td>
        <td class="px-15 py text-center text-xxs">{{$ig->origen}}</td>
        <td class="px-15 py text-center text-xxs">{{$ig->destino}}</td>
        <td class="px-15 py text-center text-xxs">{{linea($ig->rece_lineaprod_id)}}</td>
      </tr> 
    @endforeach
  </tbody>
</table>
<?php 
  function linea($id){
    if ($id == 1) {
      return "LACTEOS";
    }elseif($id == 2){
      return "ALMENDRA";
    }elseif($id == 3){
      return "MIEL";
    }elseif($id == 4){
      return "FRUTOS";
    }elseif($id == 5){
      return "DERIVADOS";
    }
  }
 ?>
@endsection
