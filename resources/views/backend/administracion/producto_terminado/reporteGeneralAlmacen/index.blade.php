@extends('backend.template.app')
<style type="text/css" media="screen">
      .table-condensed>thead>tr>th, .table-condensed>tbody>tr>th, .table-condensed>tfoot>tr>th, .table-condensed>thead>tr>td, .table-condensed>tbody>tr>td, .table-condensed>tfoot>tr>td{
        padding: 1px;
    }
    table.dataTable tbody th, table.dataTable tbody td {
        padding: 8px 10px;
        color: dimgrey;
        font-size: 12px;
    }

    thead th {
      background-color:#428bca;
      color: white;
      font-size: 12px;
      border:1px;
        border: 1px solid white;
    }
    tfoot th {
      background-color:#428bca;
      color: white;
      font-size: 12px;
      border:1px;
        border: 1px solid white;
    }
    tbody td {
      background-color: #EEEEEE;
      font-size: 12px;
    }
    .panel-tabs {
        position: relative;
        bottom: 30px;
        clear:both;
        border-bottom: 1px solid transparent;
    }

    .panel-tabs > li {
        float: left;
        margin-bottom: -1px;
    }

    .panel-tabs > li > a {
        margin-right: 2px;
        margin-top: 4px;
        line-height: .85;
        border: 1px solid transparent;
        border-radius: 4px 4px 0 0;
        color: #ffffff;
    }

    .panel-tabs > li > a:hover {
        border-color: transparent;
        color: #ffffff;
        background-color: transparent;
    }

    .panel-tabs > li.active > a,
    .panel-tabs > li.active > a:hover,
    .panel-tabs > li.active > a:focus {
        color: #fff;
        cursor: default;
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        border-radius: 2px;
        background-color: rgba(255,255,255, .23);
        border-bottom-color: transparent;
    }
