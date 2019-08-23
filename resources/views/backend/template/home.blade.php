@extends('backend.template.app')
@section('main-content')
<div class="row">
	<div class="col-lg-9">
		<div class="row">
			<div class="col-md-2 col-sm-2 col-md-offset-1 box0">
				<div class="box1">
					<!-- <span class="li_heart"><i class="fa fa-bar-chart-o"></i></span> -->
					<img src="../img/acopio.jpg" alt="" class="img-responsive" />
						<h3>Acopio</h3>
				</div>
				<p>Modulo de Acopio</p>
			</div>
			<a href="#"><div class="col-md-2 col-sm-2 box0">
				<div class="box1">
					<!-- <span class="li_cloud"><i class="fa fa-database"></i></span> -->
					<img src="../img/insumos.jpg" alt="" class="img-responsive"/>
					<h3>Insumos</h3>
				</div>
				<p>Modulo de Insumos</p>
			</div></a>
			<div class="col-md-2 col-sm-2 box0">
				<div class="box1">
					<!-- <span class="li_stack"><i class="fa fa-dashboard"></i></span> -->
					<img src="../img/produccion.jpg" alt="" class="img-responsive"/>
					<h3>Producción</h3>
				</div>
				<p>Modulo Producción.</p>
			</div>
			<div class="col-md-2 col-sm-2 box0">
				<div class="box1">
					<!-- <span class="li_news"><i class="fa fa-credit-card-alt"></i></span> -->
					<img src="../img/producto_terminado.jpg" alt="" class="img-responsive"/>
					<h4>Producto Terminado</h4>
				</div>
				<p>Modulo Producto Terminado.</p>
			</div>
			<div class="col-md-2 col-sm-2 box0">
				<div class="box1">
					<!-- <span class="li_data"><i class="fa fa-wpforms"></i></span> -->
					<img src="../img/comercial.jpg" alt="" class="img-responsive"/>
					<h3>Comercial</h3>
				</div>
				<p>Modulo Comercial</p>
			</div>
		</div>
	 	<div class="row">
	 	<div class="text-center">	 	
			<div class="col-md-12">
				<img src="../img/image_fondo_siga.jpg" alt=""/>
			</div>
		</div>		
		</div>
</div>
	<div class="col-lg-3 ds">

		<h3>ACOPIOS</h3>
			<div class="desc">
				<div class="col-sm-4">
					<img src="img/eba.png" alt="" style="height: 5vw; width: 5vw; border: 2px solid #fff;border-radius: 50%;box-shadow: 0 0 5px gray;display: inline-block;margin-left: 1px;margin-right: auto;">
				</div>
				<div class="col-sm-8">
					<p><h6 class="text-center" style="color:#0067B4; font-family: 'Arial Black';">TOTAL ACOPIADOS ALMENDRA</h6>
						<p class="text-center" style="font-size: 20px;">15,000.00 KG</p>
					</p>
				</div>
			</div>

			<div class="desc">
				<div class="col-sm-4">
					<img src="img/miel.jpg" alt="" style="height: 5vw; width: 5vw; border: 2px solid #fff;border-radius: 50%;box-shadow: 0 0 5px gray;display: inline-block;margin-left: auto;margin-right: auto;">
				</div>
				<div class="col-sm-8">
					<p><h6 class="text-center" style="color:#0067B4; font-family: 'Arial Black';">TOTAL ACOPIADOS MIEL</h6>
						<p class="text-center" style="font-size: 20px;">5,000.00 KG</p>
					</p>
				</div>

			</div>
			<div class="desc">
				<div class="col-sm-4">
					<img src="img/lacteo.jpg" alt="" style="height: 5vw; width: 5vw; border: 2px solid #fff;border-radius: 50%;box-shadow: 0 0 5px gray;display: inline-block;margin-left: 1px;margin-right: auto;">
				</div>
				<div class="col-sm-8">
					<p><h6 class="text-center" style="color:#0067B4; font-family: 'Arial Black';">TOTAL ACOPIADOS LACTEOS</h6>
						<p class="text-center" style="font-size: 20px;">120,000.00 KG</p>
					</p>
				</div>

			</div>
			<div class="desc">
				<div class="col-sm-4">
					<img src="img/naranja.jpg" alt="" style="height: 5vw; width: 5vw; border: 2px solid #fff;border-radius: 50%;box-shadow: 0 0 5px gray;display: inline-block;margin-left: 1px;margin-right: auto;">
				</div>
				<div class="col-sm-8">
					<p><h6 class="text-center" style="color:#0067B4; font-family: 'Arial Black';">TOTAL ACOPIADOS FRUTOS</h6>
						<p class="text-center" style="font-size: 20px;">150,000.00 KG</p>
					</p>
				</div>
			</div>
			<div class="desc">
				<div class="col-sm-4">
					<img src="img/quinua_eba.jpg" alt="" style="height: 5vw; width: 5vw; border: 2px solid #fff;border-radius: 50%;box-shadow: 0 0 5px gray;display: inline-block;margin-left: 1px;margin-right: auto;">
				</div>
				<div class="col-sm-8">
					<p><h6 class="text-center" style="color:#0067B4; font-family: 'Arial Black';">TOTAL ACOPIADOS QUINUA</h6>
						<p class="text-center" style="font-size: 20px; color: red;">PENDIENTE</p>
					</p>
				</div>
			</div>
			
			
  	</div>
