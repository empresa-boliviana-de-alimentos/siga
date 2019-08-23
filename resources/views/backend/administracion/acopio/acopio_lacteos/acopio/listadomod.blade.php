@extends('backend.template.app')
@section('main-content')
@include('backend.administracion.acopio.acopio_lacteos.acopio.partials.modalCreate')

<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-1">
                    <a type="button" class="btn btn-dark"  style ="background: #000000;" href="{{ url('AcopioLacteos') }}"><span class="fa fas fa-angle-double-left" style="color: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;ATRAS</h7></a>
                </div>
                <div class="col-md-6">
                     <h3><label for="box-title">Acopios Lacteos Proveedores</label></h3>
                </div>
                <div class="col-md-4">
                     <a class="btn btn-danger" href="BoletaAcopiodia" target="_blank" class="btn btn-primary fa fa-print">Generar Reporte Diario</a>
                      <?php  
                     date_default_timezone_set('America/New_York');
                     $fechact=date('Y-m-d');
                     //echo $dat;
                    // echo $fechact;
                     if($fechact==$fecha)
                     { 
                        echo  '<div class="hidden" id="contenido">';
                        echo'<button class="btn btn-success" data-target="#myCreateRTOT" data-toggle="modal"  type="button" onClick="MostrarCantidades2();">Enviar Registros del dia</button>' ;
                        echo '</div>';
                     }
                     else
                     {
                        echo'<button class="btn btn-success" data-target="#myCreateRTOT" data-toggle="modal"  type="button" onClick="MostrarCantidades2();">Enviar Registros del dia</button>' ;
                     }
                    ?>  
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
 <div class="modal-body">
                <div class="caption">
                       {!! Form::open(['id'=>'acopio'])!!}
                        <input id="token" name="csrf-token" type="hidden" value="{{ csrf_token() }}">
                            <input id="id" name="prsid" type="hidden" value="">
                                <div class="row">
                                    <div class="col-md-12">
                                         <div class="col-sm-12">
                                            <h4><b>MODULO:</b></h4>  
                                            <h3><b>{{$proveedor->prov_nombre}} {{$proveedor->prov_ap}} {{$proveedor->prov_am}}</b></h3>                                 
                                        </div>
                                    </div>
                                    
                                </div>

                            </input>
                        </input>
                </div>
                <table class="col-md-12 table-bordered table-striped table-condensed cf" style="font-size:7" id="lts-acoprov">
                    <thead class="table_head">
                    <tr >
                        <th style="width:250px" >Opciones</th>
                        <th>Proveedor</th>
                        <th>Ci</th>  
                        <th>Telefono</th>
                        <th>Lugar</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if($proveedor->count())  
                        @foreach($proveedor as $reg)
                        <tr>
                            <td><button type="button"  class="btn btn-primary btn-sm" style="background:#F5B041; width:100px" data-toggle="modal" data-target="#myCreateRCA">REGISTRAR</button> <a class="btn btn-primary btn-sm" onClick="lstacopiolact(this);" style="background:#5499C7; width:100px;" href="AcopioLacteos/listar/' . $proveedor->prov_id . '">LISTA</a></td>
                            <td class="text-center">PROVEEDOR LACTEOS LACTEOS</td>
                            <td class="text-center">55555555</td>
                            <td class="text-center">77777777</td>
                            <td class="text-center">COCHABAMBA</td>
                        </tr>
                        @endforeach 
                        @else
                        <tr>
                            <td colspan="8">No hay registro !!</td>
                        </tr>
                        @endif  
                    </tbody>
                </table>
            </div>
@endsection

@push('scripts')
<script>
    

</script>
@endpush

