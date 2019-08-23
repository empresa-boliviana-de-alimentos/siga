@php
	
	$sum = \DB::table('acopio.acopio')->join('acopio.proveedor as prov','acopio.acopio.aco_id_prov','=','prov.prov_id')
                            ->join('acopio.tipo_proveedor as tp','prov.prov_id_tipo','=','tp.tprov_id')
                            ->leftjoin('acopio.comunidad as com','prov.prov_id_comunidad','=','com.com_id')
                            ->join('acopio.municipio as mun','prov.prov_id_municipio','=','mun.mun_id')
                            ->join('acopio.departamento as dpto','prov.prov_exp','=','dpto.dep_id')//NUEVO
                            ->join('public._bp_usuarios as usu','acopio.acopio.aco_id_usr','=','usu.usr_id')
                            ->join('public._bp_zonas as zona','usu.usr_zona_id','=','zona.zona_id')//NUEVO
                            ->join('public._bp_personas as per','usu.usr_prs_id', '=', 'per.prs_id')
                            ->where('acopio.aco_id_linea','=',1)->where('acopio.aco_estado','=','A')
                            ->where('prov_estado','=','A')->orderBy('aco_fecha_acop','ASC')->get();
    
    $date=date('Y-m-d')
@endphp
<html>
<table>
   <tr>
      <td colspan="2" style="text-align: center;"><img src="img/logopeqe.png" width="150" /></td>
      <td colspan="21" style="text-align:center;"><strong><h1>EMPRESA BOLIVIANA DE ALIMENTOS</h1></strong></td>
   </tr>
   <tr>
   	  <td colspan="2"></td>
      <td colspan="21"  align="center"><strong><h1>ACOPIOS ALMENDRA</h1></strong></td>
    </tr>
    <tr>
      <td colspan="2"></td>
      <td colspan="21" align="center"><strong><h1>FECHA: {{$date}} </h1></strong></td>
    </tr>
    
</table>
<table border="1">
  <thead class="table_head">
   <tr>
      <td align="center" width="10" style="background: #186BBA;"><strong>NRO</strong></td>
      <td align="center" width="30" style="background: #186BBA;"><strong>COMPRADOR</strong></td>
      <td align="center" style="background: #186BBA;"><strong>NRO DOC SERIE A.</strong></td>
      <td align="center" style="background: #186BBA;"><strong>NRO DOC SERIE B.</strong></td>
      <td align="center" style="background: #186BBA;"><strong>NRO DOC SERIE C.</strong></td>
      <td align="center" style="background: #186BBA;"><strong>FECHA</strong></td>
      <td align="center" width="30" style="background: #186BBA;"><strong>COMUNIDAD</strong></td>
      <td align="center" width="30" style="background: #186BBA;"><strong>MUNICIPIO</strong></td>
      <td align="center" width="30" style="background: #186BBA;"><strong>NOMBRES</strong></td>
      <td align="center" style="background: #186BBA;"><strong>TIPO CASTAÑA</strong></td>
      <td align="center" width="30" style="background: #186BBA;"><strong>COMUN.</strong></td>
      <td align="center" style="background: #186BBA;"><strong>CONV</strong></td>
      <td align="center" width="10" style="background: #186BBA;"><strong>NRO CI.</strong></td>
      <td align="center" width="10" style="background: #186BBA;"><strong>EN CAJAS INGRESO</strong></td>
	  <td align="center" width="10" style="background: #186BBA;"><strong>C. ACUM. SALDO</strong></td>
      <td align="center" width="10" style="background: #186BBA;"><strong>PESO KG CAJA</strong></td>
      <td align="center" width="10" style="background: #186BBA;"><strong>EN KG. INGRESO</strong></td>
      <td align="center" width="10" style="background: #186BBA;"><strong>EN KG. SALDO</strong></td>
      <td align="center" width="10" style="background: #186BBA;"><strong>PRECIO CAJA</strong></td>
      <td align="center" width="10" style="background: #186BBA;"><strong>EN BS. INGRESO</strong></td>
      <td align="center" width="10" style="background: #186BBA;"><strong>EN BS. SALDO</strong></td>
      <td align="center" width="10" style="background: #186BBA;"><strong>RETENCIONES MONTO IMP.</strong></td>
      <td align="center" width="10" style="background: #186BBA;"><strong>RETENCIONES 3.25 %</strong></td>
   </tr>
  </thead>
  <tbody>
    	@php
    		$cant=0;
            $cant1=0;
            $cant2=0;
            $acumcacaja2 = 0;
            $acuegreso = 0;
    		$nro = 0;
    	@endphp
        @foreach($sum as $su)
        	@php
        		$nro = $nro+1;
                $fechaEntera = strtotime($su->aco_fecha_acop);
                $anio = date("Y", $fechaEntera);
                $mes = date("m", $fechaEntera);
                $dia = date("d", $fechaEntera);
                $neto=$su->aco_peso_neto;
                $acum=$cant+$neto;
                $num=$su->aco_cantidad;
                $acumca=$cant1+$num;
                $acumcacaja = $num*$su->aco_peso_neto;
                $acumcacaja2 = $acumcacaja2 + $acumcacaja;
                $tot=$su->aco_cos_total;
                $acumtot=$cant2+$tot;
                $egreso = $num*$su->aco_cos_un;
                $acuegreso = $acuegreso + $egreso;
                $imp = $egreso / 0.9675;
                $reten = $imp * 3.25/100; 
        	@endphp
            <tr>
                <td>{{$nro}}</td>
                <td>{{$su->prs_nombres.' '.$su->prs_paterno}}</td>
                <td><?php if ($su->zona_id == 1){ ?>
                	{{ $su->aco_num_rec }}
                <?php } ?></td>
                <td><?php if ($su->zona_id == 2){ ?>
                	{{ $su->aco_num_rec }}
                <?php } ?></td>
                <td><?php if ($su->zona_id == 3){ ?>
                	{{ $su->aco_num_rec }}
                <?php } ?></td>
                <td>{{$dia.'/'.$mes.'/'.$anio}}</td>
                <td>{{$su->com_nombre}}</td>
                <td>{{$su->mun_nombre}}</td>
                <td>{{$su->prov_nombre.' '.$su->prov_ap.' '.$su->prov_am}}</td>
                <td><?php if ($su->aco_id_tipo_cas == 1){ ?>
                	O
                <?php }else{ ?>
					C
                <?php } ?>
                </td>
                <td>{{$su->tprov_tipo}}</td>
                <td>{{$su->prov_id_convenio}}</td>
                <td>{{$su->prov_ci.' '.$su->dep_exp}}</td>
                <td>{{number_format($su->aco_cantidad,2,'.',',')}}</td>
                <td>{{number_format($acumca,2,'.',',')}}</td>
                <td>{{number_format($su->aco_peso_neto,2,'.',',')}}</td>
                <td>{{number_format($acumcacaja,2,'.',',')}}</td>
                <td>{{number_format($acumcacaja2,2,'.',',')}}</td>
                <td>{{number_format($su->aco_cos_un,2,'.',',')}}</td>
                <td>{{number_format($egreso,2,'.',',')}}</td>
                <td>{{number_format($acuegreso,2,'.',',')}}</td>
                <td>{{number_format($imp,2,'.',',')}}</td>
                <td>{{number_format($reten,2,'.',',')}}</td>
            </tr>
            @php
            	$cant=$acum;
                $cant1=$acumca;
                $cant2=$acumtot;
            @endphp
        @endforeach 
  </tbody>
    
</table>

   

</html>