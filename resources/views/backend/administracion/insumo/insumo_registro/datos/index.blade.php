@extends('backend.template.app')
<style type="text/css" media="screen">
        table {
    border-collapse: separate;
    border-spacing: 0 5px;
    }
    thead th {
      background-color:#202040;
      color: white;
      font-size: 12px;
    }
    tbody td {
      background-color: #EEEEEE;
      font-size: 10px;
    }
</style>
@section('main-content')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalCreateCat')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalCreateUni')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalCreatePart')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalCreateIng')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalCreateIns')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalCreateTipEnv')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalCreateMercado')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalCreateColor')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalCreateSabor')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalCreateLineaProd')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalCreateProdEsp')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalCreateMunicipio')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalCreateSubLinea')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalCreatePlantaMaquila')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalUpdateCat')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalUpdateUni')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalUpdatePart')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalUpdateIng')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalUpdateIns')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalUpdateTipEnv')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalUpdateMercado')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalUpdateColor')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalUpdateSabor')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalUpdateLineaProd')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalUpdateSubLinea')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalUpdateProdEsp')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalUpdateMunicipio')
@include('backend.administracion.insumo.insumo_registro.datos.partials.modalUpdatePlantaMaquila')
<div class="panel panel-primary">
    <div class="panel-heading" style="background-color: #202040">
        <div class="row">
            <div class="col-md-2">
                <a type="button" class="btn btn-danger fa fa-arrow-left" href="{{ url('InsumoRegistrosMenu') }}"></span><h7 style="color:#ffffff">&nbsp;&nbsp;VOLVER</h7></a>
            </div>
            <div class="col-md-7 text-center">
                <p class="panel-title">LISTA DE DATOS</p>
                <h5>
                    <strong>Elige el dato a registrar:</strong>  
                </h5>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <select class="form-control" id="cmblist" name="cmblist" placeholder="" value="" onchange="Lista();">
                        <option value="">Seleccione...</option>
                        <option value="1">PARTIDA</option>
                        <option value="2">CATEGORIA</option>
                        <option value="3">UNIDAD DE MEDIDA</option>
                        <option value="4">TIPO INGRESO</option>
                        <option value="5">TIPO INSUMO</option>
                        <option value="6">TIPO ENVASE</option>
                        <option value="7">MERCADO</option>
                        <option value="8">COLOR</option>
                        <option value="9">SABOR</option>
                        <option value="10">LINEA DE PRODUCCION</option>
                        <option value="11">SUB LINEA</option>
                        <option value="12">PRODUCTO ESPECIFICO</option>
                        <option value="13">MUNICIPIO</option>
                        <option value="14">PLANTAS MAQUILAS</option>
                    </select> </div>
                    <div class="col-md-3"></div>                    
                </div>
            </div>
            <div class="col-md-3 text-right">
            </div>
        </div>
    </div>
