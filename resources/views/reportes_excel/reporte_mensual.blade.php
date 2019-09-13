@php
$user = DB::table('public._bp_usuarios')->join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('_bp_usuarios.usr_id',Auth::user()->usr_id)->first();

@endphp

<html>
<table>
      <td align="center" colspan="2"><img src="img/logopeqe.png" width="80" /></td>
      <td colspan="10" style="text-align:center; vertical-align: middle;"><h2>EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS</h2></td>
</table>
<table>
    <tr>
      <td colspan="12" style="text-align:center;"><strong><h6>REPORTE MENSUAL</h6></strong></td>
    </tr>    
    <tr>
      <td colspan="2" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>PLANTA:</strong></h6></td>
      <td colspan="6"><h6>{{$planta->nombre_planta}}</h6></td>
      <td colspan="2" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>FECHA EMISIÓN:</strong></h6></td>
      <td colspan="2"><h6>{{date('d/m/Y')}}</h6></td>
   </tr>
</table>
<table border="1">
  <thead class="table_head"> 
   <tr>
      <td width="5" rowspan="2" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>N°</strong></h6></td>
      <td rowspan="2" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Código</strong></h6></td>
      <td width="30" rowspan="2" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Detalle Articulo</strong></h6></td> 
      <td rowspan="2" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Precio U.</strong></h6></td>
      <td rowspan="2" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Total</strong></h6></td>
      <td rowspan="2" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Unidad</strong></h6></td>
      <td colspan="3" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Cantidad</strong></h6></td>
      <td colspan="3" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Costo</strong></h6></td>   
   </tr>
   <tr>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><strong></strong></td>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><strong></strong></td>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><strong></strong></td> 
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><strong></strong></td>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><strong></strong></td>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><strong></strong></td>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Entrada</strong></h6></td>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Salida</strong></h6></td>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Saldo</strong></h6></td> 
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Entrada</strong></h6></td>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Salida</strong></h6></td>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Saldo</strong></h6></td>     
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
  
    //dd($insumo_ingreso);
    @foreach($insumo_ingreso as $key => $ig) {
      <?php 
        $nro = $nro + 1;
        $salidas = traeSalidas($ig->deting_ins_id,$planta->id_planta);
        $saldo_cantidad = $ig->deting_cantidad - $salidas;
        $costo_entrada = $ig->deting_cantidad * $ig->deting_costo;
        $costo_salida = $ig->deting_costo * $salidas;
        $saldo_costos = $costo_entrada - $costo_salida;

        $totaCost = $totaCost + $costo_entrada;
        $totaSalida = $totaSalida +$costo_salida;
        $totaSaldo = $totaSaldo + $saldo_costos;
      ?>
      <tr>      
        <td align="center"><h6>{{$nro}}</h6></td>
        <td align="center"><h6>{{traeCodigo($ig->deting_ins_id)}}</h6></td>
        <td align="center"><h6>{{traeDetalle($ig->deting_ins_id)}}</h6></td> 
        <td align="center"><h6>{{$ig->deting_costo}}</h6></td>
        <td align="center"><h6>{{$ig->deting_cantidad}}</h6></td>
        <td align="center"><h6>{{traeUnidad($ig->deting_ins_id)}}</h6></td>
        <td align="center"><h6>{{number_format($ig->deting_cantidad,2,'.',',')}}</h6></td>
        <td align="center"><h6>{{number_format($salidas,2,'.',',')}}</h6></td>
        <td align="center"><h6>{{number_format($saldo_cantidad,2,'.',',')}}</h6></td> 
        <td align="center"><h6>{{number_format($costo_entrada,2,'.',',')}}</h6></td>
        <td align="center"><h6>{{number_format($costo_salida,2,'.',',')}}</h6></td>
        <td align="center"><h6>{{number_format($saldo_costos,2,'.',',')}}</h6></td>
      </tr> 
    @endforeach
    <tr>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;" colspan="9"><h6><strong>TOTALES</strong></h6></td>
      <td align="center"><h6><strong>{{number_format($totaCost, 2, '.', ',')}}</strong></h6></td>
      <td align="center"><h6><strong>{{number_format($totaSalida, 2, '.', ',')}}</strong></h6></td>
      <td align="center"><h6><strong>{{number_format($totaSaldo, 2, '.', ',')}}</strong></h6></td>
    </tr>
  </tbody>
</table>
</html>
<?php
  function traeCodigo($id_insumo) {
    $insumo = siga\Modelo\insumo\insumo_registros\Insumo::where('ins_id', $id_insumo)->first();
    return $insumo->ins_codigo;
  }
  function traeDetalle($id_insumo) {
    $insumo = siga\Modelo\insumo\insumo_registros\Insumo::where('ins_id', $id_insumo)
              ->leftjoin('insumo.sabor as sab','insumo.insumo.ins_id_sabor','=','sab.sab_id')->first();
              //dd($insumo);
    return $insumo->ins_desc.' '.$insumo->sab_nombre.' '.$insumo->ins_peso_presen;
  }
  function traeUnidad($id_insumo) {
    $insumo = siga\Modelo\insumo\insumo_registros\Insumo::join('insumo.unidad_medida as umed', 'insumo.insumo.ins_id_uni', '=', 'umed.umed_id')
      ->where('ins_id', $id_insumo)->first();
    return $insumo->umed_nombre;
  }
  function traeSalidas($id_insumo,$id_planta)
  {
    //dd("INS ID: ".$id_insumo.", ID DETING: ".$id_deting);
    $insumo = siga\Modelo\insumo\InsumoHistorial::select(DB::raw('SUM(inshis_cantidad) as cantidad'))->where('inshis_ins_id',$id_insumo)->where('inshis_detorprod_id','<>',null)->where('inshis_planta_id',$id_planta)->first();
    //dd($insumo);
    if ($insumo->cantidad) {
      return $insumo->cantidad;
    }else{
      return 0.00;
    }
  }
 ?>