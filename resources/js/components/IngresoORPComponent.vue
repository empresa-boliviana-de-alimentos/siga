<template>
<div class="row">
    <div class="col-md-12">
        <div v-if="vistaIngreso==true">
            <div class="box">
                <div class="box-header with-border">
                    <button type="button" class="btn btn-primary" @click="renderIngreso">REGISTRAR</button>
                </div>
                <div class="box-body">
                   <vue-bootstrap4-table :rows="rows" :columns="columns" :config="config">
                      <template slot="sort-asc-icon">
                          <i class="fa fa-sort-asc"></i>
                      </template>
                      <template slot="sort-desc-icon">
                          <i class="fa fa-sort-desc"></i>
                      </template>
                      <template slot="no-sort-icon">
                          <i class="fa fa-sort"></i>
                      </template>
                      <template slot="ctl_foto_canastillo" slot-scope="props">
                          <img v-bind:src="'/archivo/canastillo/' + props.row.ctl_foto_canastillo" style="height: 3vw; width: 3vw; border: 2px solid #fff;border-radius: 50%;box-shadow: 0 0 5px gray;display: inline-block;margin-left: auto;margin-right: auto;">
                      </template>
                    </vue-bootstrap4-table>
                </div>
                <div class="box-footer clearfix">
                </div>
            </div>
        </div>

        <div v-else>
            <div class="row">
                <div class="col-md-7">
                    <div class="box">
                        <div class="box-header with-border">
                            INGRESO CANASTILLOS    <button type="button" class="btn btn-sm btn-xs btn-danger" @click="retornar">Volver</button>
                        </div>
                        <div class="box-body"> 
                            <table class="table table-hover table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>Nro</th>
                                        <th>Canastilla</th>
                                        <th>Producto</th>
                                        <th>Codigo</th>
                                        <th>Transporte</th>
                                        <th>Foto</th>
                                        <th>Cantidad</th>
                                        <th>Agregar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item,index) in canastilla" :key="index">
                                        <td>{{index+1  }}</td>
                                        <td>{{item.ctl_descripcion}}</td>
                                        <td>{{item.rece_nombre}} {{ item.rece_presentacion }} </td>
                                        <td>{{item.ctl_codigo}}</td>
                                        <td>{{item.ctl_transporte}}</td>
                                        <td><img v-bind:src="'/archivo/canastillo/' + item.ctl_foto_canastillo" style="height: 3vw; width: 3vw; border: 2px solid #fff;border-radius: 50%;box-shadow: 0 0 5px gray;display: inline-block;margin-left: auto;margin-right: auto;"></td>
                                        <td><input type="number" v-model="item.cantidad_stock"></td>
                                        <td><button type="button" class="btn-round btn-xs btn-theme03" @click="agregarCarrito(item,index+1)"><i class="fa fa-plus fa-2x"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <div class="box-footer clearfix">
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="box">
                        <div class="box-header with-border">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                     <div class="text-left">
                                        STOCK DE CANASTILLAS 
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-right">
                                        <button type="button" class="btn btn-theme02 btn-sm btn-xs" data-toggle="modal" data-target="#myConfirmacion" @click="listarIngresosR"><b>Confirmar Insumo</b></button>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                        <div class="box-body"> 
                            <table class="table table-hover table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>Nro</th>
                                        <th>Canastilla</th>
                                        <th>Codigo</th>
                                        <th>Producto</th>
                                        <th>Foto</th>
                                        <th>Cantidad</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <tr v-for="(stock,index) in carrito" :key="index">
                                        <td>{{index+1  }}</td>
                                        <td>{{stock.ctl_descripcion}}</td>
                                        <td>{{stock.ctl_codigo}}</td>
                                        <td>{{stock.rece_nombre}} {{ stock.rece_presentacion }} </td>
                                        <td><img v-bind:src="'/archivo/canastillo/' + stock.ctl_foto_canastillo" style="height: 3vw; width: 3vw; border: 2px solid #fff;border-radius: 50%;box-shadow: 0 0 5px gray;display: inline-block;margin-left: auto;margin-right: auto;"></td>
                                        <td><input type="number" v-model="stock.cantidad_carrito" v-on:keyup="cambiarCantidad(stock,index)"></td>
                                        <td><button type="button" class="btn-round btn-xs btn-theme04" @click="eliminarCarrito(index)"><i class="fa fa-trash fa-2x"></i></button></td>
                                    </tr>
                                </tbody>

                            </table>

                        </div>
                        <div class="box-footer clearfix">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-default" data-backdrop="static" data-keyboard="false" id="myConfirmacion" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h4>
                                    Formulario de Registro (Canastillos a almacen):
                                </h4>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12 container-fluit">
                                    <form class="form-horizontal" id="canastillos">
                                        <input type="hidden" name="orprod_id" value="orprod_id" id="orprod_id">
                                        <div class="form-group">
                                            <label class="col-md-1" for="">
                                                Origen:
                                            </label>
                                            <div class="col-md-5">
                                                <div class="input-group">
                                                    <model-select :options="options"
                                                        v-model="item"
                                                        placeholder="seleccionar planta"
                                                        @change="seleccionPlanta(item)">
                                                    </model-select>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-search">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-md-1" for="">
                                                Chofer:
                                            </label>
                                            <div class="col-md-5">
                                                <div class="input-group">
                                                    <model-select :options="conductorOptions"
                                                        v-model="itemConductor"
                                                        placeholder="seleccionar conductor"
                                                        @change="seleccionConductor(itemConductor)">
                                                    </model-select>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-search">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <table class="table table-hover table-striped table-condensed">
                                                    <thead>
                                                        <tr>
                                                            <th>Nro</th>
                                                            <th>Descripcion</th>
                                                            <th>Codigo</th>
                                                            <th>Descripcion</th>
                                                            <th>Foto</th>
                                                            <th>Cantidad</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(stock,index) in listarCanasta" :key="index">
                                                            <td>{{index+1  }}</td>
                                                            <td>{{stock.rece_nombre}} {{ stock.rece_presentacion }} </td>
                                                            <td>{{stock.ctl_codigo}}</td>
                                                            <td>{{stock.ctl_transporte}}</td>
                                                            <td><img v-bind:src="'/archivo/canastillo/' + stock.ctl_foto_canastillo" style="height: 3vw; width: 3vw; border: 2px solid #fff;border-radius: 50%;box-shadow: 0 0 5px gray;display: inline-block;margin-left: auto;margin-right: auto;"></td>
                                                            <td>{{ stock.cantidad_carrito }}</td>                                                           
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>Total. {{ stock }}</td>
                                                        </tr>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-2" for="">
                                                Observacion:
                                            </label>
                                            <div class="col-md-10">
                                                <div class="input-group">
                                                   <textarea name="observacion" id="observacion" v-model="observacion" class="form-control" rows="2" required="required"></textarea>
                                                    <div class="input-group-addon">
                                                        <span class="fa fa-search">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal" type="button">
                    Cerrar
                </button>
                <button class="btn btn-success" @click="registrarIngresos();" type="button">
                    Guardar
                </button>
            </div>
        </div>
    </div>