<br>
<div class="row">
    <div id="listcategoria" style="display: none;">
        <div class="col-md-2">
            <div class="form-group">
                <div class="col-sm-12">
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="form-group">
                <div class="col-sm-12">
                    <h4><center><label for="box-title">LISTA DE CATEGORIA</label></center></h4>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <div class="col-sm-12">
                    <button class="btn pull-right btn btn-info" data-target="#myCreateCat" data-toggle="modal"><h6 style="color:white;">+&nbsp;CATEGORIA</h6></button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border"></div>
                <div class="box-body">
                    <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-categoria" style="width:100%">
                        <thead class="cf">
                            <tr>
                                <th>#</th>                                
                                <th>NOMBRE</th>
                                <th>OPCIONES</th>
                                <!--<th>Partida</th>-->
                            </tr>
                        </thead>
                    </table>
                </div>    
            </div>
        </div>
    </div>
    <div id="listunidadmedida" style="display: none;">
        <div class="col-md-2">
            <div class="form-group">
                <div class="col-sm-12">
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="form-group">
                <div class="col-sm-12">
                    <h4><center><label for="box-title">LISTA DE UNIDAD DE MEDIDA</label></center></h4> 
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <div class="col-sm-12">
                    <button class="btn pull-right btn btn-warning"  data-target="#myCreateUni" data-toggle="modal"><h6 style="color:white;">+&nbsp;UNIDAD DE MEDIDA</h6></button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border"></div>
                <div class="box-body">
                    <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-unidadmedida" style="width:100%">
                        <thead class="cf">
                            <tr>
                                <th>#</th>                                
                                <th>NOMBRE</th>
                                <th>SIGLA</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>    
            </div>
        </div>
    </div>
    <div id="listpartida" style="display: none;">
        <div class="col-md-2">
            <div class="form-group">
                <div class="col-sm-12">
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="form-group">
                <div class="col-sm-12">
                    <h4><center><label for="box-title">LISTA DE PARTIDA</label></center></h4> 
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <div class="col-sm-12">
                    <button class="btn pull-right btn btn-success"  data-target="#myCreatePart" data-toggle="modal"><h6 style="color: white;">+&nbsp;PARTIDA</h6></button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border"></div>
                <div class="box-body">
                    <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-partida" style="width:100%">
                        <thead class="cf">
                            <tr>
                                <th>#</th>
                                <th>CODIGO PARTIDA</th>
                                <th>NOMBRE</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>    
            </div>
        </div>
    </div>
    <div id="listingreso" style="display: none;">
        <div class="col-md-2">
            <div class="form-group">
                <div class="col-sm-12">
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="form-group">
                <div class="col-sm-12">
                    <h4><center><label for="box-title">LISTA DE INGRESO</label></center></h4> 
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <div class="col-sm-12">
                    <button class="btn pull-right btn btn-danger"  data-target="#myCreateIng" data-toggle="modal"><h6 style="color: white;">+&nbsp;INGRESO</h6></button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border"></div>
                <div class="box-body">
                    <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-tipoingreso" style="width:100%">
                        <thead class="cf">
                            <tr>
                                <th>#</th>
                                <th>NOMBRE</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>    
            </div>
        </div>
    </div>
    <div id="listipoinsumo" style="display: none;">
        <div class="col-md-2">
            <div class="form-group">
                <div class="col-sm-12">
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="form-group">
                <div class="col-sm-12">
                    <h4><center><label for="box-title">LISTA TIPO INSUMO</label></center></h4> 
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <div class="col-sm-12">
                    <button class="btn pull-right btn btn-primary"  data-target="#myCreateIns" data-toggle="modal"><h6 style="color: white;">+&nbsp;TIPO INSUMO</h6></button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border"></div>
                <div class="box-body">
                    <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-tipoinsumo" style="width:100%">
                        <thead class="cf">
                            <tr>
                                <th>#</th> 
                                <th>NOMBRE</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>    
            </div>
        </div>
    </div>
    <div id="listipoenvase" style="display: none;">
        <div class="col-md-2">
            <div class="form-group">
                <div class="col-sm-12">
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="form-group">
                <div class="col-sm-12">
                    <h4><center><label for="box-title">LISTA TIPO ENVASE</label></center></h4> 
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <div class="col-sm-12">
                    <button class="btn pull-right btn btn-default" data-target="#myCreateTipEnv" data-toggle="modal" style="background: #70747d"><h6 style="color:white;">+&nbsp;TIPO ENVASE</h6></button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border"></div>
                <div class="box-body">
                    <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-tipoenvase" style="width:100%">
                        <thead class="cf">
                            <tr>
                                <th>#</th>
                                <th>NOMBRE</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>    
            </div>
        </div>
    </div>
    <div id="listmercado" style="display: none;">
        <div class="col-md-2">
            <div class="form-group">
                <div class="col-sm-12">
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="form-group">
                <div class="col-sm-12">
                    <h4><center><label for="box-title">LISTA MERCADO</label></center></h4>
                </div> 
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <div class="col-sm-12">
                    <button class="btn pull-right btn btn-default" data-target="#myCreateMercado" data-toggle="modal" style="background: #70747d"><h6 style="color:white;">+&nbsp;MERCADO</h6></button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border"></div>
                <div class="box-body">
                    <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-mercado" style="width:100%">
                        <thead class="cf">
                            <tr>
                                <th>#</th>
                                <th>NOMBRE</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>    
            </div>
        </div>
    </div>
    <div id="listcolor" style="display: none;">
        <div class="col-md-2">
            <div class="form-group">
                <div class="col-sm-12">
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="form-group">
                <div class="col-sm-12">
                    <h4><center><label for="box-title">LISTA COLOR</label></center></h4> 
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <div class="col-sm-12">
                    <button class="btn pull-right btn btn-default" data-target="#myCreateColor" data-toggle="modal" style="background: #70747d"><h6 style="color:white;">+&nbsp;COLOR</h6></button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border"></div>
                <div class="box-body">
                    <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-color" style="width:100%">
                        <thead class="cf">
                            <tr>
                                <th>#</th>
                                <th>NOMBRE</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>    
            </div>
        </div>
    </div>
    <div id="listsabor" style="display: none;">
        <div class="col-md-2">
            <div class="form-group">
                <div class="col-sm-12">
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="form-group">
                <div class="col-sm-12">
                    <h4><center><label for="box-title">LISTA SABOR</label></center></h4> 
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <div class="col-sm-12">
                    <button class="btn pull-right btn btn-default" data-target="#myCreateSabor" data-toggle="modal" style="background: #70747d"><h6 style="color:white;">+&nbsp;SABOR</h6></button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border"></div>
                <div class="box-body">
                    <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-sabor" style="width:100%">
                        <thead class="cf">
                            <tr>
                                <th>#</th>
                                <th>NOMBRE</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>    
            </div>
        </div>
    </div>
    <div id="listlinprod" style="display: none;">
        <div class="col-md-2">
            <div class="form-group">
                <div class="col-sm-12">
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="form-group">
                <div class="col-sm-12">
                    <h4><center><label for="box-title">LISTA LINEA DE PRODUCCION</label></center></h4> 
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <div class="col-sm-12">
                    <button class="btn pull-right btn btn-default" data-target="#myCreateLineaProd" data-toggle="modal" style="background: #70747d"><h6 style="color:white;">+&nbsp;LINEA PRODUCCION</h6></button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border"></div>
                <div class="box-body">
                    <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-linprod" style="width:100%">
                        <thead class="cf">
                            <tr>
                                <th>#</th>
                                <th>NOMBRE</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>    
            </div>
        </div>
    </div>
    <div id="listsublinea" style="display: none;">
        <div class="col-md-2">
            <div class="form-group">
                <div class="col-sm-12">
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="form-group">
                <div class="col-sm-12">
                    <h4><center><label for="box-title">LISTA SUB-LINEA</label></center></h4> 
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <div class="col-sm-12">
                    <button class="btn pull-right btn btn-default" data-target="#myCreateSubLinea" data-toggle="modal" style="background: #70747d"><h6 style="color:white;">+&nbsp;SUB-LINEA</h6></button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border"></div>
                <div class="box-body">
                    <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-sublinea" style="width:100%">
                        <thead class="cf">
                            <tr>
                                <th>#</th>
                                <th>NOMBRE</th>
                                <th>LINEA PRODUCCIÓN</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>    
            </div>
        </div>
    </div>
    <div id="listprodesp" style="display: none;">
        <div class="col-md-2">
            <div class="form-group">
                <div class="col-sm-12">
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="form-group">
                <div class="col-sm-12">
                    <h4><center><label for="box-title">LISTA PRODUCTO ESPECIFICO</label></center></h4>
                </div> 
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <div class="col-sm-12">
                    <button class="btn pull-right btn btn-default" data-target="#myCreateProdEsp" data-toggle="modal" style="background: #70747d"><h6 style="color:white;">+&nbsp;PRODUCTO ESPECIFICO</h6></button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border"></div>
                <div class="box-body">
                    <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-prodesp" style="width:100%">
                        <thead class="cf">
                            <tr>
                                <th>#</th>
                                <th>NOMBRE</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>    
            </div>
        </div>
    </div>
    <div id="listmunicipio" style="display: none;">
        <div class="col-md-2">
            <div class="form-group">
                <div class="col-sm-12">
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="form-group">
                <div class="col-sm-12">
                    <h4><center><label for="box-title">LISTA MUNICIPIO</label></center></h4> 
                </div>
            </div>
        </div>
         <div class="col-md-3">
            <div class="form-group">
                <div class="col-sm-12">
                    <button class="btn pull-right btn btn-default" data-target="#myCreateMunicipio" data-toggle="modal" style="background: #70747d"><h6 style="color:white;">+&nbsp;MUNICIPIO</h6></button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border"></div>
                <div class="box-body">
                    <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-municipio" style="width:100%">
                        <thead class="cf">
                            <tr>
                                <th>#</th>
                                <th>NOMBRE</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>    
            </div>
        </div>
    </div>
    <div id="listmaquila" style="display: none;">
        <div class="col-md-2">
            <div class="form-group">
                <div class="col-sm-12">
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="form-group">
                <div class="col-sm-12">
                    <h4><center><label for="box-title">LISTA PLANTAS MAQUILAS</label></center></h4> 
                </div>
            </div>
        </div>
         <div class="col-md-3">
            <div class="form-group">
                <div class="col-sm-12">
                    <button class="btn pull-right btn btn-default" data-target="#myCreatePlanMaquila" data-toggle="modal" style="background: #70747d"><h6 style="color:white;">+&nbsp;MAQUILAS</h6></button>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border"></div>
                <div class="box-body">
                    <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-maquila" style="width:100%">
                        <thead class="cf">
                            <tr>
                                <th>#</th>
                                <th>NOMBRE</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>    
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    ListaPartida();
});
function Lista(){
    var cmblist = document.getElementById('cmblist').value;
    console.log(cmblist);
        
    if (cmblist==1) {
        $('#listpartida').show();
        $('#listcategoria').hide();
        $('#listunidadmedida').hide();
        $('#listingreso').hide();
        $('#listipoinsumo').hide();
        $('#listipoenvase').hide();
        $('#listmercado').hide();
        $('#listcolor').hide();
        $('#listsabor').hide();
        $('#listlinprod').hide();
        $('#listprodesp').hide();
        $('#listmunicipio').hide();
        $('#listsublinea').hide();
        $('#listmaquila').hide();

        ListaPartida();
    }if(cmblist==2){
        $('#listcategoria').show();
        $('#listpartida').hide();
        $('#listunidadmedida').hide();
        $('#listingreso').hide();
        $('#listipoinsumo').hide();
        $('#listipoenvase').hide();
        $('#listmercado').hide();
        $('#listcolor').hide();
        $('#listsabor').hide();
        $('#listlinprod').hide();
        $('#listprodesp').hide();
        $('#listmunicipio').hide();
        $('#listsublinea').hide();
        $('#listmaquila').hide();
        
        var tableCategoria = $('#lts-categoria').DataTable( {
            "destroy": true,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/DatosInsumo/create/",
            "columns":[
                {data: 'cat_id'},
                {data: 'cat_nombre'},
                {data: 'acciones',orderable: false, searchable: false},
                //{data: 'part_nombre'},
            ],
            "language": {
                 "url": "/lenguaje"
            },
             "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        });
        tableCategoria.on( 'order.dt search.dt', function () {
        tableCategoria.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
    }if(cmblist==3){
        $('#listunidadmedida').show();
        $('#listpartida').hide();
        $('#listcategoria').hide();
        $('#listingreso').hide();
        $('#listipoinsumo').hide();
        $('#listipoenvase').hide();
        $('#listmercado').hide();
        $('#listcolor').hide();
        $('#listsabor').hide();
        $('#listlinprod').hide();
        $('#listprodesp').hide();
        $('#listmunicipio').hide();
        $('#listsublinea').hide();
        $('#listmaquila').hide();

        var tableUmed = $('#lts-unidadmedida').DataTable( {
            "destroy": true,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/listUnidadMedida",
            "columns":[
                {data: 'umed_id'},
                {data: 'umed_nombre'},
                {data: 'umed_sigla'},
                {data: 'acciones',orderable: false, searchable: false},
            ],
            
            "language": {
                 "url": "/lenguaje"
            },
             "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        });
        tableUmed.on( 'order.dt search.dt', function () {
            tableUmed.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    }if(cmblist==4){
        $('#listingreso').show();
        $('#listunidadmedida').hide();
        $('#listpartida').hide();
        $('#listcategoria').hide();
        $('#listipoinsumo').hide();
        $('#listipoenvase').hide();
        $('#listmercado').hide();
        $('#listcolor').hide();
        $('#listsabor').hide();
        $('#listlinprod').hide();
        $('#listprodesp').hide();
        $('#listmunicipio').hide();
        $('#listsublinea').hide();
        $('#listmaquila').hide();

    var tableTipIngreso = $('#lts-tipoingreso').DataTable( {
        "destroy": true,
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/listTipoIngreso",
        "columns":[
            {data: 'ting_id'},
            {data: 'ting_nombre'},
            {data: 'acciones',orderable: false, searchable: false},
        ],
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
    tableTipIngreso.on( 'order.dt search.dt', function () {
        tableTipIngreso.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
    }if(cmblist==5){
        $('#listipoinsumo').show();
        $('#listingreso').hide();
        $('#listunidadmedida').hide();
        $('#listpartida').hide();
        $('#listcategoria').hide();
        $('#listipoenvase').hide();
        $('#listmercado').hide();
        $('#listcolor').hide();
        $('#listsabor').hide();
        $('#listlinprod').hide();
        $('#listprodesp').hide();
        $('#listmunicipio').hide();
        $('#listsublinea').hide();
        $('#listmaquila').hide();

    var tableTipInsumo = $('#lts-tipoinsumo').DataTable( {
            "destroy": true,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/listTipoInsumo",
            "columns":[
                {data: 'tins_id'},
                {data: 'tins_nombre'},
                {data: 'acciones',orderable: false, searchable: false},
            ],
            
            "language": {
                 "url": "/lenguaje"
            },
             "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        });
    tableTipInsumo.on( 'order.dt search.dt', function () {
        tableTipInsumo.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
    }if(cmblist==6){
        $('#listipoenvase').show();
        $('#listipoinsumo').hide();
        $('#listingreso').hide();
        $('#listunidadmedida').hide();
        $('#listpartida').hide();
        $('#listcategoria').hide();
        $('#listmercado').hide();
        $('#listcolor').hide();
        $('#listsabor').hide();
        $('#listlinprod').hide();
        $('#listprodesp').hide();
        $('#listmunicipio').hide();
        $('#listsublinea').hide();
        $('#listmaquila').hide();

    var tableTipEnvase = $('#lts-tipoenvase').DataTable({
            "destroy": true,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/listTipoEnvase",
            "columns":[
                {data: 'tenv_id'},
                {data: 'tenv_nombre'},
                {data: 'acciones',orderable: false, searchable: false},
            ],       
            "language": {
                 "url": "/lenguaje"
            },
             "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        });
    tableTipEnvase.on( 'order.dt search.dt', function () {
        tableTipEnvase.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
    }if(cmblist==7){
        $('#listmercado').show();
        $('#listipoenvase').hide();
        $('#listipoinsumo').hide();
        $('#listingreso').hide();
        $('#listunidadmedida').hide();
        $('#listpartida').hide();
        $('#listcategoria').hide();
        $('#listcolor').hide();
        $('#listsabor').hide();
        $('#listlinprod').hide();
        $('#listprodesp').hide();
        $('#listmunicipio').hide();
        $('#listsublinea').hide();
        $('#listmaquila').hide();

    tableMercado = $('#lts-mercado').DataTable({
            "destroy": true,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/listMercado",
            "columns":[
                {data: 'mer_id'},
                {data: 'mer_nombre'},
                {data: 'acciones',orderable: false, searchable: false},
            ],        
            "language": {
                 "url": "/lenguaje"
            },
             "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        });
    tableMercado.on( 'order.dt search.dt', function () {
        tableMercado.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
    }if(cmblist==8){
        $('#listcolor').show();
        $('#listmercado').hide();
        $('#listipoenvase').hide();
        $('#listipoinsumo').hide();
        $('#listingreso').hide();
        $('#listunidadmedida').hide();
        $('#listpartida').hide();
        $('#listcategoria').hide();
        $('#listsabor').hide();
        $('#listlinprod').hide();
        $('#listprodesp').hide();
        $('#listmunicipio').hide();
        $('#listsublinea').hide();
        $('#listmaquila').hide();

    var tableColor = $('#lts-color').DataTable({
            "destroy": true,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/listColor",
            "columns":[
                {data: 'col_id'},
                {data: 'col_nombre'},
                {data: 'acciones',orderable: false, searchable: false},
            ],        
            "language": {
                 "url": "/lenguaje"
            },
             "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        });
    tableColor.on( 'order.dt search.dt', function () {
        tableColor.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
    }if(cmblist==9){
        $('#listsabor').show();
        $('#listcolor').hide();
        $('#listmercado').hide();
        $('#listipoenvase').hide();
        $('#listipoinsumo').hide();
        $('#listingreso').hide();
        $('#listunidadmedida').hide();
        $('#listpartida').hide();
        $('#listcategoria').hide();
        $('#listprodesp').hide();
        $('#listmunicipio').hide();
        $('#listlinprod').hide();
        $('#listsublinea').hide();
        $('#listmaquila').hide();

    var tableSabor = $('#lts-sabor').DataTable({
            "destroy": true,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/listSabor",
            "columns":[
                {data: 'sab_id'},
                {data: 'sab_nombre'},
                {data: 'acciones',orderable: false, searchable: false},
            ],        
            "language": {
                 "url": "/lenguaje"
            },
             "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        });
    tableSabor.on( 'order.dt search.dt', function () {
        tableSabor.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
    }if(cmblist==10){
        $('#listlinprod').show();
        $('#listsabor').hide();
        $('#listcolor').hide();
        $('#listmercado').hide();
        $('#listipoenvase').hide();
        $('#listipoinsumo').hide();
        $('#listingreso').hide();
        $('#listunidadmedida').hide();
        $('#listpartida').hide();
        $('#listcategoria').hide();
        $('#listprodesp').hide();
        $('#listmunicipio').hide();
        $('#listsublinea').hide();
        $('#listmaquila').hide();

    var tableLinProd = $('#lts-linprod').DataTable({
            "destroy": true,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/listLineaProd",
            "columns":[
                {data: 'linea_prod_id'},
                {data: 'linea_prod_nombre'},
                {data: 'acciones',orderable: false, searchable: false},
            ],        
            "language": {
                 "url": "/lenguaje"
            },
             "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        });
    tableLinProd.on( 'order.dt search.dt', function () {
        tableLinProd.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
    }if(cmblist==11){
        $('#listsublinea').show();
        $('#listprodesp').hide();
        $('#listlinprod').hide();
        $('#listsabor').hide();
        $('#listcolor').hide();
        $('#listmercado').hide();
        $('#listipoenvase').hide();
        $('#listipoinsumo').hide();
        $('#listingreso').hide();
        $('#listunidadmedida').hide();
        $('#listpartida').hide();
        $('#listcategoria').hide();
        $('#listmunicipio').hide();
        $('#listmaquila').hide();

    var tableSubLinea = $('#lts-sublinea').DataTable({
            "destroy": true,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/listSubLinea",
            "columns":[
                {data: 'sublin_id'},
                {data: 'sublin_nombre'},
                {data: 'produccion'},
                {data: 'acciones',orderable: false, searchable: false},
            ],        
            "language": {
                 "url": "/lenguaje"
            },
             "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        });
    tableSubLinea.on( 'order.dt search.dt', function () {
        tableSubLinea.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
    }if(cmblist==12){
        $('#listmunicipio').hide();
        $('#listprodesp').show();
        $('#listlinprod').hide();
        $('#listsabor').hide();
        $('#listcolor').hide();
        $('#listmercado').hide();
        $('#listipoenvase').hide();
        $('#listipoinsumo').hide();
        $('#listingreso').hide();
        $('#listunidadmedida').hide();
        $('#listpartida').hide();
        $('#listcategoria').hide();
        $('#listsublinea').hide();
        $('#listmaquila').hide();

    var tableProDesp = $('#lts-prodesp').DataTable({
            "destroy": true,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/listProdEspe",
            "columns":[
                {data: 'prod_esp_id'},
                {data: 'prod_esp_nombre'},
                {data: 'acciones',orderable: false, searchable: false},
            ],        
            "language": {
                 "url": "/lenguaje"
            },
             "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        });
    tableProDesp.on( 'order.dt search.dt', function () {
        tableProDesp.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
    }if(cmblist==13){
        $('#listmunicipio').show();
        $('#listprodesp').hide();
        $('#listlinprod').hide();
        $('#listsabor').hide();
        $('#listcolor').hide();
        $('#listmercado').hide();
        $('#listipoenvase').hide();
        $('#listipoinsumo').hide();
        $('#listingreso').hide();
        $('#listunidadmedida').hide();
        $('#listpartida').hide();
        $('#listcategoria').hide();
        $('#listsublinea').hide();
        $('#listmaquila').hide();

    var tableMunicipio = $('#lts-municipio').DataTable({
            "destroy": true,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/listMunicipio",
            "columns":[
                {data: 'muni_id'},
                {data: 'muni_nombre'},
                {data: 'acciones',orderable: false, searchable: false},
            ],        
            "language": {
                 "url": "/lenguaje"
            },
             "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        });
    tableMunicipio.on( 'order.dt search.dt', function () {
        tableMunicipio.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
    }if(cmblist==14){
        $('#listmaquila').show();
        $('#listmunicipio').hide();
        $('#listprodesp').hide();
        $('#listlinprod').hide();
        $('#listsabor').hide();
        $('#listcolor').hide();
        $('#listmercado').hide();
        $('#listipoenvase').hide();
        $('#listipoinsumo').hide();
        $('#listingreso').hide();
        $('#listunidadmedida').hide();
        $('#listpartida').hide();
        $('#listcategoria').hide();
        $('#listsublinea').hide();

    var tableMaquila = $('#lts-maquila').DataTable({
            "destroy": true,
            "responsive": true,
            "processing": true,
            "serverSide": true,
            "ajax": "/listPlantaMaquila",
            "columns":[
                {data: 'maquila_id'},
                {data: 'maquila_nombre'},
                {data: 'acciones',orderable: false, searchable: false},
            ],        
            "language": {
                 "url": "/lenguaje"
            },
             "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        });
    }
    tableMaquila.on( 'order.dt search.dt', function () {
        tableMaquila.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
}

function ListaPartida(){
    $('#listunidadmedida').hide();
    $('#listcategoria').hide();
    $('#listpartida').show();
    $('#listingreso').hide();
    $('#listipoinsumo').hide();
    $('#listipoenvase').hide();
    $('#listmercado').hide();

    var tablePartida = $('#lts-partida').DataTable( {
        "destroy": true,
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/listPartida",
        "columns":[
            {data: 'part_id'},
            {data: 'part_codigo'},
            {data: 'part_nombre'},
            {data: 'acciones',orderable: false, searchable: false},
        ],
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
    tablePartida.on( 'order.dt search.dt', function () {
        tablePartida.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
}

function Limpiar(){
    $("#nombre").val("");
    $("#partida").val(""); 
    $("#nombreUni").val("");
    $("#sigla").val(""); 
    $("#nombrePart").val("");
    $("#nombreIng").val(""); 
    $("#nombreIns").val("");
    $("#nombreTipEnv").val("");
    $("#mercado").val("");
    $("#color").val("");
    $("#sabor").val("");
    $("#lineaprod").val("");
    $("#prodesp").val("");
    $("#municipio").val("");
    $("#nombresub").val("");
    $("#prodlinea").val("");
    $("#maquila").val("");
}

$("#registroCat").click(function(){
    var route="/DatosInsumo";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {
            'nombre_categoria':$("#nombre").val(),
            },
        success: function(data){
            $("#myCreateCat").modal('toggle');Limpiar();
            swal("Acceso!", "registro correcto","success");
            $('#lts-categoria').DataTable().ajax.reload();
        },
        error: function(result){
            var errorCompleto='Tiene los siguientes errores: ';
            $.each(result.responseJSON.errors,function(indice,valor){
                errorCompleto = errorCompleto + valor+' ' ;                       
            });
            swal("Opss..., Hubo un error!",errorCompleto,"error");
        }
    });
});

$("#registroUni").click(function(){
    var route="/RegUnidad";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {
            'nombre_unidad_medida':$("#nombreUni").val(),
            'sigla_unidad_medida':$("#sigla").val(),
            },
        success: function(data){
            $("#myCreateUni").modal('toggle');Limpiar();
            swal("Acceso!", "registro correcto","success");
            $('#lts-unidadmedida').DataTable().ajax.reload();
        },
        error: function(result){
            var errorCompleto='Tiene los siguientes errores: ';
            $.each(result.responseJSON.errors,function(indice,valor){
                errorCompleto = errorCompleto + valor+' ' ;                       
            });
            swal("Opss..., Hubo un error!",errorCompleto,"error");
        }
    });
});

$("#registroPart").click(function(){
    var route="/RegPartida";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {
            'codigo_de_partida':$("#codigoPart").val(),
            'nombre_de_partida':$("#nombrePart").val(),
        },
        success: function(data){
            $("#myCreatePart").modal('toggle');Limpiar();
            swal("Acceso!", "registro correcto","success");
            $('#lts-partida').DataTable().ajax.reload();
            location.reload();
        },
        error: function(result){
            var errorCompleto='Tiene los siguientes errores: ';
            $.each(result.responseJSON.errors,function(indice,valor){
                errorCompleto = errorCompleto + valor+' ' ;                       
            });
            swal("Opss..., Hubo un error!",errorCompleto,"error");
        }
    });
});

$("#registroTipoIng").click(function(){
    var route="/RegTipoIngreso";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {
            'nombre_ingreso':$("#nombreIng").val(),
        },
        success: function(data){
            $("#myCreateIng").modal('toggle');Limpiar();
            swal("Acceso!", "registro correcto","success");
            $('#lts-tipoingreso').DataTable().ajax.reload();
        },
        error: function(result){
            var errorCompleto='Tiene los siguientes errores: ';
            $.each(result.responseJSON.errors,function(indice,valor){
               errorCompleto = errorCompleto + valor+' ' ;                       
            });
            swal("Opss..., Hubo un error!",errorCompleto,"error");
        }
    });
});

$("#registroIns").click(function(){
    var route="/RegInsumo";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {
            'nombre_tipo_insumo':$("#nombreIns").val(),
        },
        success: function(data){
            $("#myCreateIns").modal('toggle');Limpiar();
            swal("Acceso!", "registro correcto","success");
            $('#lts-tipoinsumo').DataTable().ajax.reload();
        },
        error: function(result){
            var errorCompleto='Tiene los siguientes errores: ';
            $.each(result.responseJSON.errors,function(indice,valor){
                errorCompleto = errorCompleto + valor+' ' ;                       
            });
            swal("Opss..., Hubo un error!",errorCompleto,"error");
        }
    });
});

//TIPO ENVASE
$("#registroTipEnv").click(function(){
    var route="/RegTipEnv";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {
            'nombre_tipo_envase':$("#nombreTipEnv").val(),
        },
        success: function(data){
            $("#myCreateTipEnv").modal('toggle');Limpiar();
            swal("Tipo Envase!", "registro correcto","success");
            $('#lts-tipoenvase').DataTable().ajax.reload();             
        },
        error: function(result)
        {
            var errorCompleto='Tiene los siguientes errores: ';
            $.each(result.responseJSON.errors,function(indice,valor){
                errorCompleto = errorCompleto + valor+' ' ;                       
            });
            swal("Opss..., Hubo un error!",errorCompleto,"error");
        }
    });
});

$("#registroMercado").click(function(){
    var route="/RegMercado";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {
            'mer_nombre':$("#mercado").val(),
        },
        success: function(data){
            $("#myCreateMercado").modal('toggle');Limpiar();
            swal("Mercado!", "registro correcto","success");
            $('#lts-mercado').DataTable().ajax.reload();             
        },
        error: function(result){
            var errorCompleto='Tiene los siguientes errores: ';
            $.each(result.responseJSON.errors,function(indice,valor){
                errorCompleto = errorCompleto + valor+' ' ;                       
            });
            swal("Opss..., Hubo un error!",errorCompleto,"error");
        }
    });
});

$("#registroColor").click(function(){
    var route="/RegColor";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {
            'col_nombre':$("#color").val(),
        },
        success: function(data){
            $("#myCreateColor").modal('toggle');Limpiar();
            swal("Color!", "registro correcto","success");
            $('#lts-color').DataTable().ajax.reload();             
        },
        error: function(result){
            var errorCompleto='Tiene los siguientes errores: ';
            $.each(result.responseJSON.errors,function(indice,valor){
                errorCompleto = errorCompleto + valor+' ' ;                       
            });
            swal("Opss..., Hubo un error!",errorCompleto,"error");
        }
    });
});

$("#registroSabor").click(function(){
    var route="/RegSabor";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {
            'sab_nombre':$("#sabor").val(),
        },
        success: function(data){
            $("#myCreateSabor").modal('toggle');Limpiar();
            swal("Sabor!", "registro correcto","success");
            $('#lts-sabor').DataTable().ajax.reload();             
        },
        error: function(result){
            var errorCompleto='Tiene los siguientes errores: ';
            $.each(result.responseJSON.errors,function(indice,valor){
                errorCompleto = errorCompleto + valor+' ' ;                       
            });
            swal("Opss..., Hubo un error!",errorCompleto,"error");
        }
    });
});

$("#registroLineaProd").click(function(){
    var route="/RegLineaPro";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {
            'linea_prod_nombre':$("#lineaprod").val(),
        },
        success: function(data){
            $("#myCreateLineaProd").modal('toggle');Limpiar();
            swal("Linea de Produccion!", "registro correcto","success");
            $('#lts-linprod').DataTable().ajax.reload();             
        },
        error: function(result){
            var errorCompleto='Tiene los siguientes errores: ';
            $.each(result.responseJSON.errors,function(indice,valor){
                errorCompleto = errorCompleto + valor+' ' ;                       
            });
            swal("Opss..., Hubo un error!",errorCompleto,"error");
        }
    });
});

$("#registroProdEspecifico").click(function(){
    var route="/RegProdEsp";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {
            'prod_esp_nombre':$("#prodesp").val(),
        },
        success: function(data){
            $("#myCreateProdEsp").modal('toggle');Limpiar();
            swal("Producto Especifico!", "registro correcto","success");
            $('#lts-prodesp').DataTable().ajax.reload();             
        },
        error: function(result){
            var errorCompleto='Tiene los siguientes errores: ';
            $.each(result.responseJSON.errors,function(indice,valor){
                errorCompleto = errorCompleto + valor+' ' ;                       
            });
            swal("Opss..., Hubo un error!",errorCompleto,"error");
        }
    });
});

$("#registroMunicipio").click(function(){
    var route="/RegMunicipio";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {
            'muni_nombre':$("#municipio").val(),
        },
        success: function(data){
            $("#myCreateMunicipio").modal('toggle');Limpiar();
            swal("Municipio!", "registro correcto","success");
            $('#lts-municipio').DataTable().ajax.reload();             
        },
        error: function(result){
            var errorCompleto='Tiene los siguientes errores: ';
            $.each(result.responseJSON.errors,function(indice,valor){
                errorCompleto = errorCompleto + valor+' ' ;                       
            });
            swal("Opss..., Hubo un error!",errorCompleto,"error");
        }
    });
});

$("#registroSubLinea").click(function(){
    var route="/RegSubLinea";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {
            'sublin_nombre':$("#nombresub").val(),
            'sublin_prod_id':$("#prodlinea").val(),
        },
        success: function(data){
            $("#myCreateSubLinea").modal('toggle');Limpiar();
            swal("Sub-Linea!", "registro correcto","success");
            $('#lts-sublinea').DataTable().ajax.reload();             
        },
        error: function(result){
            var errorCompleto='Tiene los siguientes errores: ';
            $.each(result.responseJSON.errors,function(indice,valor){
                errorCompleto = errorCompleto + valor+' ' ;                       
            });
            swal("Opss..., Hubo un error!",errorCompleto,"error");
        }
    });
});

$("#registroPlantaMaquila").click(function(){
    var route="/RegPlantaMaquila";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {
            'maquila_nombre':$("#maquila").val(),
        },
        success: function(data){
            $("#myCreatePlanMaquila").modal('toggle');Limpiar();
            swal("Planta Maquila!", "registro correcto","success");
            $('#lts-maquila').DataTable().ajax.reload();             
        },
        error: function(result){
            var errorCompleto='Tiene los siguientes errores: ';
            $.each(result.responseJSON.errors,function(indice,valor){
                errorCompleto = errorCompleto + valor+' ' ;                       
            });
            swal("Opss..., Hubo un error!",errorCompleto,"error");
        }
    });
});

function MostrarCategoria(btn){
    var route = "DatosInsumo/"+btn.value+"/edit";
    console.log(route);
        $.get(route, function(res){
            $("#idcat").val(res.cat_id);
            $("#catnombre").val(res.cat_nombre);
        });
}

$("#modificarCat").click(function(){
    var value =$("#idcat").val();
    var route="/DatosInsumo/"+value+"";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'PUT',
        dataType: 'json',
        data:{
            'cat_nombre':$("#catnombre").val(),
        },
        success: function(data){
            $("#myUpdateCat").modal('toggle');
            swal("El Registro!", "Fue actualizado correctamente!", "success");
            $('#lts-categoria').DataTable().ajax.reload();    
        },  error: function(result) {
            console.log(result);
            swal("Opss..!", "El registrp no se puedo actualizar intente de nuevo!", "error")
        }
    });
});

function EliminarCategoria(btn){
    var route="/DatosInsumo/"+btn.value+"";
    var token =$("#token").val();
    swal({   title: "Esta seguro de eliminar la categoria?", 
      text: "Presione ok para eliminar el registro de la base de datos!", 
      type: "warning",   showCancelButton: true,
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Si, Eliminar!",
      closeOnConfirm: false 
    }, function(){  
       $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'DELETE',
            dataType: 'json', 
            success: function(data){
                $('#lts-categoria').DataTable().ajax.reload();
                swal("Categoria!", "Fue eliminado correctamente!", "success");
            },
            error: function(result) {
                swal("Opss..!", "El Categoria tiene registros en otras tablas!", "error")
            }
        });
    });
}

function MostrarUnidadMedida(btn){
    var route = "RegUnidad/"+btn.value+"";
    console.log(route);
    $.get(route, function(res){
        $("#iduni").val(res.umed_id);
        $("#nombreUnimed").val(res.umed_nombre);
        $("#siglamed").val(res.umed_sigla);
    });
}

$("#modificarUnidadMedida").click(function(){
    var value =$("#iduni").val();
    var route="UpdateUnidadMed/"+value+"";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'PUT',
        dataType: 'json',
        data:{
            'umed_nombre':$("#nombreUnimed").val(),
            'umed_sigla':$("#siglamed").val(),
        },
        success: function(data){
            $("#myUpdateUni").modal('toggle');
            swal("El registro!", "Fue actualizado correctamente!", "success");
            $('#lts-unidadmedida').DataTable().ajax.reload();    
        },  
        error: function(result) {
            console.log(result);
            swal("Opss..!", "El registro no se puedo actualizar intente de nuevo!", "error")
        }
    });
});

function EliminarUnidadMedida(btn){
    var route="/DeleteUnidadMedida/"+btn.value+"";
    var token =$("#token").val();
    swal({   title: "Esta seguro de eliminar el registro?", 
      text: "Presione ok para eliminar el registro de la base de datos!", 
      type: "warning",   showCancelButton: true,
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Si, Eliminar!",
      closeOnConfirm: false 
    }, function(){  
       $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'DELETE',
            dataType: 'json', 
            success: function(data){
                $('#lts-unidadmedida').DataTable().ajax.reload();
                swal("Registro!", "Fue eliminado correctamente!", "success");
            },
            error: function(result) {
                swal("Opss..!", "El registro tiene registros en otras tablas!", "error")
            }
        });
    });
}

function MostrarPartida(btn){
    var route = "RegPartida/"+btn.value+"";
    console.log(route);
    $.get(route, function(res){
        $("#idpart").val(res.part_id);
        $("#partcodigo").val(res.part_codigo);
        $("#partnom").val(res.part_nombre);
    });
}

$("#modificarPartida").click(function(){
    var value =$("#idpart").val();
    var route="UpdateṔartida/"+value+"";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'PUT',
        dataType: 'json',
        data:{
            'part_codigo':$("#partcodigo").val(),
            'part_nombre':$("#partnom").val(),
        },
        success: function(data){
            $("#myUpdatePart").modal('toggle');
            swal("El registro!", "Fue actualizado correctamente!", "success");
            $('#lts-partida').DataTable().ajax.reload();    
            location.reload();
        },  
        error: function(result) {
            console.log(result);
            swal("Opss..!", "El registro no se puedo actualizar intente de nuevo!", "error")
        }
    });
});

function EliminarPartida(btn){
    var route="/DeletePartida/"+btn.value+"";
    var token =$("#token").val();
    swal({   title: "Esta seguro de eliminar el registro?", 
      text: "Presione ok para eliminar el registro de la base de datos!", 
      type: "warning",   showCancelButton: true,
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Si, Eliminar!",
      closeOnConfirm: false 
    }, function(){  
       $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'DELETE',
            dataType: 'json',     
            success: function(data){
                $('#lts-partida').DataTable().ajax.reload();
                swal("Registro!", "Fue eliminado correctamente!", "success");
                location.reload();
            },
            error: function(result) {
                swal("Opss..!", "El registro tiene registros en otras tablas!", "error")
            }
        });
    });
}

function MostrarTipoIngreso(btn){
    var route = "RegTipoIngreso/"+btn.value+"";
    console.log(route);
    $.get(route, function(res){
        $("#iding").val(res.ting_id);
        $("#ingnombre").val(res.ting_nombre);
    });
}

$("#modificarTipoIngreso").click(function(){
    var value =$("#iding").val();
    var route="UpdateTipoIngreso/"+value+"";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'PUT',
        dataType: 'json',
        data:{
            'ting_nombre':$("#ingnombre").val(),
        },
        success: function(data){
            $("#myUpdateIng").modal('toggle');
            swal("El registro!", "Fue actualizado correctamente!", "success");
            $('#lts-tipoingreso').DataTable().ajax.reload();    
        },  
        error: function(result) {
            console.log(result);
            swal("Opss..!", "El registro no se puedo actualizar intente de nuevo!", "error")
        }
    });
});

function EliminarTipoIngreso(btn){
    var route="/DeleteTipoIngreso/"+btn.value+"";
    var token =$("#token").val();
    swal({   title: "Esta seguro de eliminar el registro?", 
      text: "Presione ok para eliminar el registro de la base de datos!", 
      type: "warning",   showCancelButton: true,
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Si, Eliminar!",
      closeOnConfirm: false 
    }, function(){  
       $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'DELETE',
            dataType: 'json',           
            success: function(data){
                $('#lts-tipoingreso').DataTable().ajax.reload();
                swal("Registro!", "Fue eliminado correctamente!", "success");
            },
            error: function(result) {
                swal("Opss..!", "El registro tiene registros en otras tablas!", "error")
            }
        });
    });
}

function MostrarTipoInsumo(btn){
    var route = "RegInsumo/"+btn.value+"";
    console.log(route);
    $.get(route, function(res){
        $("#idins").val(res.tins_id);
        $("#insnombre").val(res.tins_nombre);
    });
}

$("#modificarTipoInsumo").click(function(){
    var value =$("#idins").val();
    var route="UpdateTipoInsumo/"+value+"";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'PUT',
        dataType: 'json',
        data:{'tins_nombre':$("#insnombre").val(),},
        success: function(data){
            $("#myUpdateIns").modal('toggle');
            swal("El registro!", "Fue actualizado correctamente!", "success");
            $('#lts-tipoinsumo').DataTable().ajax.reload();    
        },  error: function(result) {
            console.log(result);
            swal("Opss..!", "El registro no se puedo actualizar intente de nuevo!", "error")
        }
    });
});

function EliminarTipoInsumo(btn){
    var route="/DeleteTipoInsumo/"+btn.value+"";
    var token =$("#token").val();
    swal({   title: "Esta seguro de eliminar el registro?", 
      text: "Presione ok para eliminar el registro de la base de datos!", 
      type: "warning",   showCancelButton: true,
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Si, Eliminar!",
      closeOnConfirm: false 
    }, function(){  
        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'DELETE',
            dataType: 'json',         
            success: function(data){
                $('#lts-tipoinsumo').DataTable().ajax.reload();
                swal("Registro!", "Fue eliminado correctamente!", "success");
            },
            error: function(result) {
                swal("Opss..!", "El registro tiene registros en otras tablas!", "error")
            }
        });
    });
}

function MostrarTipoEnvase(btn){
    var route = "RegTipEnv/"+btn.value+"";
    console.log(route);
    $.get(route, function(res){
        $("#idenvase").val(res.tenv_id);
        $("#envnombre").val(res.tenv_nombre);
    });
}

$("#modificarTipoEnvase").click(function(){
    var value =$("#idenvase").val();
    var route="UpdateTipoEnvase/"+value+"";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'PUT',
        dataType: 'json',
        data:{'tenv_nombre':$("#envnombre").val(),},
        success: function(data){
            $("#myUpdateTipEnv").modal('toggle');
            swal("El registro!", "Fue actualizado correctamente!", "success");
            $('#lts-tipoenvase').DataTable().ajax.reload();    
        },  
        error: function(result) {
            console.log(result);
            swal("Opss..!", "El registro no se puedo actualizar intente de nuevo!", "error")
        }
    });
});

function EliminarTipoEnvase(btn){
    var route="/DeleteTipoEnvase/"+btn.value+"";
    var token =$("#token").val();
    swal({   title: "Esta seguro de eliminar el registro?", 
      text: "Presione ok para eliminar el registro de la base de datos!", 
      type: "warning",   showCancelButton: true,
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Si, Eliminar!",
      closeOnConfirm: false 
    }, function(){  
       $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'DELETE',
            dataType: 'json', 
            success: function(data){
                $('#lts-tipoenvase').DataTable().ajax.reload();
                swal("Registro!", "Fue eliminado correctamente!", "success");
            },
                error: function(result) {
                swal("Opss..!", "El registro tiene registros en otras tablas!", "error")
            }
        });
    });
}

function MostrarMercado(btn){
    var route = "RegMercado/"+btn.value+"";
    console.log(route);
    $.get(route, function(res){
        $("#idmer").val(res.mer_id);
        $("#nomercado").val(res.mer_nombre);
    });
}

$("#modificarMercado").click(function(){
    var value =$("#idmer").val();
    var route="UpdateMercado/"+value+"";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'PUT',
        dataType: 'json',
        data:{'mer_nombre':$("#nomercado").val(),},
        success: function(data){
            $("#myUpdateMercado").modal('toggle');
            swal("El registro!", "Fue actualizado correctamente!", "success");
            $('#lts-mercado').DataTable().ajax.reload();    
        },  
        error: function(result) {
            console.log(result);
            swal("Opss..!", "El registro no se puedo actualizar intente de nuevo!", "error")
        }
    });
});

function EliminarMercado(btn){
    var route="/DeletMercado/"+btn.value+"";
    var token =$("#token").val();
    swal({   title: "Esta seguro de eliminar el registro?", 
      text: "Presione ok para eliminar el registro de la base de datos!", 
      type: "warning",   showCancelButton: true,
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Si, Eliminar!",
      closeOnConfirm: false 
    }, function(){  
       $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'DELETE',
            dataType: 'json',             
            success: function(data){
                $('#lts-mercado').DataTable().ajax.reload();
                swal("Categoria!", "Fue eliminado correctamente!", "success");
            },
            error: function(result) {
                swal("Opss..!", "El registro tiene registros en otras tablas!", "error")
            }
        });
    });
}