</style>
@section('main-content')
    <div class="col-md-2">
        <section class="task-panel tasks-widget">
            <div class="panel-heading">
                <div class="pull-left"><h5><i class="fa fa-tasks"></i><b>&nbsp;&nbsp;REPORTE GENERAL</b></h5></div>
            <br>
            </div>
            <input type="hidden" id="usr_id" name="usr_id" value="{{ Auth::user()->usr_id }}"/>
            <div class="panel-body">
              <div class="task-content">
                  <ul id="sortable" class="task-list ui-sortable">
                      <li class="list-primary" onClick="verDocumentosGenerados(1,{{ Auth::user()->usr_id }});" style="background: #ccc">
                          <i class=" fa fa-ellipsis-v"></i>
                          <div class="task-title">
                              <span class="task-title-sp">INGRESOS</span>
                              <div class="pull-right hidden-phone">
                                  <!--<button class="btn-round btn-info btn-xs fa fa-eye fa-2x" href="#solReceta" onClick="verDocumentosGenerados(1,{{ Auth::user()->usr_id }});"></button>-->
                                  <a data-toggle="tab" href="#ingresos" class="btn-round btn-info btn-xs fa fa-eye fa-2x">
                                  </a>
                              </div>
                          </div>
                      </li>
                      <li class="list-danger" onClick="verDocumentosGenerados(2,{{ Auth::user()->usr_id }});" style="background: #ccc">
                          <i class=" fa fa-ellipsis-v"></i>
                          <div class="task-title">
                              <span class="task-title-sp">DESPACHOS</span>
                              <div class="pull-right hidden-phone">
                                <!--<button  class="btn-round btn-info btn-xs fa fa-eye fa-2x" href="#solInsumo" onClick="verDocumentosGenerados(2,{{ Auth::user()->usr_id }});"></button>-->
                                <a data-toggle="tab" href="#despachos" class="btn-round btn-info btn-xs fa fa-eye fa-2x">
                                </a>
                             </div>
                          </div>
                      </li>
                      <li class="list-success" onClick="verDocumentosGenerados(3,{{ Auth::user()->usr_id }});" style="background: #ccc">
                          <i class=" fa fa-ellipsis-v"></i>
                          <div class="task-title">
                              <span class="task-title-sp">INVENTARIOS</span>
                              <div class="pull-right hidden-phone">
                                <!--<button class="btn-round btn-info btn-xs fa fa-eye fa-2x" onClick="verDocumentosGenerados(3,{{ Auth::user()->usr_id }});"></button>-->
                                <a data-toggle="tab" href="#inventarios" class="btn-round btn-info btn-xs fa fa-eye fa-2x">
                                </a>
                            </div>
                          </div>
                      </li>
                      <li class="list-warning" onClick="verDocumentosGenerados(4,{{ Auth::user()->usr_id }});" style="background: #ccc">
                          <i class=" fa fa-ellipsis-v"></i>
                          <div class="task-title">
                              <span class="task-title-sp">POR MES</span>
                              <div class="pull-right hidden-phone">
                                <!--<button class="btn-round btn-info btn-xs fa fa-eye fa-2x" onClick="verDocumentosGenerados(4,{{ Auth::user()->usr_id }});"></button>-->
                                <a data-toggle="tab" href="#mes" class="btn-round btn-info btn-xs fa fa-eye fa-2x">
                                </a>
                            </div>
                          </div>
                      </li>
                      <li class="list-info" style="background: #ccc">
                          <i class=" fa fa-ellipsis-v"></i>
                          <div class="task-title">
                              <span class="task-title-sp">POR CIERRE</span>
                              <div class="pull-right hidden-phone">
                                <!--<button class="btn-round btn-info btn-xs fa fa-eye fa-2x" onClick="verDocumentosGenerados(5,{{ Auth::user()->usr_id }});"></button>-->
                                <a data-toggle="tab" href="#solMaquila" class="btn-round btn-info btn-xs fa fa-eye fa-2x">
                                </a>
                            </div>
                          </div>
                      </li>
                  </ul>
              </div>
            </div>
        </section>
    </div>
    <div class="col-md-10">
        <!--<div class="alert alert-success">
            <button type="button" class="close">&times;</button>
            <strong>REPORTES</strong> Seleccione la opcion
        </div>-->
        <div class="tab-content">
          <div class="tab-pane fade in active" id="ingresos">
            <div class="box">
              <div class="box-header with-border text-center">
                  <h3 class="box-title" style="color: #2067b4">
                      <strong>INGRESOS</strong>
                  </h3>
                  <ul class="nav nav-tabs">
                    <li class="active" id="ingresoOrp">
                      <a data-toggle="tab" href="#ingresosOrp" class="btn btn-primary" style="font-size: 11px">
                        INGRESOS ORP <span class="glyphicon glyphicon-inbox"></span>
                      </a>
                    </li>
                    <li id="ingresosCanastillosss">
                      <a data-toggle="tab" href="#ingresosCanastillos" class="btn btn-primary" style="font-size: 11px">
                        INGRESOS CANASTILLOS <span class="glyphicon glyphicon-shopping-cart"></span>
                      </a>
                    </li>
                  </ul>
              </div>
              <div class="tab-content">
                <div class="tab-pane in active" id="ingresosOrp">
                  <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                          <div class="text-center">
                            <label>
                              <strong>Seleccione un planta</strong>
                            </label>
                          </div>
                          <select class="form-control" id="id_planta">
                            <option value="0">Todas las plantas</option>
                            @foreach($plantas as $planta)
                            <option value="{{$planta->id_planta}}">{{$planta->nombre_planta}}</option>
                            @endforeach
                          </select>                         
                        </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <div class="text-center">
                        <label>
                          <strong>Seleccione Mes</strong>
                        </label>
                      </div>
                        <div class="input-group">
                          <input type="text" class="form-control datepickerMonths" id="id_mes" name="id_mes" placeholder="Introduzca mes"> 
                          <span class="input-group-btn">
                            <button class="btn btn-primary" type="button" id="busca_mes" onclick="Buscarfechas();">Buscar</button>
                          </span>                  
                        </div>         
                      </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                          <div class="text-center">
                            <label><strong>Seleccione Día</strong></label>
                          </div>
                            <div class="input-group">
                              <input type="text" class="form-control datepickerDays" id="id_dia" name="id_dia" placeholder="Introduzca dia"> 
                              <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="busca_mes" onclick="BuscarDia();">Buscar</button>
                              </span>
                            </div>                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                          <div class="text-center">
                            <label><strong>Seleccione Rango de Fecha</strong></label>
                          </div>
                          <div class="input-group">
                            <div class="col-md-6">
                              <input type="text" class="form-control datepickerDays" id="id_dia_inicio" name="id_dia_inicio" placeholder="Introduzca dia">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control datepickerDays" id="id_dia_fin" name="id_dia_fin" placeholder="Introduzca dia">  
                            </div>
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="busca_mes" onclick="BuscarRango();">Buscar</button>
                            </span>
                          </div>                            
                        </div>
                    </div>
                  </div>
                  <div class="ocultarBotonDescargasIngresos" style="display: none;">
                    <a href="" class="btn btn-danger pdfMesIngresos" target="_blank"><span class="fa fa-file-pdf-o"> DESCARGAR PDF</span></a>
                    <a href="" class="btn btn-success excelMesIngresos"><span class="fa fa-file-excel-o"> DESCARGAR EXCEL</span></a>
                  </div>
                  <br>
                  <table class="table table-hover table-striped table-condensed cf" style="width: 100%" id="lts-orp">
                    <thead class="cf">
                      <tr>
                        <th class="text-center">
                          #
                        </th>
                        <th class="text-center">
                          RECETA
                        </th>
                        <th class="text-center">
                          CODIGO
                        </th>
                        <th class="text-center">
                          NRO ORDEN
                        </th>
                        <th class="text-center">
                          CANTIDAD
                        </th>
                        <th class="text-center">
                          LOTE
                        </th>
                        <th class="text-center">
                          FECHA VENCIMIENTO
                        </th>
                        <th class="text-center">
                          FECHA INGRESO
                        </th>
                        <th class="text-center">
                          COSTO
                        </th>
                        <th class="text-center">
                          PLANTA
                        </th>
                        <th class="text-center">
                          OPCIÓN
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                    <tfoot>
                      <tr>
                        <th class="text-center">
                          #
                        </th>
                        <th class="text-center">
                          RECETA
                        </th>
                        <th class="text-center">
                          CODIGO
                        </th>
                        <th class="text-center">
                          NRO ORDEN
                        </th>
                        <th class="text-center">
                          CANTIDAD
                        </th>
                        <th class="text-center">
                          LOTE
                        </th>
                        <th class="text-center">
                          FECHA VENCIMIENTO
                        </th>
                        <th class="text-center">
                          FECHA INGRESO
                        </th>
                        <th class="text-center">
                          COSTO
                        </th>
                        <th class="text-center">
                          PLANTA
                        </th>
                        <th class="text-center">
                          OPCIÓN
                        </th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <div class="tab-pane" id="ingresosCanastillos">
                  <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                          <div class="text-center">
                            <label>
                              <strong>Seleccione un planta</strong>
                            </label>
                          </div>
                          <select class="form-control" id="id_planta_canastillo">
                            <option value="0">Todas las plantas</option>
                            @foreach($plantas as $planta)
                            <option value="{{$planta->id_planta}}">{{$planta->nombre_planta}}</option>
                            @endforeach
                          </select>                         
                        </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <div class="text-center">
                        <label>
                          <strong>Seleccione Mes</strong>
                        </label>
                      </div>
                        <div class="input-group">
                          <input type="text" class="form-control datepickerMonths" id="id_mes_canastillo" name="id_mes_canastillo" placeholder="Introduzca mes"> 
                          <span class="input-group-btn">
                            <button class="btn btn-primary" type="button" id="busca_mes" onclick="BuscarfechasCanastillo();">Buscar</button>
                          </span>                  
                        </div>         
                      </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                          <div class="text-center">
                            <label><strong>Seleccione Día</strong></label>
                          </div>
                            <div class="input-group">
                              <input type="text" class="form-control datepickerDays" id="id_dia_canastillo" name="id_dia_canastillo" placeholder="Introduzca dia"> 
                              <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="busca_mes" onclick="BuscarDiaCanastillo();">Buscar</button>
                              </span>
                            </div>                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                          <div class="text-center">
                            <label><strong>Seleccione Rango de Fecha</strong></label>
                          </div>
                          <div class="input-group">
                            <div class="col-md-6">
                              <input type="text" class="form-control datepickerDays" id="id_dia_inicio_canastillo" name="id_dia_inicio_canastillo" placeholder="Introduzca dia">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control datepickerDays" id="id_dia_fin_canastillo" name="id_dia_fin_canastillo" placeholder="Introduzca dia">  
                            </div>
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="busca_mes" onclick="BuscarRangoCanastillo();">Buscar</button>
                            </span>
                          </div>                            
                        </div>
                    </div>
                  </div>
                  <div class="ocultarBotonDescargasIngresosCanas" style="display: none;">
                    <a href="" class="btn btn-danger pdfMesIngresosCanas" target="_blank"><span class="fa fa-file-pdf-o"> DESCARGAR PDF</span></a>
                    <a href="" class="btn btn-success excelMesIngresosCanas"><span class="fa fa-file-excel-o"> DESCARGAR EXCEL</span></a>
                  </div>
                  <br>
                  <table class="table table-hover table-striped table-condensed cf" style="width: 100%" id="lts-canastillo">
                    <thead class="cf">
                      <tr>
                        <th class="text-center">
                          #
                        </th>
                        <th class="text-center">
                          CANASTILLO
                        </th>
                        <th class="text-center">
                          NRO. INGRESO
                        </th>
                        <th class="text-center">
                          CANTIDAD
                        </th>
                        <th class="text-center">
                          ORIGEN
                        </th>
                        <th class="text-center">
                          PRODUCTO
                        </th>
                        <th class="text-center">
                          FECHA INGRESO
                        </th>
                        <th class="text-center">
                          CONDUCTOR
                        </th>
                        <th class="text-center">
                          IMAGEN
                        </th>
                        <th class="text-center">
                          OPCIÓN
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                    <tfoot>
                      <tr>
                        <th class="text-center">
                          #
                        </th>
                        <th class="text-center">
                          CANASTILLO
                        </th>
                        <th class="text-center">
                          NRO. INGRESO
                        </th>
                        <th class="text-center">
                          CANTIDAD
                        </th>
                        <th class="text-center">
                          ORIGEN
                        </th>
                        <th class="text-center">
                          PRODUCTO
                        </th>
                        <th class="text-center">
                          FECHA INGRESO
                        </th>
                        <th class="text-center">
                          CONDUCTOR
                        </th>
                        <th class="text-center">
                          IMAGEN
                        </th>
                        <th class="text-center">
                          OPCIÓN
                        </th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="despachos">
            <div class="box">
              <div class="box-header with-border text-center">
                  <h3 class="box-title" style="color: #2067b4">
                      <strong>DESPACHOS</strong>
                  </h3>
                  <ul class="nav nav-tabs">
                    <li class="active" id="despachoOrps">
                      <a data-toggle="tab" href="#despachoOrp" class="btn btn-primary" style="font-size: 11px">
                        DESPACHO ORP <span class="glyphicon glyphicon-inbox"></span>
                      </a>
                    </li>
                    <li id="despachoPts">
                      <a data-toggle="tab" href="#despachoPt" class="btn btn-primary" style="font-size: 11px">
                        DESPACHO PRODUCTO TERMINADO <span class="glyphicon glyphicon-inbox"></span>
                      </a>
                    </li>
                    <li id="despachoCanastilloss">
                      <a data-toggle="tab" href="#despachoCanastillos" class="btn btn-primary" style="font-size: 11px">
                        DESPACHO CANASTILLOS <span class="glyphicon glyphicon-shopping-cart"></span>
                      </a>
                    </li>
                  </ul>
              </div>
              <div class="tab-content">
                <div class="tab-pane in active" id="despachoOrp">
                  <table class="table table-hover table-striped table-condensed cf" style="width: 100%" id="lts-despachoOrp">
                    <thead class="cf">
                      <tr>
                        <th class="text-center">
                            #
                        </th>
                        <th class="text-center">
                            PRODUCTO
                        </th>
                        <th class="text-center">
                            COD. ORP
                        </th>
                        <th class="text-center">
                            COD. SALIDA
                        </th>
                        <th class="text-center">
                            CANTIDAD
                        </th>
                        <th class="text-center">
                            ORIGEN
                        </th>
                        <th class="text-center">
                            DESTINO
                        </th>
                        <th class="text-center">
                            LINEA
                        </th>
                        <th class="text-center">
                            OPCIONES
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                    <tfoot>
                      <tr>
                        <th class="text-center">
                            #
                        </th>
                        <th class="text-center">
                            PRODUCTO
                        </th>
                        <th class="text-center">
                            COD. ORP
                        </th>
                        <th class="text-center">
                            COD. SALIDA
                        </th>
                        <th class="text-center">
                            CANTIDAD
                        </th>
                        <th class="text-center">
                            ORIGEN
                        </th>
                        <th class="text-center">
                            DESTINO
                        </th>
                        <th class="text-center">
                            LINEA
                        </th>
                        <th class="text-center">
                            OPCIONES
                        </th>
                      </tr>
                    </tfoot>
                  </table>
                  </div>
                  <div class="tab-pane" id="despachoPt">
                  <table class="table table-hover table-striped table-condensed cf" style="width: 100%" id="lts-solporInsumo">
                    <thead class="cf">
                      <tr>
                        <th class="text-center">
                            #
                        </th>
                        <th class="text-center">
                            PRODUCTO
                        </th>
                        <th class="text-center">
                            COD. ORP
                        </th>
                        <th class="text-center">
                            COD. SALIDA
                        </th>
                        <th class="text-center">
                            CANTIDAD
                        </th>
                        <th class="text-center">
                            ORIGEN
                        </th>
                        <th class="text-center">
                            DESTINO
                        </th>
                        <th class="text-center">
                            LINEA
                        </th>
                        <th class="text-center">
                            OPCIONES
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                    <tfoot>
                      <tr>
                        <th class="text-center">
                            #
                        </th>
                        <th class="text-center">
                            PRODUCTO
                        </th>
                        <th class="text-center">
                            COD. ORP
                        </th>
                        <th class="text-center">
                            COD. SALIDA
                        </th>
                        <th class="text-center">
                            CANTIDAD
                        </th>
                        <th class="text-center">
                            ORIGEN
                        </th>
                        <th class="text-center">
                            DESTINO
                        </th>
                        <th class="text-center">
                            LINEA
                        </th>
                        <th class="text-center">
                            OPCIONES
                        </th>
                      </tr>
                    </tfoot>
                  </table>
                  </div>
                  <div class="tab-pane" id="despachoCanastillos">
                  <table class="table table-hover table-striped table-condensed cf" style="width: 100%" id="lts-solporInsumo">
                    <thead class="cf">
                      <tr>
                        <th class="text-center">
                            #
                        </th>
                        <th class="text-center">
                            NRO. SALIDA
                        </th>
                        <th class="text-center">
                            DESCRIPCIÓN
                        </th>
                        <th class="text-center">
                            MATERIAL
                        </th>
                        <th class="text-center">
                            FOTO
                        </th>
                        <th class="text-center">
                            CANTIDAD
                        </th>
                        <th class="text-center">
                            OPCIONES
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                    <tfoot>
                      <tr>
                        <th class="text-center">
                            #
                        </th>
                        <th class="text-center">
                            NRO. SALIDA
                        </th>
                        <th class="text-center">
                            DESCRIPCIÓN
                        </th>
                        <th class="text-center">
                            MATERIAL
                        </th>
                        <th class="text-center">
                            FOTO
                        </th>
                        <th class="text-center">
                            CANTIDAD
                        </th>
                        <th class="text-center">
                            OPCIONES
                        </th>
                      </tr>
                    </tfoot>
                  </table>
                  </div>
                </div>
                <div class="box-footer clearfix">
                </div>
            </div>
          </div>
                        <div class="tab-pane fade" id="inventarios">
                            <div class="box">
                                <div class="box-header with-border text-center">
                                    <h3 class="box-title">
                                        INVENTARIOS
                                    </h3>
                                </div>
                                <div class="box-body">
                                <div id="no-more-tables">
                                    <table class="table table-hover table-striped table-condensed cf" style="width: 100%" id="lts-solporTraspaso">
                                        <thead class="cf">
                                                <tr>
                                                    <th>
                                                        #
                                                    </th>
                                                    
                                                    <th>
                                                        NRO. ORP
                                                    </th>
                                                    <th>
                                                        NRO. SALIDA
                                                    </th>
                                                    <th>
                                                        FECHA
                                                    </th>
                                                    <th>
                                                        ORIGEN
                                                    </th>
                                                    <th>
                                                        SOLICITANTE
                                                    </th>
                                                    <th>
                                                        ESTADO
                                                    </th>
                                                    <th>
                                                        OPCIONES
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                   <th>
                                                        #
                                                    </th>
                                                    
                                                    <th>
                                                        NRO. ORP
                                                    </th>
                                                    <th>
                                                        NRO. SALIDA
                                                    </th>
                                                    <th>
                                                        FECHA
                                                    </th>
                                                    <th>
                                                        ORIGEN
                                                    </th>
                                                    <th>
                                                        SOLICITANTE
                                                    </th>
                                                    <th>
                                                        ESTADO
                                                    </th>
                                                    <th>
                                                        OPCIONES
                                                    </th>

                                                </tr>
                                            </tfoot>
                                    </table>
                                    </div>
                                </div>
                                <div class="box-footer clearfix">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="mes">
                            <div class="box">
                                <div class="box-header with-border text-center">
                                    <h3 class="box-title">
                                        LISTADO DE MES
                                    </h3>
                                </div>
                                <div class="box-body">
                                <div id="no-more-tables">
                                    <table class="table table-hover table-striped table-condensed cf" style="width: 100%" id="lts-solporMaquila">
                                        <thead class="cf">
                                                <tr>
                                                    <th>
                                                        #
                                                    </th>
                                                    
                                                    <th>
                                                        NRO. ORP
                                                    </th>
                                                    <th>
                                                        NRO SALIDA
                                                    </th>
                                                    <th>
                                                        FECHA
                                                    </th>
                                                    <th>
                                                        DESTINO
                                                    </th>
                                                    <th>
                                                        SOLICITANTE
                                                    </th>
                                                    <th>
                                                        ESTADO
                                                    </th>
                                                    <th>
                                                        OPCIONES
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                     <th>
                                                        #
                                                    </th>
                                                    
                                                    <th>
                                                        NRO. ORP
                                                    </th>
                                                    <th>
                                                        NRO SALIDA
                                                    </th>
                                                    <th>
                                                        FECHA
                                                    </th>
                                                    <th>
                                                        DESTINO
                                                    </th>
                                                    <th>
                                                        SOLICITANTE
                                                    </th>
                                                    <th>
                                                        ESTADO
                                                    </th>
                                                    <th>
                                                        OPCIONES
                                                    </th>

                                                </tr>
                                            </tfoot>
                                    </table>
                                    </div>
                                </div>
                                <div class="box-footer clearfix">
                                </div>
                            </div>
                        </div>
                    </div>
    </div>
