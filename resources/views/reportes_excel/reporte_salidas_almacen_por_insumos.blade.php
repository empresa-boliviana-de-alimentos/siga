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
      <td colspan="6" style="text-align:center;"><strong><h6>SALIDAS ALMACEN</h6></strong></td>
    </tr>  
    <tr>
      <td colspan="6" style="text-align:center;"><strong><h6>PLANTA: {{$planta->nombre_planta}}</h6></strong></td>
    </tr>    
    <tr>
      <td colspan="2" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>FECHA GENERADA:</strong></h6></td>
      <td colspan="4"><h6>{{$fecha_inventario}}</h6></td>
   </tr>
</table>
<table border="1">
  <thead class="table_head">    
   <tr>
      <td width="5" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Nro.</strong></h6></td>
      <td width="8" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Nro. Salida</strong></h6></td>
      <td width="20" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Codigo</strong></h6></td> 
      <td width="25" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Insumo</strong></h6></td>
      <td width="8" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Cantidad</strong></h6></td>
      <td width="20" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Fecha Salida</strong></h6></td> 
   </tr>     
  </thead>
  <tbody>
  <?php 
    $nro = 0;
  ?>
    @foreach($reg as $key => $ig) {
      <?php 
        $nro = $nro + 1;
      ?>
      <tr>      
        <td align="center"><h6>{{$nro}}</h6></td>
        <td align="center"><h6>{{$ig->orprod_nro_salida}}</h6></td>
        <td align="center"><h6>{{$ig->ins_codigo}}</h6></td>
        <td align="center"><h6>{{$ig->ins_desc}}</h6></td> 
        <td align="center"><h6>{{$ig->detorprod_cantidad}}</h6></td>
        <td align="center"><h6>{{$ig->orprod_fecha_vodos}}</h6></td>
      </tr> 
    @endforeach
  </tbody>
</table>
</html>