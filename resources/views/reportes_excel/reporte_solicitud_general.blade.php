@php
$user = DB::table('public._bp_usuarios')->join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('_bp_usuarios.usr_id',Auth::user()->usr_id)->first();
@endphp
<html>
<table>
      <td align="center" colspan="2"><img src="img/logopeqe.png" width="80" /></td>
      <td colspan="5" style="text-align:center; vertical-align: middle;"><h2>EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS</h2></td>
</table>
<table>
    <tr>
      <td colspan="7" style="text-align:center;"><strong><h6>REPORTE SOLICITUD GENERAL</h6></strong></td>
    </tr>    
    <tr>
      <td colspan="2" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>PLANTA:</strong></h6></td>
      <td colspan="3"><h6>{{$planta->nombre_planta}}</h6></td>
      <td colspan="1" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>FECHA EMISIÓN:</strong></h6></td>
      <td colspan="1"><h6>{{date('d/m/Y')}}</h6></td>
   </tr>
</table>
<table border="1">
  <thead class="table_head">    
   <tr>
      <td width="5" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Nro.</strong></h6></td>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Número</strong></h6></td>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Código</strong></h6></td> 
      <td width="30" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Detalle Articulo</strong></h6></td>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Cantidad</strong></h6></td>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Fecha Solicitud</strong></h6></td>
      <td width="20" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Tipo Solicitud</strong></h6></td>  
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
    @foreach($detorprod as $key => $ig) {
      <?php 
        $nro = $nro + 1;
      ?>
      <tr>      
        <td align="center"><h6>{{$nro}}</h6></td>
        <td align="center"><h6>{{$ig->orprod_nro_orden}}</h6></td>
        <td align="center"><h6>{{traeCodigo($ig->detorprod_ins_id)}}</h6></td>
        <td align="center"><h6>{{traeDetalle($ig->detorprod_ins_id)}}</h6></td> 
        <td align="center"><h6>{{$ig->detorprod_cantidad}}</h6></td>
        <td align="center"><h6>{{date('d/m/Y',strtotime($ig->detorprod_registrado))}}</h6></td>
        <td align="center"><h6>{{traeTipoOrprod($ig->orprod_tiporprod_id)}}</h6></td>
      </tr> 
    @endforeach
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
  function traeTipoOrprod($id)
  {
    $tipo = \DB::table('insumo.tipo_orden_produccion')->where('tiporprod_id',$id)->first();
    return $tipo->tiporprod_nombre;
  }
 ?>