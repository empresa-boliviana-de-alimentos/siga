@extends('backend.template.app')
@section('main-content')
<div class="row">	
	<div class="col-lg-12">
		<div class="panel panel-primary text-center" >
	    	<div class="panel-heading" style="background: #449c54"><h4><strong>ESTADÍSTICAS - ACOPIO ALMENDRA<br>FECHA:<span id="fecha_label"></span></strong></h4></div>
			    <div class="panel-body">
			    	<div class="row">
						<div class="col-lg-3 col-xs-6">
					          <div class="small-box bg-aqua-gradient">
					            <div class="inner">
					              <h4 style="font-family: 'Arial Black';"><span id="cantidad_comprador"></span></h4>
					              <p>TOTAL COMPRADORES</p>
					            </div>
					            <div class="icon">
					              <i class="fa fa-users"></i>
					            </div>
					            <!-- <a href="#" class="small-box-footer">
					              <i class="fa fa-arrow-circle-right"></i>
					            </a> -->
					          </div>
						</div>
						<div class="col-lg-3 col-xs-6">
					          <div class="small-box bg-red-gradient">
					            <div class="inner">
					              <h4 style="font-family: 'Arial Black';"><span id="cantidad_proveedor"></span></h4>
					              <p>TOTAL PROVEEDORES</p>
					            </div>
					            <div class="icon">
					              <i class="fa fa-users"></i>
					            </div>
					            <!-- <a href="#" class="small-box-footer">
					              <i class="fa fa-arrow-circle-right"></i>
					            </a> -->
					          </div>
						</div>
						<div class="col-lg-3 col-xs-6">
					          <div class="small-box bg-yellow-gradient">
					            <div class="inner">
					              <h4 style="font-family: 'Arial Black';"><span id="cantidad_kilos_label"></span> KG</h4>
					              <p>TOTAL ACOPIADO EN KG</p>
					            </div>
					            <div class="icon">
					              <i class="fa fa-dropbox"></i>
					            </div>
					            <!-- <a href="#" class="small-box-footer">
					              <i class="fa fa-arrow-circle-right"></i>
					            </a> -->
					          </div>
						</div>
						<div class="col-lg-3 col-xs-6">
					          <div class="small-box bg-purple-gradient">
					            <div class="inner">
					              <h4 style="font-family: 'Arial Black';"><span id="cantidad_monto_label"></span> Bs.</h4>
					              <p>TOTAL ACOPIADO EN BS</p>
					            </div>
					            <div class="icon">
					              <i class="fa fa-money"></i>
					            </div>
					            <!-- <a href="#" class="small-box-footer">
					              <i class="fa fa-arrow-circle-right"></i>
					            </a> -->
					          </div>
						</div>						
				    </div>
				    <div class="row">
				    	<div class="text-center">
				    		<h4><strong>BUSQUEDA DE ESTADÍSTICAS</strong></h4>
				    	</div>
				    	<div class="col-lg-4 form-inline">
				    		<div class="form-gorup">
				    			<label><strong>DÍA: </strong></label>
				    			<input type="text" id="dia" class="datepickerDays form-control">
				    		</div>
				    	</div>
				    	<div class="col-lg-4 form-inline">
				    		<label><strong>MES: </strong></label>
				    		<input type="text" id="mes" class="datepickerMonths form-control">
				    	</div>
				    	<div class="col-lg-4 form-inline">
				    		<label><strong>GESTIÓN: </strong></label>
				    		<input type="text" id="anio" class="datepickerYears form-control">
				    	</div>
				    </div>
				    <br>
				    <div class="row">
				    	<div class="col-lg-4">
				    		<div class="panel panel-primary">  
						    	<div class="panel-heading" style="background: #449c54">ZONAS - CANTIDAD ACOPIADA EN KG</div>
						    	<canvas id="myChart" width="400" height="200"></canvas>
							</div>
				    	</div>
				    	<div class="col-lg-4">
				    		<div class="panel panel-primary">  
						    	<div class="panel-heading" style="background: #449c54">ZONAS - COSTO TOTAL ACOPIADO EN BS</div>
						    	<canvas id="myChart2" width="400" height="200"></canvas>
							</div>
				    	</div>
				    	<div class="col-lg-4">
				    		<div class="panel panel-primary">  
						    <div class="panel-heading" style="background: #449c54">TOTAL PROVEEDORES: 3000</div>
						    <table class="table table-bordered">
							    <thead>
							      <tr>
							        <th class="text-center">ZONA</th>
							        <th class="text-center">CANTIDAD KG</th>
							        <th class="text-center">COSTO BS</th>
							        
							      </tr>
							    </thead>
							    <tbody>
							      	<tr>
							        	<td class="text-center">A</td>
							        	<td class="text-center"><span id="cant_zonaAkg"></span></td>
							        	<td class="text-center"><span id="monto_zonaAbs"></span></td>							        	
							      	</tr>
							      	<tr>
							        	<td class="text-center">B</td>
							        	<td class="text-center"><span id="cant_zonaBkg"></span></td>
							        	<td class="text-center"><span id="monto_zonaBbs"></span></td>							        	
							      	</tr>
							      	<tr>
							        	<td class="text-center">C</td>
							        	<td class="text-center"><span id="cant_zonaCkg"></span></td>
							        	<td class="text-center"><span id="monto_zonaCbs"></span></td>							        	
							      	</tr>							      							      	
							    </tbody>
							    <tfooter>
							    	<th colspan="1" class="text-center">Totales</th>
							    	<th class="text-center"><span id="total_cantidad_zonas"></span></th>
							    	<th class="text-center"><span id="total_monto_zonas"></span></th>
							    </tfooter>
							</table>
						</div>	
				    	</div>
				    	
				    </div>
			</div>			    
		</div>
	</div>	
