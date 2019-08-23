@extends('backend.template.app')
@section('main-content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-1">
                    <a type="button" class="btn btn-dark"  style="background: #000000;" href="{{ URL::previous() }}"><span class="fa fas fa-angle-double-left" style="color: #ffffff;"></span><h7 style="color:#ffffff">&nbsp;&nbsp;ATRAS</h7></a>
                </div>
                <div class="col-md-8">
                     <h3><label for="box-title">Acopios Lacteos Proveedores</label></h3>
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
                                            <h4><b>PROVEEDOR: {{ $proveedor_datos->prov_nombre }} {{ $proveedor_datos->prov_ap }} {{ $proveedor_datos->prov_am }}</b></h4>                                  
                                        </div>
                                    </div>
                                    
                                </div>

                            </input>
                        </input>
                </div>
                <table class="col-md-12 table-bordered table-striped table-condensed cf" style="font-size:7" id="lts-acoprov">
                    <thead class="table_head">
                    <tr >
                        <th class="text-center">No</th>
                        <th class="text-center">Fecha</th>
                        <th class="text-center">Hora</th>  
                        <th class="text-center">Cant</th>
                        <!-- <th>Temp</th> -->
                        <th class="text-center">SNG</th>
                        <th class="text-center">PAL</th>
                        <th class="text-center">Aspecto</th>
                        <th class="text-center">Color</th>
                        <th class="text-center">Olor</th>
                        <th class="text-center">Sabor</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if($acopios_proveedor->count())
                        <?php $nro = 0; ?>  
                        @foreach($acopios_proveedor as $reg)
                        <?php $nro = $nro + 1; ?>
                        <tr>
                            <td class="text-center">{{$nro}}</td>
                            <td class="text-center">{{$reg->dac_fecha_acop}}</td>
                            <td class="text-center">{{$reg->dac_hora}}</td>
                            <td class="text-center">{{$reg->dac_cant_uni}}</td>
                            <!-- <td class="text-center">{{$reg->dac_tem}}</td> -->
                            <td class="text-center">{{$reg->dac_sng}}</td>
                            @if($reg->dac_palc==1)
                            <td><h5 class="text-center">+</h5></td>
                            @else
                            <td><h5 class="text-center">-</h5></td>
                            @endif
                            @if($reg->dac_aspecto==1)
                            <td><h5 class="text-center">Liquido</h5></td>
                            @else
                            <td><h5 class="text-center">Homogeneo</h5></td>
                            @endif
                            @if($reg->dac_color==1)
                            <td><h5 class="text-center">Blanco Opaco</h5></td>
                            @else
                            <td><h5 class="text-center">Blanco Cremoso</h5></td>
                            @endif
                            @if($reg->dac_olor==1)
                            <td><h5 class="text-center">Si</h5></td>
                            @else
                            <td><h5 class="text-center">No</h5></td>
                            @endif
                            @if($reg->dac_sabor==1)
                            <td><h5 class="text-center">Poco Dulce</h5></td>
                            @else
                            <td><h5 class="text-center">Agradable</h5></td>
                            @endif
                        </tr>
                        @endforeach 
                        @else
                        <tr>
                            <td colspan="11" class="text-center">No hay registro !!</td>
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
