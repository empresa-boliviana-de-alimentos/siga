<template>
<div class="row">
    <div class="col-md-12">
        <div class="text-right">
        <a href="#" style="font-size:18px;" @click="addItem()" title="Add More Person" class="btn btn-xs btn-primary"><i class="fa fa-plus"> Añadir</i>
        </a>
        </div>
        <table  class="table small-text" >
            <thead>
            <tr >
                <th>Descripcion</th>
                <th>Unidad</th>
                <th>Cantidad</th>
                <th>Opcion</th>
            </tr>
            </thead>

            <tr  v-for="(envasado,index) in envasados" :key="index">
                <td >

                    <multiselect
                        v-model="envasado.descripcion"
                        :options="lista" placeholder="Seleccionar"
                        label="name"
                        track-by="name"
                        :custom-label="customLabel"
                        ></multiselect>

                <td>
                    <input type="" name="" class="form-control" :value="envasado.descripcion?envasado.descripcion.unidad_medida.umed_nombre:''"  readonly  >
                </td>
                <td><input type="text" v-model="envasado.cantidad" name="cantidad_envase[]" class="form-control"></td>
                <td><div class="text-center"><a href='#' @click="removeItem()" class='btncirculo btn-md btn-danger'><i class="glyphicon glyphicon-trash"></i></a></div></td>
            </tr>
        </table>


    </div>
</div>

</template>

<script>
    export default
    {
        props:['lista'],
        data:()=>({
            value: { name: 'Vue.js', language: 'JavaScript' },
            options: [
            { name: 'Vue.js', language: 'JavaScript' },
            { name: 'Rails', language: 'Ruby' },
            { name: 'Sinatra', language: 'Ruby' },
            { name: 'Laravel', language: 'PHP' },
            { name: 'Phoenix', language: 'Elixir' }
            ],
            envasados:[]
        }),

        mounted() {
            console.log('select Component')
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
            customLabel ({ ins_codigo, ins_desc }) {
            return `${ins_codigo} - ${ins_desc}`
            }
        }
    }
</script>