</div>
<div class="row">	
	<div class="col-lg-12">
		<div class="panel panel-primary text-center">
	    	<div class="panel-heading" style="background: #449c54"><strong>TOTAL PROVEEDORES: 3000</strong></div>
			    <div class="panel-body">
					<div class="col-lg-8">
						<div class="panel panel-primary">  
						    <div class="panel-heading" style="background: #449c54">TOTAL PROVEEDORES: 3000</div>
						    <table class="table table-bordered">
							    <thead>
							      <tr>
							        <th class="text-center">Comunario</th>
							        <th class="text-center">Rescatista</th>
							        <th class="text-center">Barraquero</th>
							        <th class="text-center">Cum. Campesina</th>
							        <th class="text-center">cum. Indigena</th>
							        <th class="text-center">Propiedad Privada</th>
							      </tr>
							    </thead>
							    <tbody>
							      	<tr>
							        	<td class="text-center">100</td>
							        	<td class="text-center">50</td>
							        	<td class="text-center">80</td>
							        	<td class="text-center">150</td>
							        	<td class="text-center">100</td>
							        	<td class="text-center">200</td>
							      	</tr>						      	
							    </tbody>
							</table>
						</div>						
					</div>
					<div class="col-lg-4">
						<div class="panel panel-primary">  
						    <div class="panel-heading" style="background: #449c54">TOTAL COMPRADORES: 1000</div>
						    <table class="table table-bordered">
							    <thead>
							      	<tr>
							        	<th class="text-center">ZONA A</th>
							        	<th class="text-center">ZONA B</th>
							        	<th class="text-center">ZONA C</td>
							      	</tr>
							    </thead>
							    <tbody>
							      	<tr>
							        	<td class="text-center">300</td>
							        	<td class="text-center">500</td>
							        	<td class="text-center">200</td>
							      	</tr>						      	
							    </tbody>
							</table>
						</div>
					</div>
			    </div>	
			</div>			    
		</div>
	</div>	
</div>
	
</div>
@endsection
@push('scripts')
<script>

