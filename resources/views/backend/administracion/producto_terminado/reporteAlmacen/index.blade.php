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
                <div class="pull-left"><h5><i class="fa fa-tasks"></i><b>&nbsp;&nbsp;REPORTE ALMACEN</b></h5></div>
            <br>
            </div>
            <input type="hidden" id="usr_id" name="usr_id" value="{{ Auth::user()->usr_id }}"/>
            <div class="panel-body">
              <div class="task-content">
                  <ul id="sortable" class="task-list ui-sortable">
                      <li class="list-primary" style="background: #ccc">
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
                      <li class="list-danger" style="background: #ccc">
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
                      <li class="list-success" style="background: #ccc">
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
                      <li class="list-warning" style="background: #ccc">
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
                          COSTO
                        </th>
                        <th class="text-center">
                          OPCIÓN
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($ingresoOrp as $io)
                      <tr>
                        <td class="text-center">{{$io->ipt_id}}</td>
                        <td class="text-center">{{$io->rece_nombre.' '.$io->sab_nombre.' '.$io->rece_presentacion}}</td>
                        <td class="text-center">{{$io->rece_codigo}}</td>
                        <td class="text-center">{{$io->orprod_nro_orden}}</td>
                        <td class="text-center">{{$io->ipt_cantidad}}</td>
                        <td class="text-center">{{$io->ipt_lote}}</td>
                        <td class="text-center">{{$io->ipt_fecha_vencimiento}}</td>
                        <td class="text-center">{{$io->ipt_costo_unitario}}</td>
                        <td class="text-center"><a href="imprimirBoletaIngreso/{{$io->ipt_id}}" target="_blank" class="btn btn-primary fa fa-file"></a></td>
                      </tr>
                    @endforeach
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
                          COSTO
                        </th>
                        <th class="text-center">
                          OPCIÓN
                        </th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                <div class="tab-pane" id="ingresosCanastillos">
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
                    @foreach($ingresoCanastillos as $ic)
                      <tr>
                        <td class="text-center">{{$ic->iac_id}}</td>
                        <td class="text-center">{{$ic->ctl_descripcion}}</td>
                        <td class="text-center">{{$ic->iac_nro_ingreso}}</td>
                        <td class="text-center">{{$ic->iac_cantidad}}</td>
                        <td class="text-center">{{$ic->nombre_planta}}</td>
                        <td class="text-center">{{$ic->producto}}</td>
                        <td class="text-center">{{$ic->iac_fecha_ingreso}}</td>
                        <td class="text-center">{{$ic->conductor}}</td>
                        <td class="text-center"><img src="archivo/canastillo/{{$ic->ctl_foto_canastillo}}" class="img-circle" style=" width: 50px;"></td>
                        <td class="text-center"><a href="imprimirBoletaIngresoCanastillo/{{$ic->iac_id}}" target="_blank" class="btn btn-primary fa fa-file"></a></td>
                      </tr>
                    @endforeach
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
                    @foreach($despachoORP as $dorp)
                    <tr>
                      <td class="text-center">{{$dorp->dao_id}}</td>
                      <td class="text-center">{{$dorp->rece_nombre}}</td>
                      <td class="text-center">{{$dorp->rece_codigo}}</td>
                      <td class="text-center">{{$dorp->dao_codigo_salida}}</td>
                      <td class="text-center">{{$dorp->dao_cantidad}}</td>
                      <td class="text-center">{{$dorp->origen}}</td>
                      <td class="text-center">{{$dorp->destino}}</td>
                      <td class="text-center">{{lineaProd($dorp->rece_lineaprod_id)}}</td>
                      <td class="text-center"><a href="imprimirBoletaDespachoOrp/{{$dorp->dao_id}}" target="_blank" class="btn btn-primary fa fa-file"></a></td>
                    </tr>
                    @endforeach
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
                  <table class="table table-hover table-striped table-condensed cf" style="width: 100%" id="lts-despachoPt">
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
                    @foreach($despachoPT as $dpt)
                    <tr>
                      <td class="text-center">{{$dpt->dao_id}}</td>
                      <td class="text-center">{{$dpt->rece_nombre}}</td>
                      <td class="text-center">{{$dpt->rece_codigo}}</td>
                      <td class="text-center">{{$dpt->dao_codigo_salida}}</td>
                      <td class="text-center">{{$dpt->dao_cantidad}}</td>
                      <td class="text-center">{{$dpt->origen}}</td>
                      <td class="text-center">{{$dpt->destino}}</td>
                      <td class="text-center">{{lineaProd($dpt->rece_lineaprod_id)}}</td>
                      <td class="text-center"><a href="imprimirBoletaDepsachoPt/{{$dorp->dao_id}}" target="_blank" class="btn btn-primary fa fa-file"></a></td>
                    </tr>
                    @endforeach
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
                  <table class="table table-hover table-striped table-condensed cf" style="width: 100%" id="lts-despachoCanastillos">
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
                    @foreach($datosCanastillas as $dc)
                    <tr>
                      <td class="text-center">{{$dc->iac_id}}</td>
                      <td class="text-center">{{$dc->iac_codigo_salida}}</td>
                      <td class="text-center">{{$dc->ctl_descripcion}}</td>
                      <td class="text-center">{{$dc->ctl_material}}</td>
                      <td class="text-center"><img src="archivo/canastillo/{{$dc->ctl_foto_canastillo}}" class="img-circle" style=" width: 50px;"></td>
                      <td class="text-center">{{$dc->iac_cantidad}}</td>
                      <td class="text-center"><a href="imprimirBoletaDespachoCanasPt/{{$dc->iac_id}}" target="_blank" class="btn btn-primary fa fa-file"></a></td>
                    </tr>
                    @endforeach
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
                  <h3 class="box-title" style="color: #2067b4">
                    <strong>INVENTARIOS</strong>
                  </h3>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="input-group">
                          <div class="input-group">
                              <input type="text" class="form-control datepickerMonths" id="id_mes" name="id_mes" placeholder="Introduzca mes"> 
                          <span class="input-group-btn">
                              <button class="btn btn-primary" type="button" id="busca_mes" onclick="Buscarfechas();">Buscar por Mes</button>
                          </span>
                          </div>                            
                      </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <div class="input-group">
                                <input type="text" class="form-control datepickerDays" id="id_dia" name="id_dia" placeholder="Introduzca dia"> 
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" id="busca_mes" onclick="BuscarDia();">Buscar por Dia</button>
                            </span>
                            </div>                            
                        </div>
                    </div>
                    <div class="col-md-6">
                      <div class="input-group">
                        <div class="input-group">
                          <div class="col-md-6">
                            <input type="text" class="form-control datepickerDays" id="id_dia_inicio" name="id_dia_inicio" placeholder="Introduzca dia">
                          </div>
                            <div class="col-md-6">
                              <input type="text" class="form-control datepickerDays" id="id_dia_fin" name="id_dia_fin" placeholder="Introduzca dia">  
                            </div>
                            <span class="input-group-btn">
                              <button class="btn btn-primary" type="button" id="busca_mes" onclick="BuscarRango();">Buscar rango fechas</button>
                            </span>
                        </div>                            
                      </div>
                    </div>
                  </div>
              </div>
              <div class="box-body">
                <div id="no-more-tables">
                  <div class="ocultarBotonDescargas" style="display: none;">
                    <a href="" class="btn btn-danger pdfMes" target="_blank"><span class="fa fa-file-pdf-o"> DESCARGAR PDF</span></a>
                    <a href="" class="btn btn-success excelMes"><span class="fa fa-file-excel-o"> DESCARGAR EXCEL</span></a>
                  </div>
                  <table class="table table-hover table-striped table-condensed cf" style="width: 100%" id="lts-inventario">
                    <thead class="cf">
                      <tr>
                        <th>
                          #
                        </th>                                                    
                        <th>
                          CODIGO
                        </th>
                        <th>
                          PRODUCTO
                        </th>
                        <th>
                          CANTIDAD
                        </th>
                        <th>
                          FECHA VENCIMIENTO
                        </th>
                        <th>
                          FECHA REGISTRO
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
                          CODIGO
                        </th>
                        <th>
                          PRODUCTO
                        </th>
                        <th>
                          CANTIDAD
                        </th>
                        <th>
                          FECHA VENCIMIENTO
                        </th>
                        <th>
                          FECHA REGISTRO
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
            <div class="row">
              <div class="col-md-4"></div>
              <div class="col-md-4">
                <div class="input-group">
                  <div class="input-group">
                    <input type="text" class="form-control datepickerMonths" id="id_mes_dos" name="id_mes_dos" placeholder="Introduzca mes"> 
                    <span class="input-group-btn">
                      <button class="btn btn-primary" type="button" id="busca_mes" onclick="BuscarfechasMes();">Buscar por Mes</button>
                    </span>
                  </div>                            
                </div>
              </div>
              <div class="col-md-4"></div>
            </div>
              
            <div class="box-body">
              <div id="no-more-tables">
                <div class="ocultarBotonDescargasMes" style="display: none;">
                    <a href="" class="btn btn-danger pdfMesdos" target="_blank"><span class="fa fa-file-pdf-o"> DESCARGAR PDF</span></a>
                    <a href="" class="btn btn-success excelMesdos"><span class="fa fa-file-excel-o"> DESCARGAR EXCEL</span></a>
                </div>
                <table class="table table-hover table-striped table-condensed cf" style="width: 100%" id="lts-porMes">
                  <thead class="cf">
                    <tr>
                      <th>
                          #
                        </th>                                                    
                        <th>
                          CODIGO
                        </th>
                        <th>
                          PRODUCTO
                        </th>
                        <th>
                          CANTIDAD
                        </th>
                        <th>
                          FECHA VENCIMIENTO
                        </th>
                        <th>
                          FECHA REGISTRO
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
                          CODIGO
                        </th>
                        <th>
                          PRODUCTO
                        </th>
                        <th>
                          CANTIDAD
                        </th>
                        <th>
                          FECHA VENCIMIENTO
                        </th>
                        <th>
                          FECHA REGISTRO
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
var t = $('#lts-orp').DataTable( {                
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "order": [[ 0, 'desc' ]],
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

    });
   t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();   