function MostrarColor(btn){
    var route = "RegColor/"+btn.value+"";
    console.log(route);
    $.get(route, function(res){
        $("#idcol").val(res.col_id);
        $("#nomcol").val(res.col_nombre);
    });
}

$("#modificarColor").click(function(){
    var value =$("#idcol").val();
    var route="UpdateColor/"+value+"";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'PUT',
        dataType: 'json',
        data:{'col_nombre':$("#nomcol").val(),},
        success: function(data){
            $("#myUpdateColor").modal('toggle');
            swal("El registro!", "Fue actualizado correctamente!", "success");
            $('#lts-color').DataTable().ajax.reload();    
        },  
        error: function(result) {
            console.log(result);
            swal("Opss..!", "El registro no se puedo actualizar intente de nuevo!", "error")
        }
    });
});

function EliminarColor(btn){
    var route="/DeleteColor/"+btn.value+"";
    var token =$("#token").val();
    swal({   title: "Esta seguro de eliminar el registro?", 
      text: "Presione ok para eliminar el registro de la base de datos!", 
      type: "warning",   showCancelButton: true,
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Si, Eliminar!",
      closeOnConfirm: false 
    }, function(){  
       $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'DELETE',
            dataType: 'json',             
            success: function(data){
                $('#lts-color').DataTable().ajax.reload();
                swal("Registro!", "Fue eliminado correctamente!", "success");
            },
            error: function(result) {
                swal("Opss..!", "El registro tiene registros en otras tablas!", "error")
            }
        });
    });
}
function MostrarSabor(btn){
    var route = "RegSabor/"+btn.value+"";
    console.log(route);
    $.get(route, function(res){
        $("#idsab").val(res.sab_id);
        $("#nombreSabor").val(res.sab_nombre);
    });
}

