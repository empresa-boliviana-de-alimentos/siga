<template>
<div class="row">
    <div class="col-md-12">
        <div class="text-right">
        <a href="#" style="font-size:18px;" @click="addItem()" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Añadir
        </a>
        </div>
        <table  class="table small-text" >
            <thead>
            <tr >
                <th class="col-md6">Descripcion</th>
                <th class="col-md2">Unidad</th>
                <th class="col-md2">Cantidad</th>
                <th class="col-md2">Opcion</th>
            </tr>
            </thead>

            <tr  v-for="(envasado,index) in envasados" :key="index">
                <td >
                    <Select2 v-model="envasado.descripcion"
                        :options="options"

                        @change="myChangeEvent($event)"
                        @select="mySelectEvent($event,index)" />
                <td>
                    <input type="" name="" class="form-control" :value="envasado.descripcion?envasado.unit:''"  readonly  >
                </td>
                <td><input type="text" v-model="envasado.cantidad" name="cantidad_envase[]" class="form-control"></td>
                <td><div class="text-center"><a href='#' @click="removeItem()" class='btncirculo btn-md btn-danger'><i class="glyphicon glyphicon-trash"></i></a></div></td>
            </tr>
        </table>
        <input type="text" name="envasados" :value="JSON.stringify(envasados)">

    </div>
</div>

</template>

<script>
    import Select2 from 'v-select2-component';
    export default
    {
        props:['lista'],
        data:()=>({
            envasados:[],
            options:[],
        }),

        mounted() {
            console.log('select Component')
            this.lista.forEach(item => {
                this.options.push({id:item.ins_id,text: item.ins_codigo+'-'+item.ins_desc, unit: item.unidad_medida.umed_nombre});
            });
            console.log(this.lista);
        },
        methods:{
            addItem()
            {
                this.envasados.push({});
            },
            removeItem(index)
            {
                this.envasados.splice(index,1);
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