</div>
</div>

</template>

<script>
    import VueBootstrap4Table from 'vue-bootstrap4-table';
    import { ModelSelect } from 'vue-search-select'
    export default
    {
        props:['user','conductor','planta'],
        data:()=>({
            vistaIngreso:true,
            canastilla:[],
            carrito:[],
            modelInsumo:{planta:0,conductor:0,data:{},observacion:''},
            stock:0,
            stockdemo:[],
            observacion:'',
            options: [],
            conductorOptions:[],
            listarCanasta:[],
            item: {
              prs_id: '',
              full_name: ''
            },
            itemConductor: {
              pcd_id: '',
              text: ''
            },
            rows: [],
            columns: [
                 {
                    label: "Nro ingreso",
                    name: "iac_nro_ingreso",
                    filter: {
                        type: "simple",
                        placeholder: "Nro Ingreso"
                    },
                    sort: false,
                },
                 {
                    label: "Fecha Ingreso",
                    name: "iac_fecha_ingreso",
                    filter: {
                        type: "simple",
                        placeholder: "Fecha Ingreso"
                    },
                    sort: false,
                },
                  {
                    label: "Planta",
                    name: "nombre_planta",
                    filter: {
                        type: "simple",
                        placeholder: "Nombre planta"
                    },
                    sort: false,
                },
                {
                    label: "Producto",
                    name: "producto",
                    filter: {
                        type: "simple",
                        placeholder: "Producto"
                    },
                    sort: false,
                },
                {
                    label: "Canastilla",
                    name: "ctl_descripcion",
                    filter: {
                        type: "simple",
                        placeholder: "Canastilla"
                    },
                    sort: false,
                },
                 {
                    label: "Material",
                    name: "ctl_material",
                    filter: {
                        type: "simple",
                        placeholder: "Material"
                    },
                    sort: false,
                },
                 {
                    label: "Foto Canastilla",
                    name: "ctl_foto_canastillo",
                    sort: false,
                },
                
                 {
                    label: "Cantidad",
                    name: "iac_cantidad",
                    filter: {
                        type: "simple",
                        placeholder: "Cantidad"
                    },
                    sort: false,
                },
                {
                    label: "Observacion",
                    name: "iac_observacion",
                    filter: {
                        type: "simple",
                        placeholder: "Observacion"
                    },
                    sort: false,
                },
                 {
                    label: "Conductor",
                    name: "conductor",
                    filter: {
                        type: "simple",
                        placeholder: "Conductor"
                    },
                    sort: false,
                },

               
            ],
            config: {
                card_mode: false,
                checkbox_rows: false,
                rows_selectable: false,
                global_search:  {
                        placeholder:  "Enter custom Search text",
                        visibility: false,
                        case_sensitive:  false
                },
                show_refresh_button:  false,
                show_reset_button:  false,
            },
            //FIN GRILLA
        }),

        mounted() {
            console.log("planta",this.planta);
            console.log("conductor",this.conductor);

            this.getData();
            this.getDataCanastillos();
            var obj=[];
            var obj2=[];
            for (var i = 0; i < this.planta.length; i++) {
                obj.push({value:this.planta[i].id_planta,text:this.planta[i].nombre_planta})                
            }
            for (var i = 0; i < this.conductor.length; i++) {
                obj2.push({value:this.conductor[i].pcd_id,text:this.conductor[i].pcd_nombres+' '+this.conductor[i].pcd_paterno+' '+this.conductor[i].pcd_materno})                
            }
            this.options=obj;
            this.conductorOptions=obj2;
        },
        methods:{
            getData(){
              axios.get(`listarIngresoCanastillaG`)
                 .then((response)=>{
                  this.rows = response.data.data;
                  console.log(this.rows);
                 });
            },
            getDataCanastillos(){
                axios.get(`lstCanastilla`)
                 .then((response)=>{
                  this.canastilla = response.data.data;
                });
            },
            renderIngreso(){
                this.vistaIngreso=false;
            },
            retornar(){
                this.vistaIngreso=true;
            },
            addItem()
            {
                this.items.push({});
            },
            agregarCarrito(item,posicion){
                console.log("datos de empreas",posicion);
                item.cantidad_carrito=item.cantidad_stock;
                item.nro_ingreso=posicion;
                var eventoToast="caso1";
                console.log("carrito",item.cantidad_stock);
                if (item.cantidad_stock==null|| item.cantidad_stock==undefined) {
                    iziToast.warning({
                        position: 'topRight',
                        title: 'Ingrese la cantidad',
                        message: 'No ingreso la cantidad correspondiente' 
                    });
                }else{
                    if (this.carrito.length>0) {
                        for (var i = 0; i < this.carrito.length; i++) {
                            if (item.ctl_id==this.carrito[i].ctl_id) {
                                iziToast.error({
                                    position: 'topRight',
                                    title: 'Duplicado',
                                    message: 'Ya se selecciono una canastilla elija otro' 
                                });
                                eventoToast="caso2";
                            }else{
                            }
                        }
                        if (eventoToast=="caso2") {
                            eventoToast="caso1";
                        }else{
                            this.carrito.push(item);
                            iziToast.success({
                                position: 'bottomCenter',
                                title: 'Canastilla agregada carrito',
                                message: 'Se agrego correctamente canastillo en el carrito'
                            });
                            this.stock+=parseInt(item.cantidad_stock);
                        }
                    }else{
                        this.carrito.push(item);
                        iziToast.success({
                            position: 'bottomCenter',
                            title: 'Canastilla agregada carrito',
                            message: 'Se agrego correctamente canastillo en el carrito'
                        });
                        this.stock+=parseInt(item.cantidad_stock);
                    }         
                }
               
                
            },
            eliminarCarrito(posicion){
                this.carrito.splice(posicion, 1);
                iziToast.error({
                    position: 'topRight',
                    title: 'Eliminado',
                    message: 'Se elimino el canastillo del stock' 
                });
            },
            seleccionPlanta(param){
                console.log("aaa",params);
                this.modelInsumo.planta=param.value;
            },
            seleccionConductor(param){
                this.modelInsumo.conductor=param.value;
            },
            cambiarCantidad(params,posicion){
                console.log("data",params.cantidad_carrito);
                this.carrito[posicion].cantidad_carrito=params.cantidad_carrito;
                console.log("cantidad",this.carrito[posicion].cantidad_carrito);
                console.log("aaa",this.carrito[posicion]);
            },
            registrarIngresos(){
                console.log(this.item.value);
                this.modelInsumo.planta=this.item.value;
                this.modelInsumo.conductor=this.itemConductor.value;
                this.modelInsumo.data=this.carrito;
                this.modelInsumo.observacion=this.observacion;
                axios.post('registrarIngresoC',this.modelInsumo)
                .then((response)=>{
                    if (response.data.success=="true") {
                        this.getData();
                        iziToast.success({
                            position: 'bottomCenter',
                            title: 'Registrado',
                            message: 'Se realizo el ingreso correctamente ' 
                        });
                        this.modelInsumo={};
                        this.carrito=[];
                        $("#myConfirmacion").modal('toggle');
                        this.vistaIngreso=true;
                        this.getData();
                    }else{
                        iziToast.error({
                            position: 'topRight',
                            title: 'Error',
                            message: 'Error de registro intente nuevamente' 
                        });
                    }
                }).catch((error)=> {
                     iziToast.error({
                            position: 'topRight',
                            title: 'Error',
                            message: 'Error de registro intente nuevamente'+error 
                        });
                });
            },
            listarIngresosR(){
                this.listarCanasta=this.carrito;
            },
        },
        components: {
            VueBootstrap4Table,ModelSelect
        },
    }
</script>
