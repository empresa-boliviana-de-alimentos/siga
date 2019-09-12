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
                <th class="text-center" style="background-color:#428bca; color:white">#</th>
                <th class="text-center" style="background-color:#428bca; color:white">DESCRIPCIÓN</th>
                <th class="text-center" style="background-color:#428bca; color:white">UNIDAD MEDIDA</th>
                <th class="text-center" style="background-color:#428bca; color:white">CANTIDAD SOLICITAR</th>
                <th class="text-center" style="background-color:#428bca; color:white">LINEA</th>
                <th class="text-center" style="background-color:#428bca; color:white">OPCIÓN</th>
            </tr>
            </thead>

            <tr  v-for="(producto,index) in productos" :key="index">
                <td style="width:10%">
                    <input type="" name="" class="form-control" :value="index+1" readonly>
                </td>
                <td style="width:40%">
                    <Select2 v-model="producto.id"
                        :options="options"

                        @change="myChangeEvent($event)"
                        @select="mySelectEvent($event,index)" style="width:100%" />
                </td>
                <td style="width:20%">
                    <input type="" name="" class="form-control" :value="producto.id?producto.unit:''"  readonly  >
                </td>                
                <td style="width:10%"><input type="text" v-model="producto.cantidad" name="cantidad_envase[]" class="form-control"></td>
                <td style="width:10%">
                    <input type="" name="" class="form-control" :value="producto.id?producto.linea_prod:''"  readonly  >
                </td>
                <td style="width:10%"><div class="text-center"><a href='#' @click="removeItem(index)" class='btncirculo btn-md btn-danger'><i class="glyphicon glyphicon-trash"></i></a></div></td>
                <td>
                    <input type="hidden" name="prod_nombre" :value="producto.id?producto.prod_nombre:''" class="form-control">
                </td>
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
            productos:[],
            options:[],
            myOptions: [{id:1, text: "op1"}, {id:2, text: "op2"}, {id:3, text: "op3"}],
            myValue: '',
        }),

        mounted() {

            this.lista.forEach(item => {
                if (item.sab_id != 1) {
                    this.options.push({id:item.prod_id,text: item.prod_codigo+'-'+item.rece_nombre+' '+item.sab_nombre, unit: item.umed_nombre, linea_prod: item.rece_lineaprod_id, prod_nombre: item.rece_nombre});
                }else{
                    this.options.push({id:item.prod_id,text: item.prod_codigo+'-'+item.rece_nombre, unit: item.umed_nombre, linea_prod: item.rece_lineaprod_id, prod_nombre: item.rece_nombre});
                }
                
            });
            console.log(this.lista);
        },
        methods:{
            addItem()
            {
                this.productos.push({});
            },
            removeItem(index)
            {
                this.productos.splice(index, 1)
                console.log(index);
            },


            myChangeEvent(val){
                console.log(val);
            },
            mySelectEvent({id, text, unit, linea_prod, prod_nombre},index){
                this.productos[index].unit = unit;
                this.productos[index].linea_prod = lineaNombre(linea_prod);
                this.productos[index].prod_nombre = prod_nombre;
            }
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
