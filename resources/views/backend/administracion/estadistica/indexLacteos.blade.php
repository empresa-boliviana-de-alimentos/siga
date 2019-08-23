@extends('backend.template.app')
@section('main-content')
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary text-center">
			<div class="panel-heading" style="background: #007bc4;"><h4><strong>ESTADÍSTICAS - ACOPIO LACTEOS<br>FECHA: <span id="fecha_label"></span></strong></h4></div>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-3 col-xs-6">
					    <div class="small-box bg-aqua-gradient">
					        <div class="inner">
					          	<h4 style="font-family: 'Arial Black';"><span id="cantidad_comprador">120</span></h4>
					          	<p>TOTAL MODULOS</p>
					        </div>
					        <div class="icon">
					          	<i class="fa fa-users"></i>
					        </div>					            
					    </div>
					</div>
					<div class="col-lg-3 col-xs-6">
					    <div class="small-box bg-red-gradient">
					        <div class="inner">
					          	<h4 style="font-family: 'Arial Black';"><span id="cantidad_proveedor">480</span></h4>
					          	<p>TOTAL PROVEEDORES</p>
					        </div>
					        <div class="icon">
					          	<i class="fa fa-users"></i>
					        </div>
					    </div>
					</div>
					<div class="col-lg-3 col-xs-6">
					    <div class="small-box bg-yellow-gradient">
					        <div class="inner">
					          <h4 style="font-family: 'Arial Black';"><span id="cantidad_kilos_label"></span>12,000.00 LTS</h4>
					          <p>TOTAL ACOPIADO EN LTS</p>
					        </div>
					        <div class="icon">
					          <i class="fa fa-dropbox"></i>
					        </div>
					    </div>
					</div>
					<div class="col-lg-3 col-xs-6">
					    <div class="small-box bg-purple-gradient">
					        <div class="inner">
					          <h4 style="font-family: 'Arial Black';"><span id="cantidad_monto_label"></span>36,000.00 Bs.</h4>
					          <p>TOTAL ACOPIADO EN BS</p>
					        </div>
					        <div class="icon">
					          <i class="fa fa-money"></i>
					        </div>
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
							<div class="panel-heading" style="background: #007bc4">PLANTAS TOTAL LTS</div>
							<canvas id="myChart"></canvas>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="panel panel-primary">
							<div class="panel-heading" style="background: #007bc4">PLANTAS TOTAL BS</div>
							<canvas id="myChart2"></canvas>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="panel panel-primary">
							<div class="panel-heading" style="background: #007bc4">ACOPIO  POR PLANTAS</div>
							<table class="table table-bordered" id="tablaPlantas">
								<thead>
									<tr>
										<th class="text-center">PLANTA</th>
										<th class="text-center">TOTAL LTS.</th>
										<th class="text-center">TOTAL BS.</th>
									</tr>
								</thead>
								<tbody>
									
								</tbody>
								<tfoot>
									<tr>
										<th class="text-center">TOTAL</th>
										<th class="text-center" id="total_lts"></th>
										<th class="text-center" id="total_precio"></th>
									</tr>
								</tfoot>					
							</table>	
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

// CHATS JS
var ctx = document.getElementById('myChart');
	myChart = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: ['Achacachi', 'Challapata', 'San Lorenzo','San Andres','Ivirgazama'],
		datasets: [{
			label: 'CANTIDAD KG',
			data: [120,50,110,100,95],
			backgroundColor: [
			    'rgba(255, 99, 132, 0.8)',
			    'rgba(54, 162, 235, 0.8)',
			    'rgba(255, 206, 86, 0.8)',
			    'rgba(200, 206, 86, 0.8)',
			    'rgba(180, 80, 86, 0.8)',		                
			],
			borderColor: [
			    'rgba(255, 99, 132, 1)',
			    'rgba(54, 162, 235, 1)',
			    'rgba(255, 206, 86, 1)',
			    'rgba(200, 206, 86, 1)',
			    'rgba(180, 80, 86, 1)',			             
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

var ctx = document.getElementById('myChart2');
	myChart = new Chart(ctx, {
	type: 'bar',
	data: {
		labels: ['Achacachi', 'Challapata', 'San Lorenzo','San Andres','Ivirgazama'],
		datasets: [{
			label: 'CANTIDAD KG',
			data: [1200,500,1100,1000,950],
			backgroundColor: [
			    'rgba(255, 99, 132, 0.8)',
			    'rgba(54, 162, 235, 0.8)',
			    'rgba(255, 206, 86, 0.8)',
			    'rgba(200, 206, 86, 0.8)',
			    'rgba(180, 80, 86, 0.8)',		                
			],
			borderColor: [
			    'rgba(255, 99, 132, 1)',
			    'rgba(54, 162, 235, 1)',
			    'rgba(255, 206, 86, 1)',
			    'rgba(200, 206, 86, 1)',
			    'rgba(180, 80, 86, 1)',			             
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

// PLANTAS
var plantas = <?php echo $plantas ?>;
var total_lts = 0;
var total_precio = 0;
for (var i = 0; i < plantas.length; i++) {
	total_lts = total_lts + plantas[i].id_planta;
	total_precio = total_precio + plantas[i].id_linea_trabajo;
	 $("#tablaPlantas").append('<tr class="items_colums">' + 
                    '<td align="center" style="dislay: none;">'+plantas[i].nombre_planta+'</td>'+
                    '<td align="center" style="dislay: none;">'+plantas[i].id_planta+'</td>'+
                    '<td align="center" style="dislay: none;">'+plantas[i].id_linea_trabajo+'</td>');
}
console.log(total_lts);
document.getElementById('total_lts').innerHTML = total_lts;
document.getElementById('total_precio').innerHTML = total_precio;
</script>
@endpush