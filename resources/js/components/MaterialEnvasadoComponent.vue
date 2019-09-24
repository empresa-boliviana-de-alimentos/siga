<template>
<div class="row">
    <div class="col-md-12">
        <div class="text-right">
        <a href="#" style="font-size:18px; background-color:#202040" @click="addItem()" title="Add More Person" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Añadir
        </a>
        </div>
        <table  class="table small-text" >
            <thead>
            <tr >
                <th >descripcion</th>
                <th >Unidad</th>
                <th >Cantidad</th>
                <th >Opcion</th>
            </tr>
            </thead>

            <tr  v-for="(envasado,index) in envasados" :key="index">
                <td >
                    <Select2 v-model="envasado.id"
                        :options="options"

                        @change="myChangeEvent($event)"
                        @select="mySelectEvent($event,index)" />
                <td>
                    <input type="" name="" class="form-control" :value="envasado.id?envasado.unit:''"  readonly  >
                </td>
                <td><input type="text" v-model="envasado.cantidad" name="cantidad_envase[]" class="form-control"></td>
                <td><div class="text-center"><a href='#' @click="removeItem()" class='btncirculo btn-md btn-danger'><i class="glyphicon glyphicon-trash"></i></a></div></td>
            </tr>
        </table>
        <input type="text" :name="nombre" :value="JSON.stringify(envasados)" hidden>

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
            envasados:[],
            options:[],
            myOptions: [{id:1, text: "op1"}, {id:2, text: "op2"}, {id:3, text: "op3"}],
            myValue: '',
        }),

        mounted() {

            this.lista.forEach(item => {
                if (item.sab_nombre) {
                    this.options.push({id:item.ins_id,text: item.ins_codigo+'-'+item.ins_desc+' '+item.sab_nombre, unit: item.unidad_medida.umed_nombre});
                }else{
                    this.options.push({id:item.ins_id,text: item.ins_codigo+'-'+item.ins_desc, unit: item.unidad_medida.umed_nombre});
                }
                
            });
            console.log(this.lista);
        },
        methods:{
            addItem()
            {
                this.envasados.push({});
            },
            removeItem(item)
            {
                //this.envasados.splice(item.index,1);
                const index = this.envasados.indexOf(item)
                this.envasados.splice(index, 1)
            },


            myChangeEvent(val){
                console.log(val);
            },
            mySelectEvent({id, text, unit},index){
                // console.log({id, text,unit})
                this.envasados[index].unit = unit;
                // console.log(this.envasados);
            }
        },
        components: {Select2},
    }
</script>