$("#modificarSabor").click(function(){
    var value =$("#idsab").val();
    var route="UpdateSabor/"+value+"";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'PUT',
        dataType: 'json',
        data:{'sab_nombre':$("#nombreSabor").val(),},
        success: function(data){
            $("#myUpdateSabor").modal('toggle');
            swal("El registro!", "Fue actualizado correctamente!", "success");
            $('#lts-sabor').DataTable().ajax.reload();    
        },  
        error: function(result) {
            console.log(result);
            swal("Opss..!", "El registro no se puedo actualizar intente de nuevo!", "error")
        }
    });
});

function EliminarSabor(btn){
    var route="/DeleteSabor/"+btn.value+"";
    var token =$("#token").val();
    swal({   title: "Esta seguro de eliminar el registro?", 
      text: "Presione ok para eliminar el registro de la base de datos!", 
      type: "warning",   showCancelButton: true,
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Si, Eliminar!",
      closeOnConfirm: false 
    }, function(){  
       $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'DELETE',
            dataType: 'json',             
            success: function(data){
                $('#lts-sabor').DataTable().ajax.reload();
                swal("Registro!", "Fue eliminado correctamente!", "success");
            },
            error: function(result) {
                swal("Opss..!", "El registro tiene registros en otras tablas!", "error")
            }
        });
    });
}