var t = $('#lts-canastillo').DataTable( {                 
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "order": [[ 0, 'desc' ]],
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

    });
   t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
var t = $('#lts-despachoOrp').DataTable( {                   
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "order": [[ 0, 'desc' ]],
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

    });
   t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
var t = $('#lts-despachoPt').DataTable( {
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "order": [[ 0, 'desc' ]],
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

    });
   t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
var t = $('#lts-despachoCanastillos').DataTable( {                  
        "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        "order": [[ 0, 'desc' ]],
        "language": {
             "url": "/lenguaje"
        },
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

    });
   t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
/*AJAX DE INVENTARIOS*/
function Buscarfechas() {
  console.log($("#id_mes").val());
  $(".ocultarBotonDescargas").show();
  $(".pdfMes").attr('href','imprimirPdfInventarioMesAlmacenPt/'+$("#id_mes").val());
  $(".excelMes").attr('href','imprimirExcelInventarioMesAlmacenPt/'+$("#id_mes").val());
  var t = $('#lts-inventario').DataTable( {
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax":{
               url : "listarMesInventarioPt/"+ $("#id_mes").val(),
               type: "GET",
               data: {"mes": $("#id_mes").val()}
             },
            "columns":[
                {data: 'spth_id'},
                {data: 'rece_codigo'}, 
                {data: 'rece_nombre'},
                {data: 'spth_cantidad'},
                {data: 'spth_fecha_vencimiento'},
                {data: 'spth_registrado'}
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
  $(".ocultarBotonDescargas").show();
  $(".pdfMes").attr('href','imprimirPdfInventarioDiaAlmacenPt/'+$("#id_dia").val());  
  $(".excelMes").attr('href','imprimirExcelInventarioDiaAlmacenPt/'+$("#id_dia").val());
  var t = $('#lts-inventario').DataTable( {
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax":{
               url : "listarDiaInventarioPt/"+ $("#id_dia").val(),
               type: "GET",
               data: {"mes": $("#id_dia").val()}
             },
            "columns":[
                {data: 'spth_id'},
                {data: 'rece_codigo'}, 
                {data: 'rece_nombre'},
                {data: 'spth_cantidad'},
                {data: 'spth_fecha_vencimiento'},
                {data: 'spth_registrado'}
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
  console.log($("#id_dia_inicio").val()+"/"+$("#id_dia_fin").val());
  $(".ocultarBotonDescargas").show();
  $(".pdfMes").attr('href','imprimirPdfInventarioRangoAlmacenPt/'+$("#id_dia_inicio").val()+"/"+$("#id_dia_fin").val());
  $(".excelMes").attr('href','imprimirExcelInventarioRangoAlmacenPt/'+$("#id_dia_inicio").val()+"/"+$("#id_dia_fin").val());
  var t = $('#lts-inventario').DataTable( {
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax":{
               url : "listarRangoInventarioPt/"+$("#id_dia_inicio").val()+"/"+$("#id_dia_fin").val(),
               type: "GET",
               data: {"dia_inicio": $("#id_dia_inicio").val()},
               data: {"dia_fin": $("#id_dia_fin").val()}
             },
            "columns":[
                {data: 'spth_id'},
                {data: 'rece_codigo'}, 
                {data: 'rece_nombre'},
                {data: 'spth_cantidad'},
                {data: 'spth_fecha_vencimiento'},
                {data: 'spth_registrado'}
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
/*INVENTARIO POR MES*/
function BuscarfechasMes() {
  console.log($("#id_mes_dos").val());
  $(".ocultarBotonDescargasMes").show();
  $(".pdfMesdos").attr('href','imprimirPdfInventarioMesAlmacenPt/'+$("#id_mes_dos").val());
  $(".excelMesdos").attr('href','imprimirExcelInventarioMesAlmacenPt/'+$("#id_mes_dos").val());
  var t = $('#lts-porMes').DataTable( {
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ajax":{
               url : "listarMesInventarioPt/"+ $("#id_mes_dos").val(),
               type: "GET",
               data: {"mes": $("#id_mes_dos").val()}
             },
            "columns":[
                {data: 'spth_id'},
                {data: 'rece_codigo'}, 
                {data: 'rece_nombre'},
                {data: 'spth_cantidad'},
                {data: 'spth_fecha_vencimiento'},
                {data: 'spth_registrado'}
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