<?php 
function lineaProd($id)
{
  if ($id == 1) {
    return "LACTEOS";
  }elseif($id == 2){
    return "ALMENDRA";
  }elseif($id == 3){
    return "MIEL";
  }elseif($id == 4){
    return "FRUTOS";
  }elseif ($id == 5) {
    return "DERIVADOS";
  } 
}
?>
@endsection
@push('scripts')
<script>
//FUNCIONES ORP
function Buscarfechas() {
  console.log($("#id_mes").val());
  console.log($("#id_planta").val());
  $(".ocultarBotonDescargasIngresos").show();
  $(".pdfMesIngresos").attr('href','imprimirPdfIngresosMesGeneralPt/'+$("#id_mes").val()+'/'+$("#id_planta").val());
  $(".excelMesIngresos").attr('href','imprimirExcelIngresoMesGeneralPt/'+$("#id_mes").val()+'/'+$("#id_planta").val());
  var t = $('#lts-orp').DataTable( {
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax":{
               url : "listarMesIngresoGeneralPt/"+ $("#id_mes").val()+'/'+$("#id_planta").val(),
               type: "GET",
               data: {"mes": $("#id_mes").val()}
             },
            "columns":[
                {data: 'ipt_id'},
                {data: 'rece_nombre'}, 
                {data: 'rece_codigo'},
                {data: 'orprod_nro_orden'},
                {data: 'ipt_cantidad'},
                {data: 'ipt_lote'},
                {data: 'ipt_fecha_vencimiento'},
                {data: 'ipt_registrado'},
                {data: 'ipt_costo_unitario'},
                {data: 'nombre_planta'},
                {data: 'acciones'}
        ],
        
        "language": {
             "url": "/lenguaje"
        },
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        // "order": [[ 0, "desc" ]],
        "paging":   true,
        "ordering": true,
        "info":     true       
  });
  t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
  } ).draw();
}
function BuscarDia() {
  console.log($("#id_dia").val());
  console.log($("#id_planta").val());
  $(".ocultarBotonDescargasIngresos").show();
  $(".pdfMesIngresos").attr('href','imprimirPdfIngresosDiaGeneralPt/'+$("#id_dia").val()+'/'+$("#id_planta").val());
  $(".excelMesIngresos").attr('href','imprimirExcelIngresoDiaGeneralPt/'+$("#id_dia").val()+'/'+$("#id_planta").val());
  var t = $('#lts-orp').DataTable( {
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax":{
               url : "listarDiaIngresoGeneralPt/"+ $("#id_dia").val()+'/'+$("#id_planta").val(),
               type: "GET",
               data: {"mes": $("#id_dia").val()}
             },
            "columns":[
                {data: 'ipt_id'},
                {data: 'rece_nombre'}, 
                {data: 'rece_codigo'},
                {data: 'orprod_nro_orden'},
                {data: 'ipt_cantidad'},
                {data: 'ipt_lote'},
                {data: 'ipt_fecha_vencimiento'},
                {data: 'ipt_registrado'},
                {data: 'ipt_costo_unitario'},
                {data: 'nombre_planta'},
                {data: 'acciones'}
        ],
        
        "language": {
             "url": "/lenguaje"
        },
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        // "order": [[ 0, "desc" ]],
        "paging":   true,
        "ordering": true,
        "info":     true       
  });
  t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
  } ).draw();
}