function MostrarLinProd(btn){
    var route = "RegLineaPro/"+btn.value+"";
    console.log(route);
    $.get(route, function(res){
        $("#idprod").val(res.linea_prod_id);
        $("#nomlineaprod").val(res.linea_prod_nombre);
    });
}

$("#modificarLineaProd").click(function(){
    var value =$("#idprod").val();
    var route="UpdateLinProd/"+value+"";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'PUT',
        dataType: 'json',
        data:{'linea_prod_nombre':$("#nomlineaprod").val(),},
        success: function(data){
            $("#myUpdateLineaProd").modal('toggle');
            swal("El registro!", "Fue actualizado correctamente!", "success");
            $('#lts-linprod').DataTable().ajax.reload();    
        },  
        error: function(result) {
            console.log(result);
            swal("Opss..!", "El registro no se puedo actualizar intente de nuevo!", "error")
        }
    });
});

function EliminarLinProd(btn){
    var route="/DeleteLinProd/"+btn.value+"";
    var token =$("#token").val();
    swal({   title: "Esta seguro de eliminar el registro?", 
      text: "Presione ok para eliminar el registro de la base de datos!", 
      type: "warning",   showCancelButton: true,
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Si, Eliminar!",
      closeOnConfirm: false 
    }, function(){  
       $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'DELETE',
            dataType: 'json',             
            success: function(data){
                $('#lts-linprod').DataTable().ajax.reload();
                swal("Registro!", "Fue eliminado correctamente!", "success");
            },
            error: function(result) {
                swal("Opss..!", "El registro tiene registros en otras tablas!", "error")
            }
        });
    });
}

