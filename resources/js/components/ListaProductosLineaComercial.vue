<template>

<div class="row">

    <div class="col-md-12">
        <div class="text-right">
        <a href="#" style="font-size:18px;" @click="addItem()" title="Add More Person" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Añadir
        </a>
        </div>
        <table  class="table small-text" >
            <thead>
            <tr >
                <th >#</th>
                <th >DESCRIPCIÓN</th>
                <th >UNIDAD MEDIDA</th>
                <th >CANTIDAD SOLICITAR</th>
                <th >CANT. TON</th>
                <th >OPCIÓN</th>
            </tr>
            </thead>

            <tr  v-for="(item,index) in items" :key="index">
                <td>
                    <input type="" name="" class="form-control" :value="index+1" readonly>
                </td>
                <td>
                    <Select2 v-model="item.id"
                        :options="productos"
                        @change="myChangeEvent($event)"
                        @select="mySelectEvent($event,index)" style="width:100%" />
                </td>
                <td>
                    <input type="" name="" class="form-control" :value="item.id?item.unit:''"  readonly  >
                </td>                
                <td>
                    <!--<input type="text" v-model="producto.cantidad" name="cantidad_envase[]" class="form-control">-->
                    <input type="number" v-model="item.cantidad">
                </td>
                <td>
                    <input type="" name="" :value="calculoTonelada(item)" class="form-control" readonly >
                    
                </td>
                <td><div class="text-center"><a href='#' @click="removeItem(index)" class='btncirculo btn-md btn-danger'><i class="glyphicon glyphicon-trash"></i></a></div></td>
            </tr>
            <tr>
                <td colspan="4">Total Toneladas Aprox:</td>
                <td><input type="" name="" :value="calculoTotalToneladas(productos)" class="form-control" readonly ></td>
            </tr>
        </table>
        <input type="text" :name="nombre" :value="JSON.stringify(productos)" hidden>

    </div>
</div>

</template>

<script>
    import Select2 from 'v-select2-component';
    export default
    {
        props:['lista','nombre'],
        data:()=>({
            value: { name: 'Vue.js', language: 'JavaScript' },
            options: [
            { name: 'Vue.js', language: 'JavaScript' },
            { name: 'Rails', language: 'Ruby' },
            { name: 'Sinatra', language: 'Ruby' },
            { name: 'Laravel', language: 'PHP' },
            { name: 'Phoenix', language: 'Elixir' }
            ],
            options:[],
            myOptions: [{id:1, text: "op1"}, {id:2, text: "op2"}, {id:3, text: "op3"}],
            myValue: '',
            lineas :[{id:1, text: 'Lacteos'},{id:2, text: 'almendra'},{id:3, text: 'Miel'},{id:4, text:'Frutos'},{id:5, text:'Derivados'}],
            linea: {},
            items: [],
        }),
        computed:
        {
            productos(){
                return this.lista;
            },

        },
        mounted() {
            console.log();
            
            
        },
        methods:{
            addItem()
            {
                this.items.push({});
            },
            removeItem(index)
            {
                this.items.splice(index, 1)
                //console.log(index);
            },


            myChangeEvent(val){
                //console.log(val);
            },
            mySelectEvent({id, text, unit, linea_prod},index){
                this.items[index].unit = unit;
                this.items[index].linea_prod = lineaNombre(linea_prod);
            },
            calculoTonelada(item)
            {
                //console.log("TONELADA");
                item.tonelada = item.cantidad*2;
                return item.tonelada;
            },
            calculoTotalToneladas(items)
            {
                //console.log(productos);
                //let cant_tonelada
                //return cant_tonelada = 10;
                var total_tonelada = 0;
                items.forEach(item => {
                   //console.log(item.tonelada);
                   total_tonelada = total_tonelada + parseFloat(item.tonelada||0);               
                });
                return total_tonelada;
            },            

        },
        components: {Select2},
    }

    function lineaNombre(id)
    {
        if (id == 1) {
            return "LACTEOS"
        }else if(id == 2){
            return "ALMENDRA";
        }else if(id == 3){
            return "MIEL";
        }else if(id == 4){
            return "FRUTOS";
        }else if(id == 5){
            return "DERIVADOS";
        }
    }
</script>
