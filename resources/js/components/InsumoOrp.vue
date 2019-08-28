<template>
	<div class="row">

		<table class="table">
			<thead>
				<tr>
					<th>Cod Insumo</th>
					<th>Insumo</th>
					<th>Unidad Medida</th>
					<th>Cantidad Base</th>
					<th>Cantidad</th>
					<th>FC %</th>
					<th>FC EOR</th>
					<th>Stock</th>
					<th>Cant. Entregar</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(item,index) in items" :key="index">
					<td>{{item.ins_codigo}}</td>
					<td>{{item.ins_desc}}</td>
					<td>{{item.umed_nombre}}</td>
					<td>{{item.detrece_cantidad}}</td>
					<td>{{calcularCantidaPedido(item)}}</td>
					<td><input type="number" v-model="item.cant_por"></td>
					<td>{{calcularEor(item)}}</td>
					<td>{{item.stock}}</td>
					<td>{{sumarCantEnt(item)}}</td>
				</tr>
			</tbody>
		</table>

        <!-- este el campo por donde enviamos la lista el nombre lo colocas como props  cuanto se termine de guardar puedes adicionarle c la propiedad jhidden para que no se vea cuando se este registrando-->
        <input type="text" :name="nombre" :value="JSON.stringify(items)">

	</div>
</template>
<script>
	export default
    {
    	props: ['lista','cantidad','nombre'],
    	data: ()=>({
    		// items: [{ins_codigo:0,ins_desc:'leche',umed:'litros',cant_base: 0,cant_cal:10,cant_por:0,cant_eor:0,stock:0,cant_ent:0},{ins_codigo:0,ins_desc:'leche',umed:'litros',cant_base: 0,cant_cal:0,cant_por:0,cant_eor:0,stock:0,cant_ent:0}],
    	}),
        methods:
        {
            addItem()
            {
                this.items.push({});
            },
            calcularCantidaPedido(item){
                item.cant_cal = item.detrece_cantidad * this.cantidad_pedido;
                return item.cant_cal;
            },
    		calcularEor(item)
    		{
    			item.cant_eor = item.cant_cal*item.cant_por/100;
    			return item.cant_eor;
    		},
    		sumarCantEnt(item)
    		{
    			item.cant_ent = item.cant_cal+item.cant_cal*item.cant_por/100
    			return item.cant_ent
    		}
        },
        computed:{
            items(){
                return this.lista;
            },
            cantidad_pedido(){
                return this.cantidad;
            }
        },
        mounted()
        {
            console.log('cantidad');
        }
    }
</script>