function MostrarSubLin(btn){
    var route = "RegSubLinea/"+btn.value+"";
    console.log(route);
    $.get(route, function(res){
        $("#idsublin").val(res.sublin_id);
        $("#nombresublin").val(res.sublin_nombre);
        $("#prodlineasub").val(res.sublin_prod_id);
    });
}

$("#modificarSubLinea").click(function(){
    var value =$("#idsublin").val();
    var route="UpdateSubLinea/"+value+"";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'PUT',
        dataType: 'json',
        data:{'sublin_nombre':$("#nombresublin").val(),
              'sublin_prod_id':$("#prodlineasub").val(),
             },
        success: function(data){
            $("#myUpdateSubLinea").modal('toggle');
            swal("El registro!", "Fue actualizado correctamente!", "success");
            $('#lts-sublinea').DataTable().ajax.reload();    
        },  
        error: function(result) {
            console.log(result);
            swal("Opss..!", "El registro no se puedo actualizar intente de nuevo!", "error")
        }
    });
});

function EliminarSubLinea(btn){
    var route="/DeleteSubLinea/"+btn.value+"";
    var token =$("#token").val();
    swal({   title: "Esta seguro de eliminar el registro?", 
      text: "Presione ok para eliminar el registro de la base de datos!", 
      type: "warning",   showCancelButton: true,
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Si, Eliminar!",
      closeOnConfirm: false 
    }, function(){  
       $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'DELETE',
            dataType: 'json',             
            success: function(data){
                $('#lts-sublinea').DataTable().ajax.reload();
                swal("Registro!", "Fue eliminado correctamente!", "success");
            },
            error: function(result) {
                swal("Opss..!", "El registro tiene registros en otras tablas!", "error")
            }
        });
    });
}

