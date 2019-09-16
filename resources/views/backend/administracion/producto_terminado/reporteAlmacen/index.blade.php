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
        <!--<div class="alert alert-danger">
            <button type="button" class="close">&times;</button>
            <strong>REPORTES</strong> Seleccione la opcion
        </div>-->
        <div class="tab-content">
                      <div class="tab-pane fade in active" id="ingresos">
                       <div class="box">
                                <div class="box-header with-border text-center">
                                    <h3 class="box-title">
                                        LISTADO DE TODOS LOS INGRESOS
                                    </h3>

                                </div>
                            <div id="no-more-tables">
                                <table class="table table-hover table-striped table-condensed cf" style="width: 100%" id="lts-orp">
                                    <thead class="cf">
                                                <tr>
                                                    <th>
                                                        #
                                                    </th>
                                                    <th>
                                                        RECETA
                                                    </th>
                                                    <th>
                                                        CODIGO
                                                    </th>
                                                    <th>
                                                        NRO ORDEN
                                                    </th>
                                                    <th>
                                                        CANTIDAD
                                                    </th>
                                                    <th>
                                                      LOTE
                                                    </th>
                                                    <th>
                                                      FECHA VENCIMIENTO
                                                    </th>
                                                    <th>
                                                      COSTO
                                                    </th>
                                                    <th>
                                                      OPCIÓN
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($ingresoOrp as $io)
                                              <tr>
                                                <td>{{$io->ipt_id}}</td>
                                                <td>{{$io->rece_nombre.' '.$io->sab_nombre.' '.$io->rece_presentacion}}</td>
                                                <td>{{$io->rece_codigo}}</td>
                                                <td>{{$io->orprod_nro_orden}}</td>
                                                <td>{{$io->ipt_cantidad}}</td>
                                                <td>{{$io->ipt_lote}}</td>
                                                <td>{{$io->ipt_fecha_vencimiento}}</td>
                                                <td>{{$io->ipt_costo_unitario}}</td>
                                                <td><a href="imprimirBoletaIngreso/{{$io->ipt_id}}" target="_blank" class="btn btn-primary fa fa-file"></a></td>
                                              </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>
                                                        #
                                                    </th>
                                                    <th>
                                                        RECETA
                                                    </th>
                                                    <th>
                                                        CODIGO
                                                    </th>
                                                    <th>
                                                        NRO ORDEN
                                                    </th>
                                                    <th>
                                                        CANTIDAD
                                                    </th>
                                                    <th>
                                                      LOTE
                                                    </th>
                                                    <th>
                                                      FECHA VENCIMIENTO
                                                    </th>
                                                    <th>
                                                      COSTO
                                                    </th>
                                                    <th>
                                                      OPCIÓN
                                                    </th>
                                                </tr>
                                            </tfoot>
                                </table>
                            </div>
                        </div>
                        </div>
                        <div class="tab-pane fade" id="despachos">
                            <div class="box">
                                <div class="box-header with-border text-center">
                                    <h3 class="box-title">
                                        LISTADO DE TODOS LOS DESPACHOS
                                    </h3>
                                </div>
                                <div class="box-body">
                                 <div id="no-more-tables">
                                    <table class="table table-hover table-striped table-condensed cf" style="width: 100%" id="lts-solporInsumo">
                                        <thead class="cf">
                                                <tr>
                                                    <th>
                                                        #
                                                    </th>
                                                    <th>
                                                        NRO. ORP
                                                    </th>
                                                    <th>
                                                        FECHA SOLICITUD
                                                    </th>
                                                    <th>
                                                        NRO. SALIDA
                                                    </th>
                                                    <th>
                                                        FECHA ENTREGA
                                                    </th>
                                                    <th>
                                                        PRODUCTO PRODUCIR
                                                    </th>
                                                    <th>
                                                        CANTIDAD
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
                                                        FECHA SOLICITUD
                                                    </th>
                                                    <th>
                                                        NRO. SALIDA
                                                    </th>
                                                    <th>
                                                        FECHA ENTREGA
                                                    </th>
                                                    <th>
                                                        PRODUCTO PRODUCIR
                                                    </th>
                                                    <th>
                                                        CANTIDAD
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
</script>
@endpush

