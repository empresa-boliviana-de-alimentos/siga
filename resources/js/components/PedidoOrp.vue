<template>

<div class="row">
    <div class="col-md-3">
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-sm-12">
                    <label>
                        Producto:
                    </label>
                    <Select2 v-model="receta_id"
                        :options="recetas"
                        @change="populateList($event)"
                        />
                    <input type="hidden" name="receta_id" :value="receta_id">
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-sm-12">
                    <label>
                        Planta a Producir:
                    </label>
                    <span class="block input-icon input-icon-right">

                        <Select2 v-model="planta_id"
                        :options="lista_plantas"
                      	 />
                    </span>
                    <input type="hidden" name="planta_id" :value="planta_id">
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-sm-12">
                    <label>
                        Mercado:
                    </label>
                    <span class="block input-icon input-icon-right">

                        <Select2 v-model="mercado_id"
                        :options="lista_mercados"
                      	 />
                    </span>
                    <input type="hidden" name="mercado_id" :value="mercado_id">
                </div>
            </div>
        </div>
        <div class="col-md-12" v-if="receta">
            <div class="form-group">
                <div class="col-sm-12">
                    <label>
                        Rendimiento Base:
                    </label>
                    <span class="block input-icon input-icon-right">
                        <input type="" name="rece_rendimiento_base" class="form-control" v-model="receta.rece_rendimiento_base" readonly="true">
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-sm-12">
                    <label>
                        Cantidad a Producir:
                    </label>
                    <span class="block input-icon input-icon-right">
                    	<input type="" name="cantidad_producir" class="form-control" v-model="cantidad_producir">
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-sm-12">
                    <label>
                        Cantidad a Esperada:
                    </label>
                    <span class="block input-icon input-icon-right">
                        <input type="" name="cantidad_esperada" class="form-control" v-model="cantidad_esperada">
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-sm-12">
                    <label>
                        Tiempo a Producir:
                    </label>
                    <span class="block input-icon input-icon-right">
                        <input type="" name="tiempo_producir" class="form-control" v-model="tiempo_producir">
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-12">
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
  <div class="col-md-9">
    <div class="row" v-if="receta">
        <div class="col-md-12" v-if="receta.rece_lineaprod_id==1 || receta.rece_lineaprod_id == 4 || receta.rece_lineaprod_id == 5">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">FORMULACION DE LA BASE</h3>
                </div>
            </div>
            <div class="panel-body">
                <insumo-orp :lista="formulacion_base" :cantidad="cantidad_pedido" nombre="formulaciones_base" :planta="planta_id"></insumo-orp>
            </div>
        </div>
        <div class="col-md-12" v-if="receta.rece_lineaprod_id==2 || receta.rece_lineaprod_id == 3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">MATERIA PRIMA</h3>
                </div>
            </div>
            <div class="panel-body">
                <insumo-orp :lista="materia_prima" :cantidad="cantidad_pedido" nombre="materias_prima" :planta="planta_id"></insumo-orp>
            </div>
        </div>
        <div class="col-md-12" v-if="receta.rece_lineaprod_id==1 || receta.rece_lineaprod_id == 4 || receta.rece_lineaprod_id == 5">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">SABORIZACIÓN</h3>
                </div>
            </div>
            <div class="panel-body">
                <insumo-orp :lista="saborizaciones" :cantidad="cantidad_pedido" nombre="saborizaciones" :planta="planta_id"></insumo-orp>
            </div>
        </div>
        <div class="col-md-12" v-if="receta.rece_lineaprod_id==1 || receta.rece_lineaprod_id == 2 || receta.rece_lineaprod_id == 4 || receta.rece_lineaprod_id == 5">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">MATERIAL DE ENVASADO</h3>
                </div>
            </div>
            <div class="panel-body">
                <insumo-orp :lista="envasados" :cantidad="cantidad_pedido" nombre="envasados" :planta="planta_id"></insumo-orp>
            </div>
        </div>
    </div>