function MostrarProdEsp(btn){
    var route = "RegProdEsp/"+btn.value+"";
    console.log(route);
    $.get(route, function(res){
        $("#idespe").val(res.prod_esp_id);
        $("#nomprodesp").val(res.prod_esp_nombre);
    });
}

$("#modificarProdEsp").click(function(){
    var value =$("#idespe").val();
    var route="UpdateProdEsp/"+value+"";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'PUT',
        dataType: 'json',
        data:{'prod_esp_nombre':$("#nomprodesp").val(),
             },
        success: function(data){
            $("#myUpdateProdEsp").modal('toggle');
            swal("El registro!", "Fue actualizado correctamente!", "success");
            $('#lts-prodesp').DataTable().ajax.reload();    
        },  
        error: function(result) {
            console.log(result);
            swal("Opss..!", "El registro no se puedo actualizar intente de nuevo!", "error")
        }
    });
});

function EliminarProdEsp(btn){
    var route="/DeleteProdEsp/"+btn.value+"";
    var token =$("#token").val();
    swal({   title: "Esta seguro de eliminar el registro?", 
      text: "Presione ok para eliminar el registro de la base de datos!", 
      type: "warning",   showCancelButton: true,
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Si, Eliminar!",
      closeOnConfirm: false 
    }, function(){  
       $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'DELETE',
            dataType: 'json',             
            success: function(data){
                $('#lts-prodesp').DataTable().ajax.reload();
                swal("Registro!", "Fue eliminado correctamente!", "success");
            },
            error: function(result) {
                swal("Opss..!", "El registro tiene registros en otras tablas!", "error")
            }
        });
    });
}

