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
        Canastillo
      </td>
      <td class="px-15 py text-center  text-xxs">
        Nro. Ingreso
      </td>
      <td class="px-15 py text-center text-xxs">
        Cantidad
      </td>
      <td class="px-15 py text-center text-xxs">
        Origen
      </td>
      <td class="px-15 py text-center text-xxs ">
        Producto
      </td>
      <td class="px-15 py text-center  text-xxs">
        Fecha Ingreso
      </td>
      <td class="px-15 py text-center text-xxs">
        Conductor
      </td>
      <td class="px-15 py text-center text-xxs">
        Imagen
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
    @foreach($ingresoCanastillos as $key => $ig)
      <?php 
        $nro = $nro + 1;
      ?>
      <tr>      
        <td class="px-15 py text-center text-xxs">{{$nro}}</td>
        <td class="px-15 py text-center text-xxs">
          {{$ig->ctl_descripcion}}
        </td>
        <td class="px-15 py text-center text-xxs">{{$ig->iac_nro_ingreso}}</td>
        <td class="px-15 py text-center text-xxs">{{$ig->iac_cantidad}}</td> 
        <td class="px-15 py text-center text-xxs">{{$ig->nombre_planta}}</td>
        <td class="px-15 py text-center text-xxs">{{$ig->producto}}</td>
        <td class="px-15 py text-center text-xxs">{{date('d/m/Y',strtotime($ig->iac_fecha_ingreso))}}</td>
        <td class="px-15 py text-center text-xxs">{{$ig->conductor}}</td>
        <td class="px-15 py text-center text-xxs"><img src="{{ public_path('archivo/canastillo/'.$ig->ctl_foto_canastillo) }}" style=" width: 108px;"></td>
      </tr> 
    @endforeach
  </tbody>
</table>
@endsection
