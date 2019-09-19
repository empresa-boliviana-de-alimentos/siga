@php
$user = DB::table('public._bp_usuarios')->join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('_bp_usuarios.usr_id',Auth::user()->usr_id)->first();
@endphp
<html>
<table>
      <td align="center" colspan="2"><img src="img/logopeqe.png" width="80" /></td>
      <td colspan="6" style="text-align:center; vertical-align: middle;"><h2>EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS</h2></td>
</table>
<table>
    <tr>
      <td colspan="8" style="text-align:center;"><strong><h6>REPORTE INGRESO CANASTILLOS GENERAL</h6></strong></td>
    </tr>    
    <tr>
      <td colspan="2" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>FECHA EMISIÓN:</strong></h6></td>
      <td colspan="6"><h6>{{date('d/m/Y')}}</h6></td>
   </tr>
</table>
<table border="1">
  <thead class="table_head">    
   <tr>
      <td width="5" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Nro.</strong></h6></td>
      <td width="20" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Canastillo</strong></h6></td>
      <td width="20" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Nro. Ingreso</strong></h6></td> 
      <td width="8" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Cantidad</strong></h6></td>
      <td width="20" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Origen</strong></h6></td>
      <td width="20" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Producto</strong></h6></td>
      <td width="10" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Fecha Ingreso</strong></h6></td>
      <td width="20" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><h6><strong>Conductor</strong></h6></td>  
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
    @foreach($ingresoCanastillos as $key => $ig) {
      <?php 
        $nro = $nro + 1;
      ?>
      <tr>      
        <td align="center"><h6>{{$nro}}</h6></td>
        <td align="center">
          <h6>
          {{$ig->ctl_descripcion}}
          </h6>
        </td>
        <td align="center"><h6>{{$ig->iac_nro_ingreso}}</h6></td>
        <td align="center"><h6>{{$ig->iac_cantidad}}</h6></td> 
        <td align="center"><h6>{{$ig->nombre_planta}}</h6></td>
        <td align="center"><h6>{{$ig->producto}}</h6></td>
        <td align="center"><h6>{{date('d/m/Y',strtotime($ig->iac_fecha_ingreso))}}</h6></td>
        <td align="center"><h6>{{$ig->conductor}}</h6></td>
      </tr> 
    @endforeach
  </tbody>
</table>
</html>