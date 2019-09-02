@php
$user = DB::table('public._bp_usuarios')->join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('_bp_usuarios.usr_id',Auth::user()->usr_id)->first();

@endphp

<html>
<table>
      <td align="center" colspan="1"><img src="img/logopeqe.png" width="80" /></td>
      <td colspan="11" style="text-align:center; vertical-align: middle;"><h2>EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS</h2></td>
</table>
<table>
    <tr>
      <td colspan="12" style="text-align:center;"><strong><h6>REPORTE MENSUAL</h6></strong></td>
    </tr>    
    <tr>
      <td colspan="1"><h6><strong>PLANTA:</strong></h6></td>
      <td colspan="11">{{$planta->nombre_planta}}</td>
   </tr>
</table>
<table border="1">
  <thead class="table_head">
   <tr>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><strong>N°</strong></td>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><strong>Código</strong></td>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><strong>Detalle Articulo</strong></td> 
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><strong>Precio U.</strong></td>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><strong>Total</strong></td>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><strong>Unidad</strong></td>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><strong>Entrada</strong></td>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><strong>Salida</strong></td>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><strong>Saldo</strong></td> 
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><strong>Entrada</strong></td>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><strong>Salida</strong></td>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><strong>Saldo</strong></td>       
   </tr>
  </thead>
  <tbody>
  
  </tbody>

  

</table>
</html>