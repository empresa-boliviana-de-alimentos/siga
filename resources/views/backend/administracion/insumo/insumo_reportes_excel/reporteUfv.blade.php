@php
$user = DB::table('public._bp_usuarios')->join('public._bp_personas as per','public._bp_usuarios.usr_prs_id','=','per.prs_id')
                ->where('_bp_usuarios.usr_id',Auth::user()->usr_id)->first();

@endphp

<html>
<table>
      <td><img src="img/logopeqe.png" width="100" /></td>
      <td colspan="2" style="text-align:center; vertical-align: middle;"><h5>EMPRESA BOLIVIANA DE ALIMENTOS Y DERIVADOS</h5></td>
</table>
<table>
    <tr>
      <td colspan="3" style="text-align:center;"><strong><h6>CUADRO DE UFVS</h6></strong></td>
    </tr>
    <tr>
      <td colspan="3" style="text-align:center;"><strong><h7></h7></strong></td>
    </tr>
    <tr>
      <td colspan="3" align="center"><strong><h1></h1></strong></td>
    </tr>
      <tr>
      <td colspan="3"  align="center"><strong><h1>EXPRESADO EN BOLIVIANOS</h1></strong></td>
    </tr>
    <tr>
      <td colspan="3"><strong><h6>GENERADO POR: {{ $user->prs_nombres }} {{ $user->prs_paterno }} {{ $user->prs_materno}}</h6></strong></td>
   </tr>
</table>
<table border="1">
  <thead class="table_head">
   <tr>
      <td width="15" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><strong>N°</strong></td>
      <td align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><strong>FECHA</strong></td>
      <td width="40" align="center" style="background-color: #808080; border: 1px solid #000000; vertical-align: middle;"><strong>UFV</strong></td>      
   </tr>
  </thead>
  <tbody>
  <?php $nro=0 ?>
  @foreach($ufvs as $ufv)

    <?php $nro=$nro+1; ?>
    <tr>
      <td align="center" style="border: 1px solid #000000;">{{$nro}}</td>
      <td align="center" style="border: 1px solid #000000;">{{$ufv->ufv_registrado}}</td>
      <td align="center" style="border: 1px solid #000000;">{{$ufv->ufv_cant}}</td>
    </tr>
  @endforeach
  </tbody>

  

</table>
</html>