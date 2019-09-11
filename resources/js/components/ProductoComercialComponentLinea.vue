<template>
<div>
<div class="col-md-12">
    <div class="col-md-4">
        <label>
            Linea:
        </label>
                        
        <Select2 v-model="linea.id"
                            :options="lineas" 
                            @change="cambioLinea($event)"
                            />
    </div>
    <div class="col-md-4">
        <label>
            Solicitante:
        </label>
        <input type="" name="" class="form-control" value="RENE VALVERDE" readonly>
    </div>
    <div class="col-md-4">
        <label>
            Fecha Posible Entrega:
        </label>
        <div class="input-group date" data-provide="datepicker">
            <input type="text" class="form-control">
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <h4><strong>DETALLE SOLICITUD</strong></h4>
</div> 
<div class="row">
    <lista-productolineacomercial :lista="products" nombre="productos"></lista-productolineacomercial>
</div>
</div>


</template>

<script>
    import Select2 from 'v-select2-component';
    export default
    {
        
        data:()=>({
            value: { name: 'Vue.js', language: 'JavaScript' },
            options: [
            { name: 'Vue.js', language: 'JavaScript' },
            { name: 'Rails', language: 'Ruby' },
            { name: 'Sinatra', language: 'Ruby' },
            { name: 'Laravel', language: 'PHP' },
            { name: 'Phoenix', language: 'Elixir' }
            ],
            myOptions: [{id:1, text: "op1"}, {id:2, text: "op2"}, {id:3, text: "op3"}],
            myValue: '',
            lineas :[{id:1, text: 'Lacteos'},{id:2, text: 'almendra'},{id:3, text: 'Miel'},{id:4, text:'Frutos'},{id:5, text:'Derivados'}],
            linea: {},
            products:[],
        }),

        mounted() {

                    },
        methods:{
            
            cambioLinea(val)
            {
                //console.log(val);
                axios.get('getProductoLinea?linea_id='+val)
                     .then((response)=>{
                        console.log(response.data);
                        //this.products = response.data;
                        this.products = [];
                        response.data.forEach(item => {
                if (item.sab_id == 1) {
                    this.products.push({id:item.rece_id,text: item.prod_codigo+'-'+item.rece_nombre+' '+item.rece_presentacion, unit: item.umed_nombre, linea_prod: item.rece_lineaprod_id});
                }else{
                    this.products.push({id:item.rece_id,text: item.prod_codigo+'-'+item.rece_nombre+' '+item.sab_nombre+' '+item.rece_presentacion, unit: item.umed_nombre, linea_prod: item.rece_lineaprod_id});
                }
                
            });
                });
            }            

        },
        components: {Select2},
    }

</script>
