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
              </div>
              <div class="box-body">
                <div id="no-more-tables">
                  <table class="table table-hover table-striped table-condensed cf" style="width: 100%" id="lts-solporInsumo">
                    <thead class="cf">
                      <tr>
                        <th class="text-center">
                            #
                        </th>
                        <th class="text-center">
                            NRO. ORP
                        </th>
                        <th class="text-center">
                            FECHA SOLICITUD
                        </th>
                        <th class="text-center">
                            NRO. SALIDA
                        </th>
                        <th class="text-center">
                            FECHA ENTREGA
                        </th>
                        <th class="text-center">
                            PRODUCTO PRODUCIR
                        </th>
                        <th class="text-center">
                            CANTIDAD
                        </th>
                        <th class="text-center">
                            SOLICITANTE
                        </th>
                        <th class="text-center">
                            ESTADO
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
                            NRO. ORP
                        </th>
                        <th class="text-center">
                            FECHA SOLICITUD
                        </th>
                        <th class="text-center">
                            NRO. SALIDA
                        </th>
                        <th class="text-center">
                            FECHA ENTREGA
                        </th>
                        <th class="text-center">
                            PRODUCTO PRODUCIR
                        </th>
                        <th class="text-center">
                            CANTIDAD
                        </th>
                        <th class="text-center">
                            SOLICITANTE
                        </th>
                        <th class="text-center">
                            ESTADO
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
</script>
@endpush