</div>            
@endsection
@push('scripts')
<script>	
	// SCRIPT ESTRELLAS
	var slice = [].slice;

	(function($, window) {
	  var Starrr;
	  window.Starrr = Starrr = (function() {
	    Starrr.prototype.defaults = {
	      rating: void 0,
	      max: 5,
	      readOnly: false,
	      emptyClass: 'fa fa-star-o',
	      fullClass: 'fa fa-star',
	      change: function(e, value) {}
	    };

	    function Starrr($el, options) {
	      this.options = $.extend({}, this.defaults, options);
	      this.$el = $el;
	      this.createStars();
	      this.syncRating();
	      if (this.options.readOnly) {
	        return;
	      }
	      this.$el.on('mouseover.starrr', 'a', (function(_this) {
	        return function(e) {
	          return _this.syncRating(_this.getStars().index(e.currentTarget) + 1);
	        };
	      })(this));
	      this.$el.on('mouseout.starrr', (function(_this) {
	        return function() {
	          return _this.syncRating();
	        };
	      })(this));
	      this.$el.on('click.starrr', 'a', (function(_this) {
	        return function(e) {
	          e.preventDefault();
	          return _this.setRating(_this.getStars().index(e.currentTarget) + 1);
	        };
	      })(this));
	      this.$el.on('starrr:change', this.options.change);
	    }

	    Starrr.prototype.getStars = function() {
	      return this.$el.find('a');
	    };

	    Starrr.prototype.createStars = function() {
	      var j, ref, results;
	      results = [];
	      for (j = 1, ref = this.options.max; 1 <= ref ? j <= ref : j >= ref; 1 <= ref ? j++ : j--) {
	        results.push(this.$el.append("<a id='estrella' href='#' />"));
	        // results.push(this.$el.append("<a id='estrella' href='#' ><img src='img/esferas/esfera_"+j+".png' width='75px'></a>"));
	      }
	      return results;
	    };

	    Starrr.prototype.setRating = function(rating) {
	      if (this.options.rating === rating) {
	        rating = void 0;
	      }
	      this.options.rating = rating;
	      this.syncRating();
	      return this.$el.trigger('starrr:change', rating);
	    };

	    Starrr.prototype.getRating = function() {
	      return this.options.rating;
	    };

	    Starrr.prototype.syncRating = function(rating) {
	      var $stars, i, j, ref, results;
	      rating || (rating = this.options.rating);
	      $stars = this.getStars();
	      results = [];
	      for (i = j = 1, ref = this.options.max; 1 <= ref ? j <= ref : j >= ref; i = 1 <= ref ? ++j : --j) {
	        results.push($stars.eq(i - 1).removeClass(rating >= i ? this.options.emptyClass : this.options.fullClass).addClass(rating >= i ? this.options.fullClass : this.options.emptyClass));
	      }
	      return results;
	    };

	    return Starrr;

	  })();
	  return $.fn.extend({
	    starrr: function() {
	      var args, option;
	      option = arguments[0], args = 2 <= arguments.length ? slice.call(arguments, 1) : [];
	      return this.each(function() {
	        var data;
	        data = $(this).data('starrr');
	        if (!data) {
	          $(this).data('starrr', (data = new Starrr($(this), option)));
	        }
	        if (typeof option === 'string') {
	          return data[option].apply(data, args);
	        }
	      });
	    }
	  });
	})(window.jQuery, window);
	// END SCRIPT ESTRELLAS
	$(document).ready(function() {
		<?php 
			use Illuminate\Support\Facades\DB;
			$eval_user = DB::table('public.evaluacion_sistema')->where('evalsis_id_usuario',Auth::user()->usr_id)->first();	

			if(!$eval_user){ ?>
    		$('#modal_encuesta').modal('show');
    	<?php } ?>
	});
	var valor_estrellas;
	$('#Estrellas').starrr({
		// rating:3,
		change:function(e,valor){
			// alert(valor);
			valor_estrellas = valor;
		}
	});

	$("#RegistrarEvaluacion").click(function(){
		console.log("Registrar Evaluacion");
		var primera_respuesta = $('input:radio[name=o1]:checked').val();
		var segunda_respuesta = $('input:radio[name=o2]:checked').val();
		var tercera_respuesta = $('input:radio[name=o3]:checked').val();
		var valoracion_estrellas = valor_estrellas;
		console.log('primera respuesta: '+primera_respuesta+', segunda respuesta: '+segunda_respuesta+', tercera respuesta: '+tercera_respuesta+', VALORACION: '+valoracion_estrellas);
		if (valoracion_estrellas == undefined) {
			swal("Por favor","Debe dar su valoracion","warning");
				
		}else{
			// swal("Muchas Gracias","Esto ayudara para el mejoramiento del sistema","success")
			var route="RegistroEvalSistema";
			var token =$("#token").val();
			$.ajax({
				url: route,
				headers: {'X-CSRF-TOKEN': token},
				type: 'POST',
				dataType: 'json',
				data: {
					'primera_respuesta':primera_respuesta,
					'segunda_respuesta':segunda_respuesta,
					'tercera_respuesta':tercera_respuesta,
					'valoracion':valoracion_estrellas,								
                },
				success: function(data){
					console.log(data);
					$("#modal_encuesta").modal('toggle');
					swal({ 
                           title: "Muchas Gracias",
                           text: "Esto ayudará para el mejoramiento del sistema",
                           type: "success" 
                        },function(){
                           location.reload();
                    });
				},
				error: function(result)
				{
					swal("Opss..!", "Error al registrar el dato", "error");
				}
			});	
		}

	});
	