// var myChart;
// var myChart3;
$('#dia').on('change', function(e){

	console.log($("#dia").val());
	var dia_busqueda = $("#dia").val(); 
	// document.getElementById('fecha_label').innerHTML = $("#dia").val();
	$.get('estadisticaFechaAlmendra?fecha='+dia_busqueda, function(data){
        
            console.log(data);
            document.getElementById('fecha_label').innerHTML = data.fecha;
            document.getElementById('cantidad_kilos_label').innerHTML = data.total_cantidad_kilos;
            document.getElementById('cantidad_monto_label').innerHTML = data.total_costo_bs;
            document.getElementById('cantidad_comprador').innerHTML = data.total_comprador;
            document.getElementById('cantidad_proveedor').innerHTML = data.total_proveedor;

            document.getElementById('cant_zonaAkg').innerHTML = data.cantidad_total_zonaA;
            document.getElementById('cant_zonaBkg').innerHTML = data.cantidad_total_zonaB;
            document.getElementById('cant_zonaCkg').innerHTML = data.cantidad_total_zonaC;

            document.getElementById('monto_zonaAbs').innerHTML = data.monto_total_zonaA;
            document.getElementById('monto_zonaBbs').innerHTML = data.monto_total_zonaB;
            document.getElementById('monto_zonaCbs').innerHTML = data.monto_total_zonaC;

            document.getElementById('total_cantidad_zonas').innerHTML = data.total_cantidad_kilos;
            document.getElementById('total_monto_zonas').innerHTML = data.total_costo_bs;

            // myChart.destroy();
            // myChart3.destroy();
            var ctx = document.getElementById('myChart');
			myChart = new Chart(ctx, {
			    type: 'bar',
			    data: {
			        labels: ['Zona A', 'Zona B', 'Zona C'],
			        datasets: [{
			            label: 'CANTIDAD KG',
			            data: [data.cantidad_total_zonaA, data.cantidad_total_zonaB, data.cantidad_total_zonaC],
			            backgroundColor: [
			                'rgba(255, 99, 132, 0.8)',
			                'rgba(54, 162, 235, 0.8)',
			                'rgba(255, 206, 86, 0.8)'		                
			            ],
			            borderColor: [
			                'rgba(255, 99, 132, 1)',
			                'rgba(54, 162, 235, 1)',
			                'rgba(255, 206, 86, 1)'			             
			            ],
			            borderWidth: 1
			        }]
			    },
			    options: {
			        scales: {
			            yAxes: [{
			                ticks: {
			                    beginAtZero: true
			                }
			            }]
			        }
			    }
			});

			var ctx2 = document.getElementById('myChart2');
			var myChart2 = new Chart(ctx2, {
			    type: 'bar',
			    data: {
			        labels: ['Zona A', 'Zona B', 'Zona C'],
			        datasets: [{
			            label: 'PRECIO BS',
			            data: [data.monto_total_zonaA, data.monto_total_zonaB, data.monto_total_zonaC],
			            backgroundColor: [
			                'rgba(99, 99, 132, 0.8)',
			                'rgba(162, 162, 235, 0.8)',
			                'rgba(206, 206, 86, 0.8)'		                
			            ],
			            borderColor: [
			                'rgba(99, 99, 132, 1)',
			                'rgba(162, 162, 235, 1)',
			                'rgba(206, 206, 86, 1)'			             
			            ],
			            borderWidth: 1
			        }]
			    },
			    options: {
			        scales: {
			            yAxes: [{
			                ticks: {
			                    beginAtZero: true
			                }
			            }]
			        }
			    }
			});
        
    });
});