function MostrarMunicipio(btn){
    var route = "RegMunicipio/"+btn.value+"";
    console.log(route);
    $.get(route, function(res){
        $("#idmuni").val(res.muni_id);
        $("#municipionom").val(res.muni_nombre);
    });
}

$("#modificarMunicipio").click(function(){
    var value =$("#idmuni").val();
    var route="UpdateMunicipio/"+value+"";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'PUT',
        dataType: 'json',
        data:{'muni_nombre':$("#municipionom").val(),
             },
        success: function(data){
            $("#myUpdateMunicipio").modal('toggle');
            swal("El registro!", "Fue actualizado correctamente!", "success");
            $('#lts-municipio').DataTable().ajax.reload();    
        },  
        error: function(result) {
            console.log(result);
            swal("Opss..!", "El registro no se puedo actualizar intente de nuevo!", "error")
        }
    });
});

function EliminarMunicipio(btn){
    var route="/DeleteMunicipio/"+btn.value+"";
    var token =$("#token").val();
    swal({   title: "Esta seguro de eliminar el registro?", 
      text: "Presione ok para eliminar el registro de la base de datos!", 
      type: "warning",   showCancelButton: true,
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Si, Eliminar!",
      closeOnConfirm: false 
    }, function(){  
       $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'DELETE',
            dataType: 'json',             
            success: function(data){
                $('#lts-municipio').DataTable().ajax.reload();
                swal("Registro!", "Fue eliminado correctamente!", "success");
            },
            error: function(result) {
                swal("Opss..!", "El registro tiene registros en otras tablas!", "error")
            }
        });
    });
}

function MostrarPlantaMaquila(btn){
    var route = "RegPlantaMaquila/"+btn.value+"";
    console.log(route);
    $.get(route, function(res){
        $("#idmaq").val(res.maquila_id);
        $("#nommaquila").val(res.maquila_nombre);
    });
}

$("#modificarPlantaMaquila").click(function(){
    var value =$("#idmaq").val();
    var route="UpdatePlantaMaquila/"+value+"";
    var token =$("#token").val();
    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'PUT',
        dataType: 'json',
        data:{'maquila_nombre':$("#nommaquila").val(),
             },
        success: function(data){
            $("#myUpdatePlanMaquila").modal('toggle');
            swal("El registro!", "Fue actualizado correctamente!", "success");
            $('#lts-maquila').DataTable().ajax.reload();    
        },  
        error: function(result) {
            console.log(result);
            swal("Opss..!", "El registro no se puedo actualizar intente de nuevo!", "error")
        }
    });
});

function EliminarPlantaMaquila(btn){
    var route="/DeletePlantaMaquila/"+btn.value+"";
    var token =$("#token").val();
    swal({   title: "Esta seguro de eliminar el registro?", 
      text: "Presione ok para eliminar el registro de la base de datos!", 
      type: "warning",   showCancelButton: true,
      confirmButtonColor: "#DD6B55",   
      confirmButtonText: "Si, Eliminar!",
      closeOnConfirm: false 
    }, function(){  
       $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'DELETE',
            dataType: 'json',             
            success: function(data){
                $('#lts-maquila').DataTable().ajax.reload();
                swal("Registro!", "Fue eliminado correctamente!", "success");
            },
            error: function(result) {
                swal("Opss..!", "El registro tiene registros en otras tablas!", "error")
            }
        });
    });
}

</script>
@endpush