</script>
@endpush
<!-- <div class="modal fade" id="modal_encuesta" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
    
      
      <div class="modal-content">
        <div class="modal-header" style="background: #0067b4">
          
          <h4 class="modal-title text-center">EVALUADOR DE SISTEMA - SIGA</h4>
        </div>
        <div class="modal-body">
            <form action="/action_page.php">
              <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
			  <div class="form-group">
			    <label><h4><strong>¿El sistema es de facil uso?</strong></h4></label>
			    <div class="form-inline">
			    	<h4>
					<div class="radio col-md-4">
					  <label>
					   <input type="radio" name="o1" value="SI" id="respuesta1" checked>
					   <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
					   Si
					   </label>
					</div>
					<div class="col-md-2"></div>
					<div class="radio col-md-4">
					  <label>
					   <input type="radio" name="o1" value="NO" id="respuesta1">
					   <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
					   No
					   </label>
					</div>
					</h4>
				</div>
			  </div>
			  <div class="form-group">
			    <label><h4><strong>¿El sistema es de facil uso?</strong></h4></label>
			    <div class="form-inline">
			    	<h4>
					<div class="radio col-md-4">
					  <label>
					   <input type="radio" name="o2" value="SI" id="respuesta1" checked>
					   <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
					   Si
					   </label>
					</div>
					<div class="col-md-2"></div>
					<div class="radio col-md-4">
					  <label>
					   <input type="radio" name="o2" value="NO" id="respuesta1">
					   <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
					   No
					   </label>
					</div>
					</h4>
				</div>
			  </div>
			  <div class="form-group">
			    <label><h4><strong>¿El sistema es de facil uso?</strong></h4></label>
			    <div class="form-inline">
			    	<h4>
					<div class="radio col-md-4">
					  <label>
					   <input type="radio" name="o3" value="SI" checked>
					   <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
					   Si
					   </label>
					</div>
					<div class="col-md-2"></div>
					<div class="radio col-md-4">
					  <label>
					   <input type="radio" name="o3" value="NO">
					   <span class="cr"><i class="cr-icon fa fa-circle"></i></span>
					   No
					   </label>
					</div>
					</h4>
				</div>
			  </div>
			  <div class="text-center">
				  <div class="form-group">
				  	<label><h4><strong>CUANTO DE ESTRELLITAS LE DAS AL SISTEMA SIGA</strong></h4></label>
				  		
				     	  	<h1 style="font-size: 80px;"><div id="Estrellas"></div></h1>
				     	  
		     	  </div>
	     	  </div>
	     	  
			  
			</form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-lg" id="RegistrarEvaluacion">Enviar mi Evaluación</button>
          <button type="button" class="btn btn-warning btn-lg" data-dismiss="modal" id="NoEvaluar">Evaluar más tarde</button>
        </div>
      </div>
      
    </div>
