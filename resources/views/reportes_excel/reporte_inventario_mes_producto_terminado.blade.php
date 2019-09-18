@php
$user = DB::table('public._bp_usuarios')->join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('_bp_usuarios.usr_id',Auth::user()->usr_id)->first();
@endphp
<html>
<table>
      <td align="center" colspan="2"><img src="img/logopeqe.png" width="80" /></td>
      <td colspan="4" style="text-align:center; vertical-align: middle;"><h2>EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS</h2></td>
</table>
<table>
    <tr>
      <td colspan="6" style="text-align:center;"><strong><h6>REPORTE INVENTARIO ALMACEN</h6></strong></td>
    </tr>    
    <tr>
      <td colspan="2" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>PLANTA:</strong></h6></td>
      <td colspan="2"><h6>{{$planta->nombre_planta}}</h6></td>
      <td colspan="1" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>FECHA EMISIÓN:</strong></h6></td>
      <td colspan="1"><h6>{{date('d/m/Y')}}</h6></td>
   </tr>
   <tr>
      <td colspan="3" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>FECHA INVENTARIO:</strong></h6></td>
      <td colspan="3"><h6>{{$fecha_inventario}}</h6></td>
   </tr>

</table>
<table border="1">
  <thead class="table_head">    
   <tr>
      <td width="5" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Nro.</strong></h6></td>
      <td width="15" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Código</strong></h6></td>
      <td width="20" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Producto</strong></h6></td> 
      <td width="20" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Cantidad</strong></h6></td>
      <td width="20" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Fecha Vencimiento</strong></h6></td>
      <td width="20" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Fecha Registro</strong></h6></td>  
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
    @foreach($stockptMes as $key => $ig) {
      <?php 
        $nro = $nro + 1;
      ?>
      <tr>      
        <td align="center"><h6>{{$nro}}</h6></td>
        <td align="center"><h6>{{$ig->rece_codigo}}</h6></td>
        <td align="center"><h6>
        @if($ig->sab_id == 1)  
          {{$ig->rece_nombre.' '.$ig->rece_presentacion}}
        @else
          {{$ig->rece_nombre.' '.$ig->sab_nombre.' '.$ig->rece_presentacion}}
        @endif
        </h6></td>
        <td align="center"><h6>{{$ig->spth_cantidad}}</h6></td>
        <td align="center"><h6>{{date('d/m/Y',strtotime($ig->spth_fecha_vencimiento))}}</h6></td>
        <td align="center"><h6>{{date('d/m/Y',strtotime($ig->spth_registrado))}}</h6></td>
      </tr> 
    @endforeach
  </tbody>
</table>
</html>