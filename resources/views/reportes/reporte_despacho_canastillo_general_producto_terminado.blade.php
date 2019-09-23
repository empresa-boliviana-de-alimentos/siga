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
        Nro. Salida
      </td>
      <td class="px-15 py text-center  text-xxs">
        Desacripción
      </td>
      <td class="px-15 py text-center text-xxs">
        Material
      </td>
      <td class="px-15 py text-center text-xxs">
        Fecha Salida
      </td>
      <td class="px-15 py text-center text-xxs ">
        Cantidad
      </td>
      <td class="px-15 py text-center  text-xxs">
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
    @foreach($datosCanastillas as $key => $ig)
      <?php 
        $nro = $nro + 1;
      ?>
      <tr>      
        <td class="px-15 py text-center text-xxs">{{$nro}}</td>
        <td class="px-15 py text-center text-xxs">
          {{$ig->iac_codigo_salida}}
        </td>
        <td class="px-15 py text-center text-xxs">{{$ig->ctl_descripcion}}</td>
        <td class="px-15 py text-center text-xxs">{{$ig->ctl_material}}</td> 
        <td class="px-15 py text-center text-xxs">{{date('d-m-Y',strtotime($ig->iac_fecha_salida))}}</td>
        <td class="px-15 py text-center text-xxs">{{$ig->iac_cantidad}}</td>
        <td class="px-15 py text-center text-xxs">{{$ig->nombre_planta}}</td>
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