</div>
</div>
</template>
<script>
	import Select2 from 'v-select2-component';
import { constants } from 'crypto';
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
            planta_id: {},
            mercado_id:{},
            formulacion_base:[],
            materia_prima:[],
            saborizaciones:[],
            envasados:[],
            cantidad_producir:0,
            cantidad_pedido:0,
            cantidad_esperada:0,
            tiempo_producir:0,

    	}),
    	methods: {
    		async calcularCantidad(){
                this.cantidad_pedido = 0;
                if(this.receta)
                {
                    this.cantidad_pedido = parseFloat(this.cantidad_producir)  /  parseFloat( this.receta.rece_rendimiento_base);
                    console.log(this.cantidad_pedido);


                    Promise.all(this.formulacion_base.map(({ ins_id })=>{
                       return  axios.get('StockActualOP/'+ins_id+'/'+this.planta_id)
                                    .then(response=>{ return response.data });

                    })).then(values=>{

                        this.formulacion_base.forEach(item => {
                            let insumo = _.find(values, (o) =>{ return o.ins_id == item.ins_id; });

                                item.stock = insumo.stock_cantidad;
                            return item;

                        });

                    });

                    Promise.all(this.formulacion_base.map(({ ins_id })=>{
                       return  axios.get('StockActualOP/'+ins_id+'/'+this.planta_id)
                                    .then(response=>{ return response.data });

                    })).then(values=>{

                        this.materia_prima.forEach(item => {
                            let insumo = _.find(values, (o) =>{ return o.ins_id == item.ins_id; });

                                item.stock = insumo.stock_cantidad;
                            return item;

                        });

                    });

                    Promise.all(this.saborizaciones.map(({ ins_id })=>{
                       return  axios.get('StockActualOP/'+ins_id+'/'+this.planta_id)
                                    .then(response=>{ return response.data });

                    })).then(values=>{

                        this.materia_prima.forEach(item => {
                            let insumo = _.find(values, (o) =>{ return o.ins_id == item.ins_id; });

                                item.stock = insumo.stock_cantidad;
                            return item;

                        });

                    });

                    Promise.all(this.envasados.map(({ ins_id })=>{
                       return  axios.get('StockActualOP/'+ins_id+'/'+this.planta_id)
                                    .then(response=>{ return response.data });

                    })).then(values=>{

                        this.materia_prima.forEach(item => {
                            let insumo = _.find(values, (o) =>{ return o.ins_id == item.ins_id; });

                                item.stock = insumo.stock_cantidad;
                            return item;

                        });

                    });



                    // console.log(new_formulacion_base);
                    // this.materia_prima.forEach(item => {
                    //     item.cant_cal = cantidad_pedido;
                    //     this.$set(userProfile, 'age', 27)
                    //     console.log(item);
                    //     return item;
                    // });

                    // this.formulacion_base.forEach(async item => {
                    //     // console.log(item);
                    //     let res = await axios.get('StockActualOP/'+item.ins_id+'/'+this.planta_id);
                    //     // console.log(res.data.stock_cantidad);
                    //     item.stock = 30;
                    // });


                    // for (var i = this.formulacion_base.length - 1; i >= 0; i--) {
                    // console.log(this.formulacion_base[i]);
                    // axios.get('StockActualOP/'+this.formulacion_base[i].ins_id+'/'+this.planta_id)
                    //  .then((response)=>{
                    //      console.log(response.data);
                    //     //this.formulacion_base[i].stock = response.data.stock_cantidad;
                    //     let item = this.formulacion_base[i]
                    //     item.stock = response.data.stock_cantidad;
                    //     Object.assign(this.formulacion_base[i], item);
                    //  });
                    //  }
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
                axios.get('getDataDetReceta?rece_id='+id+'&tipo=3')
                     .then((response)=>{
                        // console.log(response.data);
                        this.formulacion_base = response.data;
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
