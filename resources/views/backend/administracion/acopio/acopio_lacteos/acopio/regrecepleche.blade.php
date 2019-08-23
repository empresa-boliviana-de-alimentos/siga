@extends('backend.template.app')
@section('main-content')

<div align="right" class="page-header">
    <td>
        
        <center> <h2><font face="Showcard Gothic"> Acopios Lacteos Proveedores </font> </h2></center>
       
    </td>
</div>
<!--<form class="form-horizontal" method="POST" action="php_action/createAsignar.php" id="createOrderForm-->
	<div class="panel panel-danger table-edit">
    <div class="panel-heading">
        <h3 class="panel-title">
            <span>
                <i class="livicon" data-name="edit" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    REGISTRO DE ACOPIO PROVEEDORES DIARIA
            </span>
        </h3>
    </div>
    <div class="panel-body">
 		<div class="row">
            <div class="col-md-3">
                <div class="col-sm-12">
                    <label>  Fecha :    </label>
                    <center> <label>
                        <?php  
                            date_default_timezone_set('America/New_York');
                            echo  date('m/d/Y g:ia');
                        ?>
                    </center></label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="col-sm-12">
                    <label> Certificación de Aceptación: </label>
                    <select class="form-control" id="aco_apr" name="aco_apr">
                        <option value="1">Aceptado</option>
                        <option value="2">Rechazado</option> 
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-sm-12">
                    <label> Observaciones: </label>
                    {!! Form::text('aco_obs', null, array('placeholder' => 'Ingrese Municipio','maxlength'=>'50','class' => 'form-control','id'=>'aco_obs')) !!}
                 </div>
            </div> 
        </div>
       <!-- <div class="row">
         
            
            
            <div class="col-md-3">
                <div class="col-sm-12">
                    <label>  Tipo Envase:    </label>
                    <select class="form-control" id="aco_tenv" name="aco_tenv">
                        <option value="1">Aluminio</option>
                        <option value="2">Plastico</option> 
                    </select>
                </div>
           </div>  
        </div>
        <div class="row">
                                 
            <div class="col-md-4">
                <div class="col-sm-12">
                    <label>  Condiciones de Higiente:    </label>
                    <select class="form-control" id="aco_cond" name="aco_cond">
                        <option value="1">Aceptable</option>
                        <option value="2">No Aceptable</option> 
                    </select>
                </div>
            </div>
        </div> -->
		<table class="table" id="productTable">
			<!--<thead>
			  	<tr>
			  			<th style="width:6%; text-align: center;">#</th>	
			  			<th style="width:15%; text-align: center;">Proveedor</th>			  			
			  			<th style="width:30%; text-align: center;">Descripción</th>
			  			<th style="width:15%; text-align: center;">Codigo Sucre</th>
			  			<th style="width:15%; text-align: center;">Marca</th>			  			
			  			<th style="width:15%; text-align: center;">Estado</th>			  			
			  			<th style="width:10%;"></th>
			  		</tr>
			</thead>-->
			<thead>
			  	<tr>
			  			<th style="width:5%; text-align: center;">#</th>	
			  			<th style="text-align: center;">Proveedor</th>			  			
			  			<th style="text-align: center;">Hrs</th>
			  			<th style="text-align: center;">Cantidad</th>
			  			<th style="text-align: center;">Temperatura</th>			  			
			  			<th style="text-align: center;">SNG</th>	
			  			<th style="text-align: center;">P.Alcohol</th>	
			  			<th style="text-align: center;">Aspecto</th>	
			  			<th style="text-align: center;">Color</th>	
			  			<th style="text-align: center;">Olor</th>	
			  			<th style="text-align: center;">Sabor</th>	
			  			<th style="text-align: center;">T.envase</th>	
			  			<th style="text-align: center;">Con.Hig</th>			  			
			  			<th style="width:10%;"></th>
			  		</tr>
			</thead>
			<tbody>
			  	<!--Comenzamos a añadir campos para venta -->
			  	<?php
				$arrayNumber = 0;
		 		#contador para añadir lineas
		  		$numero = 1;
		  		for ($x=1; $x <21; $x++) { 
		            ?>
			  		<!--Se imprime las filas en la tabla -->
			  		<tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">
			  			<td style="margin-left:6px;">
							<input type="text" name="num[]" id="num<?php echo $x; ?>" autocomplete="off"  class="form-control"  value="<?php echo $numero; ?>" disabled="true"/>	
						</td>
						<td style="margin-left:20px;">
							<input type="text" name="codET[]" id="codET<?php echo $x; ?>" autocomplete="off"  class="form-control" onchange="getEquipoData(<?php echo $x; ?>)" />	
						</td>
						<td style="margin-left:10px;">
							<input type="text" name="aco_hrs[]" id="aco_hrs<?php echo $x; ?>" autocomplete="off"  class="form-control"/>
						</td>
						<td style="margin-left:10px;">
							<input type="text" name="aco_can[]" id="aco_can<?php echo $x; ?>" autocomplete="off"  class="form-control"/>
						</td>
						<td style="margin-left:10px;">
							<input type="text" name="aco_tem[]" id="aco_tem<?php echo $x; ?>" autocomplete="off"  class="form-control" onchange="getEquipoData(<?php echo $x; ?>)" />	
						</td>
						<td style="margin-left:10px;">
							<input type="text" name="aco_sng[]" id="aco_sng<?php echo $x; ?>" autocomplete="off"  class="form-control"/>
						</td>
						<td style="margin-left:10px;">
					 		<select class="form-control" id="aco_pal<?php echo $x; ?>" name="aco_pal[]">
                                <option value="1"> + </option>
                                <option value="1"> - </option>         
                            </select>
						</td>
						<td style="margin-left:20px;">
						    <select class="form-control" id="n_asp[]" name="n_asp<?php echo $x; ?>">
                                <option value="1">Liquido</option>
                                <option value="2">Homogeneo</option> 
                            </select>
					    </td>
						<td style="margin-left:20px;">
							<select class="form-control" id="n_col[]" name="n_col<?php echo $x; ?>">
                                <option value="1">Blanco Opaco</option>
                                <option value="2">Blanco Cremoso</option>   
                            </select>
						</td>
				  		<td style="padding-left:20px;">
							<select class="form-control" id="n_olo[]" name="n_olo<?php echo $x; ?>">
                                <option value="1">SI</option>
                                <option value="2">NO</option>   
                            </select>
			  			</td>
			  			<td style="padding-left:20px;">
			 				<select class="form-control" id="n_sab[]" name="n_sab<?php echo $x; ?>">
                                <option value="1">Poco Dulce</option>
                                <option value="2">Agradable</option>   
                            </select>
				  		</td>
				  		<td style="padding-left:20px;">
			  				<select class="form-control" id="aco_tenv[]" name="aco_tenv<?php echo $x; ?>">
		                        <option value="1">Aluminio</option>
		                        <option value="2">Plastico</option> 
		                    </select>
			  			</td>	
			  			<td style="padding-left:20px;">			  					
			  					<select class="form-control" id="aco_cond[]" name="aco_cond<?php echo $x; ?>">
			                        <option value="1">Aceptable</option>
			                        <option value="2">No Aceptable</option> 
			                    </select>		  					
			  			</td>
			  				<td>
			  					<button class="btn btn-default removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
			  				</td>	 
				  		</tr>
			  		<?php
			  		$arrayNumber++;
			  		$numero++;
			  		}//for donde añadimos los campos
			  		?>
			  	</tbody>
			</table><!-- Table Productos Order-->
			</br>	
			<!--Campos de Total de Pago-->
			<div class="col-md-6">
				<div class="form-group">
				    <label for="totet" class="col-sm-3 control-label">Cantidad de Litros:</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="totet" name="totet"/>
				    </div>
				</div> <!--/form-group-->
				
			
				<div class="form-group">
				    <label for="autorizado" class="col-sm-3 control-label">Autorizado Por:</label>
				    <div class="col-sm-9">
				     <!-- <input type="text" class="form-control" id="autorizado" name="autorizado""/>-->
				      <select class="form-control" name="autorizado" id="autorizado"">
				   		   	<option selected disabled hidden value="">-- Selecciona --</option>
				      		<option value="Miguel Orias">nom1</option>
				      		<option value="Liz Camacho"nom2</option>
				      		
				        </select>
				    </div>

				</div> <!--/form-group-->
				
			</div>
			<!--End Campos de Total de Pago-->
	
			<!-- Campos de Forma de Pago-->
			

			<!-- End Campos de Forma de Pago-->
			<div class="form-group submitButtonFooter">
			    <div class="col-sm-offset-2 col-sm-10">
				<!--<button type="button" class="btn btn-warning" onclick="addRow()" id="addRowBtn" data-loading-text="Cargando..."> <i class="glyphicon glyphicon-plus-sign"></i> Añadir fila </button>-->
				    <button type="submit" id="createOrderBtn" data-loading-text="Cargando..." class="btn btn-success"><i class="glyphicon glyphicon-ok-sign"></i> Guardar cambios</button>
				    <button type="reset" class="btn btn-info" onclick="resetOrderForm()"><i class="glyphicon glyphicon-erase"></i> Reiniciar</button>
			    </div>
			</div>
		<!--</form>-->
		<!--Form Order-->


	</div> <!--Panel-Body-->
</div> <!--/Panel Defaul -->

@endsection

@push('scripts')