$('#mes').on('change', function(e){
	console.log($("#mes").val());
	var mes_busqueda = $("#mes").val(); 
	// document.getElementById('fecha_label').innerHTML = $("#dia").val();
	$.get('estadisticaMesAlmendra?fecha='+mes_busqueda, function(data){
        
            console.log(data);
            document.getElementById('fecha_label').innerHTML = data.fecha;
            document.getElementById('cantidad_kilos_label').innerHTML = data.total_cantidad_kilos;
            document.getElementById('cantidad_monto_label').innerHTML = data.total_costo_bs;
            document.getElementById('cantidad_comprador').innerHTML = data.total_comprador;
            document.getElementById('cantidad_proveedor').innerHTML = data.total_proveedor;

            document.getElementById('cant_zonaAkg').innerHTML = data.cantidad_total_zonaA;
            document.getElementById('cant_zonaBkg').innerHTML = data.cantidad_total_zonaB;
            document.getElementById('cant_zonaCkg').innerHTML = data.cantidad_total_zonaC;

            document.getElementById('monto_zonaAbs').innerHTML = data.monto_total_zonaA;
            document.getElementById('monto_zonaBbs').innerHTML = data.monto_total_zonaB;
            document.getElementById('monto_zonaCbs').innerHTML = data.monto_total_zonaC;

            document.getElementById('total_cantidad_zonas').innerHTML = data.total_cantidad_kilos;
            document.getElementById('total_monto_zonas').innerHTML = data.total_costo_bs;

           
            // myChart.destroy();
            var ctx3 = document.getElementById('myChart');
			var myChart3 = new Chart(ctx3, {
			    type: 'bar',
			    data: {
			        labels: ['Zona A', 'Zona B', 'Zona C'],
			        datasets: [{
			            label: 'CANTIDAD KG',
			            data: [data.cantidad_total_zonaA, data.cantidad_total_zonaB, data.cantidad_total_zonaC],
			            backgroundColor: [
			                'rgba(255, 99, 132, 0.8)',
			                'rgba(54, 162, 235, 0.8)',
			                'rgba(255, 206, 86, 0.8)'		                
			            ],
			            borderColor: [
			                'rgba(255, 99, 132, 1)',
			                'rgba(54, 162, 235, 1)',
			                'rgba(255, 206, 86, 1)'			             
			            ],
			            borderWidth: 1
			        }]
			    },
			    options: {
			        scales: {
			            yAxes: [{
			                ticks: {
			                    beginAtZero: true
			                }
			            }]
			        }
			    }
			});
			// myChart.destroy();
			var ctx4 = document.getElementById('myChart2');
			var myChart4 = new Chart(ctx4, {
			    type: 'bar',
			    data: {
			        labels: ['Zona A', 'Zona B', 'Zona C'],
			        datasets: [{
			            label: 'PRECIO BS',
			            data: [data.monto_total_zonaA, data.monto_total_zonaB, data.monto_total_zonaC],
			            backgroundColor: [
			                'rgba(99, 99, 132, 0.8)',
			                'rgba(162, 162, 235, 0.8)',
			                'rgba(206, 206, 86, 0.8)'		                
			            ],
			            borderColor: [
			                'rgba(99, 99, 132, 1)',
			                'rgba(162, 162, 235, 1)',
			                'rgba(206, 206, 86, 1)'			             
			            ],
			            borderWidth: 1
			        }]
			    },
			    options: {
			        scales: {
			            yAxes: [{
			                ticks: {
			                    beginAtZero: true
			                }
			            }]
			        }
			    }
			});

        
    });
});
// GRAFICOS POR GESTION
$('#anio').on('change', function(e){
	console.log($("#anio").val());
	var anio_busqueda = $("#anio").val(); 
	// document.getElementById('fecha_label').innerHTML = $("#dia").val();
	$.get('estadisticaAnioAlmendra?fecha='+anio_busqueda, function(data){
        
            console.log(data);
            document.getElementById('fecha_label').innerHTML = data.fecha;
            document.getElementById('cantidad_kilos_label').innerHTML = data.total_cantidad_kilos;
            document.getElementById('cantidad_monto_label').innerHTML = data.total_costo_bs;
            document.getElementById('cantidad_comprador').innerHTML = data.total_comprador;
            document.getElementById('cantidad_proveedor').innerHTML = data.total_proveedor;

            document.getElementById('cant_zonaAkg').innerHTML = data.cantidad_total_zonaA;
            document.getElementById('cant_zonaBkg').innerHTML = data.cantidad_total_zonaB;
            document.getElementById('cant_zonaCkg').innerHTML = data.cantidad_total_zonaC;

            document.getElementById('monto_zonaAbs').innerHTML = data.monto_total_zonaA;
            document.getElementById('monto_zonaBbs').innerHTML = data.monto_total_zonaB;
            document.getElementById('monto_zonaCbs').innerHTML = data.monto_total_zonaC;

            document.getElementById('total_cantidad_zonas').innerHTML = data.total_cantidad_kilos;
            document.getElementById('total_monto_zonas').innerHTML = data.total_costo_bs;

           
            // myChart.destroy();
            var ctx3 = document.getElementById('myChart');
			var myChart3 = new Chart(ctx3, {
			    type: 'bar',
			    data: {
			        labels: ['Zona A', 'Zona B', 'Zona C'],
			        datasets: [{
			            label: 'CANTIDAD KG',
			            data: [data.cantidad_total_zonaA, data.cantidad_total_zonaB, data.cantidad_total_zonaC],
			            backgroundColor: [
			                'rgba(255, 99, 132, 0.8)',
			                'rgba(54, 162, 235, 0.8)',
			                'rgba(255, 206, 86, 0.8)'		                
			            ],
			            borderColor: [
			                'rgba(255, 99, 132, 1)',
			                'rgba(54, 162, 235, 1)',
			                'rgba(255, 206, 86, 1)'			             
			            ],
			            borderWidth: 1
			        }]
			    },
			    options: {
			        scales: {
			            yAxes: [{
			                ticks: {
			                    beginAtZero: true
			                }
			            }]
			        }
			    }
			});
			// myChart.destroy();
			var ctx4 = document.getElementById('myChart2');
			var myChart4 = new Chart(ctx4, {
			    type: 'bar',
			    data: {
			        labels: ['Zona A', 'Zona B', 'Zona C'],
			        datasets: [{
			            label: 'PRECIO BS',
			            data: [data.monto_total_zonaA, data.monto_total_zonaB, data.monto_total_zonaC],
			            backgroundColor: [
			                'rgba(99, 99, 132, 0.8)',
			                'rgba(162, 162, 235, 0.8)',
			                'rgba(206, 206, 86, 0.8)'		                
			            ],
			            borderColor: [
			                'rgba(99, 99, 132, 1)',
			                'rgba(162, 162, 235, 1)',
			                'rgba(206, 206, 86, 1)'			             
			            ],
			            borderWidth: 1
			        }]
			    },
			    options: {
			        scales: {
			            yAxes: [{
			                ticks: {
			                    beginAtZero: true
			                }
			            }]
			        }
			    }
			});

        
    });
});
$('.datepickerYears').datepicker({
    format: "yyyy",
    viewMode: "years", 
    minViewMode: "months",
    language: "es",
// }).datepicker("setDate", new Date());
}); 
$('.datepickerMonths').datepicker({
    format: "mm/yyyy",
    viewMode: "months", 
    minViewMode: "months",
    language: "es",
// }).datepicker("setDate", new Date()); 
});

$('.datepickerDays').datepicker({
    format: "yyyy-mm-dd",        
    language: "es",
}).datepicker("setDate", new Date()); 
</script>
@endpush
