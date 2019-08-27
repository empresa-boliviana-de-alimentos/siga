<template>
<div>
	<div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <div class="col-sm-12">
                    <label>
                        Producto:
                    </label>
                    <Select2 v-model="receta_id"
                        :options="recetas"
                        @change="populateList($event)"
                        />
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

                        <Select2 v-model="mercado"
                        :options="lista_mercados"
                      	 />
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-6" v-if="receta">
            <div class="form-group">
                <div class="col-sm-12">
                    <label>
                        Rendimiento Base:
                    </label>
                    <span class="block input-icon input-icon-right">
                        <input type="" class="form-class" v-model="receta.rece_rendimiento_base">
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
                    	<input type="" name="" class="form-class" v-model="cantidad_producir">
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
                        <input type="" name="" class="form-class">
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
                        <input type="" name="" class="form-class">
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
                    	<a class="form-control btn btn-primary" @click="calcularCantidad()" >Calcular</a>
                    	<input type="hidden" name="" id="id_recetaAux" >
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row" v-if="receta">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">MATERIA PRIMA</h3>
                </div>
            </div>
            <div class="panel-body">
                <insumo-orp :lista="materia_prima" :cantidad="cantidad_pedido"></insumo-orp>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">SABORIZACIÓN</h3>
                </div>
            </div>
            <div class="panel-body">
                <insumo-orp :lista="saborizaciones" :cantidad="cantidad_pedido"></insumo-orp>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">MATERIAL DE ENVASADO</h3>
                </div>
            </div>
            <div class="panel-body">
                <insumo-orp :lista="envasados" :cantidad="cantidad_pedido"></insumo-orp>
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
            receta: null,
            receta_id:null,
    		lista_plantas: [],
    		lista_mercados: [],
            planta: {},
            mercado:{},
            materia_prima:[],
            saborizaciones:[],
            envasados:[],
            cantidad_producir:0,
            cantidad_pedido:0,

    	}),
    	methods: {
    		calcularCantidad(){
                this.cantidad_pedido = 0;
                if(this.receta)
                {
                    this.cantidad_pedido = parseFloat(this.cantidad_producir)  /  parseFloat( this.receta.rece_rendimiento_base);
                    console.log(this.cantidad_pedido);

                    // this.materia_prima.forEach(item => {
                    //     item.cant_cal = cantidad_pedido;
                    //     this.$set(userProfile, 'age', 27)
                    //     console.log(item);
                    //     return item;
                    // });
                }

            },
            populateList(id){
                console.log(id);

                axios.get('getDataReceta?rece_id='+id)
                     .then((response)=>{
                        console.log(response.data);
                        this.receta = response.data;
                        // this.materia_prima = response.data;

                     });
                axios.get('getDataDetRecetaInsPrima?rece_id='+id)
                     .then((response)=>{
                        // console.log(response.data);
                        this.materia_prima = response.data;

                     });
                //
                axios.get('getDataDetReceta?rece_id='+id+'&tipo=4')
                     .then((response)=>{
                        // console.log(response.data);
                        this.saborizaciones = response.data;
                     });
                axios.get('getDataDetReceta?rece_id='+id+'&tipo=2')
                     .then((response)=>{
                        // console.log(response.data);
                        this.envasados = response.data;
                     });


            },
    		// myChangeEvent(val){
            //     console.log(val);
            // },
            // mySelectEvent(item){
            //     // console.log({id, text,unit})
            //     // this.receta = this.recetas[index];
            //     // this.envasados[index].unit = unit;
            //     console.log(item);
            // }
    	},
        mounted()
        {

    		this.plantas.forEach(item => {
                this.lista_plantas.push({ id:item.id_planta, text: item.nombre_planta});
            });
            console.log(this.mercados);
    		this.mercados.forEach(item => {
                this.lista_mercados.push({ id:item.mer_id, text: item.mer_nombre});
            });

    		axios.get('getProducto')
			  .then((response)=>{

                this.recetas=response.data
                console.log(this.recetas);
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