function BuscarRango() {
  console.log($("#id_dia_inicio").val());
  console.log($("#id_dia_fin").val());
  console.log($("#id_planta").val());
  $(".ocultarBotonDescargasIngresos").show();
  $(".pdfMesIngresos").attr('href','imprimirPdfIngresoRangoAlmacenPt/'+$("#id_dia_inicio").val()+'/'+$("#id_dia_fin").val()+'/'+$("#id_planta").val());
  $(".excelMesIngresos").attr('href','imprimirExcelIngresoRangoAlmacenPt/'+$("#id_dia_inicio").val()+'/'+$("#id_dia_fin").val()+'/'+$("#id_planta").val());
  var t = $('#lts-orp').DataTable( {
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax":{
               url : "listarRangoIngresoGeneralPt/"+$("#id_dia_inicio").val()+'/'+$("#id_dia_fin").val()+'/'+$("#id_planta").val(),
               type: "GET",
               data: {"mes": $("#id_dia").val()}
             },
            "columns":[
                {data: 'ipt_id'},
                {data: 'rece_nombre'}, 
                {data: 'rece_codigo'},
                {data: 'orprod_nro_orden'},
                {data: 'ipt_cantidad'},
                {data: 'ipt_lote'},
                {data: 'ipt_fecha_vencimiento'},
                {data: 'ipt_registrado'},
                {data: 'ipt_costo_unitario'},
                {data: 'nombre_planta'},
                {data: 'acciones'}
        ],
        
        "language": {
             "url": "/lenguaje"
        },
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        // "order": [[ 0, "desc" ]],
        "paging":   true,
        "ordering": true,
        "info":     true       
  });
  t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
  } ).draw();
}
//FUNCIONES CANASTILLO
function BuscarfechasCanastillo() {
  console.log($("#id_mes_canastillo").val());
  console.log($("#id_planta_canastillo").val());
  $(".ocultarBotonDescargasIngresosCanas").show();
  $(".pdfMesIngresosCanas").attr('href','imprimirPdfIngresosCanasMesAlmacenPt/'+$("#id_mes_canastillo").val()+'/'+$("#id_planta_canastillo").val());
  $(".excelMesIngresosCanas").attr('href','imprimirExcelIngresosCanasMesAlmacenPt/'+$("#id_mes_canastillo").val()+'/'+$("#id_planta_canastillo").val());
  var t = $('#lts-canastillo').DataTable( {
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax":{
               url : "listarMesIngresoCanatilloGeneralPt/"+ $("#id_mes_canastillo").val()+'/'+$("#id_planta_canastillo").val(),
               type: "GET",
               data: {"mes": $("#id_mes_canastillo").val()}
             },
            "columns":[
                {data: 'iac_id'},
                {data: 'ctl_descripcion'}, 
                {data: 'iac_nro_ingreso'},
                {data: 'iac_cantidad'},
                {data: 'nombre_planta'},
                {data: 'producto'},
                {data: 'iac_fecha_ingreso'},
                {data: 'conductor'},
                {data: 'ctl_foto_canastillo',
                  'targets': [15,16],
                  'searchable': false,
                  'orderable':false,
                  'render': function (data, type, full, meta) {
                      return '<img src=archivo/canastillo/'+data+' class="img-circle" style=" width: 50px;"/>';
                  }
                },
                {data: 'acciones'}
        ],
        
        "language": {
             "url": "/lenguaje"
        },
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        // "order": [[ 0, "desc" ]],
        "paging":   true,
        "ordering": true,
        "info":     true       
  });
  t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
  } ).draw();
}
function BuscarDiaCanastillo() {
  console.log($("#id_dia_canastillo").val());
  console.log($("#id_planta_canastillo").val());
  $(".ocultarBotonDescargasIngresosCanas").show();
  $(".pdfMesIngresosCanas").attr('href','imprimirPdfIngresosCanasDiaAlmacenPt/'+$("#id_dia_canastillo").val()+'/'+$("#id_planta_canastillo").val());
  $(".excelMesIngresosCanas").attr('href','imprimirExcelIngresosCanasDiaAlmacenPt/'+$("#id_dia_canastillo").val()+'/'+$("#id_planta_canastillo").val());
  var t = $('#lts-canastillo').DataTable( {
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax":{
               url : "listarDiaIngresoCanatilloGeneralPt/"+ $("#id_dia_canastillo").val()+'/'+$("#id_planta_canastillo").val(),
               type: "GET",
               data: {"mes": $("#id_dia_canastillo").val()}
             },
            "columns":[
                {data: 'iac_id'},
                {data: 'ctl_descripcion'}, 
                {data: 'iac_nro_ingreso'},
                {data: 'iac_cantidad'},
                {data: 'nombre_planta'},
                {data: 'producto'},
                {data: 'iac_fecha_ingreso'},
                {data: 'conductor'},
                {data: 'ctl_foto_canastillo',
                  'targets': [15,16],
                  'searchable': false,
                  'orderable':false,
                  'render': function (data, type, full, meta) {
                      return '<img src=archivo/canastillo/'+data+' class="img-circle" style=" width: 50px;"/>';
                  }
                },
                {data: 'acciones'}
        ],
        
        "language": {
             "url": "/lenguaje"
        },
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        // "order": [[ 0, "desc" ]],
        "paging":   true,
        "ordering": true,
        "info":     true       
  });
  t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
  } ).draw();
}
function BuscarRangoCanastillo() {
  console.log($("#id_dia_inicio_canastillo").val());
  console.log($("#id_dia_fin_canastillo").val());
  console.log($("#id_planta_canastillo").val());
  $(".ocultarBotonDescargasIngresosCanas").show();
  $(".pdfMesIngresosCanas").attr('href','imprimirPdfIngresosCanasRangoAlmacenPt/'+$("#id_dia_inicio_canastillo").val()+'/'+$("#id_dia_fin_canastillo").val()+'/'+$("#id_planta_canastillo").val());
  $(".excelMesIngresosCanas").attr('href','imprimirExcelIngresosCanasRangoAlmacenPt/'+$("#id_dia_inicio_canastillo").val()+'/'+$("#id_dia_fin_canastillo").val()+'/'+$("#id_planta_canastillo").val());
  var t = $('#lts-canastillo').DataTable( {
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax":{
               url : "listarRangoIngresoCanatilloGeneralPt/"+ $("#id_dia_inicio_canastillo").val()+'/'+$("#id_dia_fin_canastillo").val()+'/'+$("#id_planta_canastillo").val(),
               type: "GET",
               data: {"mes": $("#id_dia_inicio_canastillo").val()}
             },
            "columns":[
                {data: 'iac_id'},
                {data: 'ctl_descripcion'}, 
                {data: 'iac_nro_ingreso'},
                {data: 'iac_cantidad'},
                {data: 'nombre_planta'},
                {data: 'producto'},
                {data: 'iac_fecha_ingreso'},
                {data: 'conductor'},
                {data: 'ctl_foto_canastillo',
                  'targets': [15,16],
                  'searchable': false,
                  'orderable':false,
                  'render': function (data, type, full, meta) {
                      return '<img src=archivo/canastillo/'+data+' class="img-circle" style=" width: 50px;"/>';
                  }
                },
                {data: 'acciones'}
        ],
        
        "language": {
             "url": "/lenguaje"
        },
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        // "order": [[ 0, "desc" ]],
        "paging":   true,
        "ordering": true,
        "info":     true       
  });
  t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
  } ).draw();
}
$('.datepickerMonths').datepicker({
        format: "mm/yyyy",
        viewMode: "months", 
        minViewMode: "months",
        language: "es",
    }).datepicker("setDate", new Date()); 

    $('.datepickerDays').datepicker({
        format: "dd/mm/yyyy",        
        language: "es",
    }).datepicker("setDate", new Date()); 
</script>
@endpush

