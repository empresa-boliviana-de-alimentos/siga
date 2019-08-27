<template>
	<div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <div class="col-sm-12">
                    <label>
                        Producto:
                    </label>
                    <Select2 v-model="receta"
                        :options="recetas"
                        @change="myChangeEvent($event)"
                        @select="mySelectEvent($event)" />
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="col-sm-12">
                    <label>
                        Planta a Producir:
                    </label>
                    <span class="block input-icon input-icon-right">
                        
                        <Select2 v-model="planta"
                        :options="lista_plantas"
                      	 />
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="col-sm-12">
                    <label>
                        Mercado:
                    </label>
                    <span class="block input-icon input-icon-right">
                        
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="col-sm-12">
                    <label>
                        Rendimiento Base:
                    </label>
                    <span class="block input-icon input-icon-right">
                        <input type="" name="">
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="col-sm-12">
                    <label>
                        Cantidad a Producir:
                    </label>
                    <span class="block input-icon input-icon-right">
                    	<input type="" name="">
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="col-sm-12">
                    <label>
                        Cantidad a Esperada:
                    </label>
                    <span class="block input-icon input-icon-right">
                        <input type="" name="">
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="col-sm-12">
                    <label>
                        Tiempo a Producir:
                    </label>
                    <span class="block input-icon input-icon-right">
                        <input type="" name="">
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="col-sm-12">
                    <label style="color:white">
                    .
        	        </label>
        	        <span class="block input-icon input-icon-right">
                    	<a class="form-control btn btn-primary" id="botonCalculos">Calcular</a>
                    	<input type="hidden" name="" id="id_recetaAux">
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
	import Select2 from 'v-select2-component';
	export default
    {
    	props: ['plantas','mercados'],
    	data: ()=>({
    		items: [{ins_codigo:0,ins_desc:'leche',umed:'litros',cant_base: 0,cant_cal:10,cant_por:0,cant_eor:0,stock:0,cant_ent:0},{ins_codigo:0,ins_desc:'leche',umed:'litros',cant_base: 0,cant_cal:0,cant_por:0,cant_eor:0,stock:0,cant_ent:0}],
    		recetas: [],
    		receta: {},
    		lista_plantas: [],
    		planta: {},
    	}),
    	methods: {
    		calcularEor(item)
    		{
    			item.cant_eor = item.cant_cal*item.cant_por/100; 
    			return item.cant_eor;
    		},
    		sumarCantEnt(item)
    		{
    			item.cant_ent = item.cant_cal+item.cant_cal*item.cant_por/100 
    			return item.cant_ent
    		},
    		myChangeEvent(val){
                console.log(val);
            },
            mySelectEvent({id, text, unit},index){
                // console.log({id, text,unit})
                //this.envasados[index].unit = unit;
                // console.log(this.envasados);
            }
    	},
    	mounted(){
    		console.log(this.plantas);
    		this.plantas.forEach(item => {
                this.lista_plantas.push({id:item.id_planta,text: item.nombre_planta});
            });
            //console.log(this.lista);
    		axios.get('getProducto')
			  .then((response)=>{
			    // handle success
			    console.log(response.data);
			    this.recetas=response.data
			  })
			  .catch((error)=> {
			    // handle error
			    console.log(error);
			  })
			  .finally(()=>{
			    // always executed
			  });
    	},
    	components: {Select2}, 
    }
</script>