</div> -->
<style>
.checkbox label:after,
.radio label:after {
  content: '';
  display: table;
  clear: both;
}

.checkbox .cr,
.radio .cr {
  position: relative;
  display: inline-block;
  border: 1px solid #a9a9a9;
  border-radius: .25em;
  width: 1.3em;
  height: 1.3em;
  float: left;
  margin-right: .5em;
}

.radio .cr {
  border-radius: 50%;
}

.checkbox .cr .cr-icon,
.radio .cr .cr-icon {
  position: absolute;
  font-size: .8em;
  line-height: 0;
  top: 50%;
  left: 20%;
}

.radio .cr .cr-icon {
  margin-left: 0.04em;
}

.checkbox label input[type="checkbox"],
.radio label input[type="radio"] {
  display: none;
}

.checkbox label input[type="checkbox"]+.cr>.cr-icon,
.radio label input[type="radio"]+.cr>.cr-icon {
  opacity: 0;
}

.checkbox label input[type="checkbox"]:checked+.cr>.cr-icon,
.radio label input[type="radio"]:checked+.cr>.cr-icon {
  opacity: 1;
}

.checkbox label input[type="checkbox"]:disabled+.cr,
.radio label input[type="radio"]:disabled+.cr {
  opacity: .5;
}


/*STYLES ESTRELLAS */
.starrr {
  display: inline-block; 
}
.starrr a {
    font-size: 16px;
    padding: 0 1px;
    cursor: pointer;
    color: #FFD119;
    /*color: yellow !important;*/
    text-decoration: none; 
}
#estrella{
	color: #EECF0A;
}
/*END STYLE ESTRELLAS*/
</style>