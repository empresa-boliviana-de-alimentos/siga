@extends('backend.template.app')
@section('main-content')

<div class="row">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
            <div class="col-md-12">
                <div class="col-md-8">
                     <h4><label for="box-title">Detalle de Acopios</label></h4>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-2">
                
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<center>
<h2>
    {{$buscar->prov_nombre}} {{$buscar->prov_ap}} {{$buscar->prov_am}}
</h2>
</center>
<input id="id_acopio" name="id_acopio" placeholder="" type="hidden" value="1">
    <div id="no-more-tables">
        <table class="col-md-12 table-bordered table-striped table-condensed cf" id="lts-acopioDetalle">
            <thead class="cf">
                <tr>
                    <th>
                        Boleta Acopio
                    </th>
                    <th>
                        Boleta Acop. 
                        Proveedor
                    </th>
                    <!-- <th>
                        #
                    </th> -->                    
		            <th>
                        Tipo de Castaña
                    </th>
                    <th>
                        Lugar de Compra
                    </th>
                    <th>
                        Nro Recibo
                    </th>
                    <th>
                        Nro Acopio
                    </th>
                    <th>
                        Fecha de Acopio
                    </th>
                    <th>
                        Nro Cajas
                    </th>
                    <th>
                        Peso Kg
                    </th>
                    <th>
                        Costo U.
                    </th>
                    <th>
                        Total Bs
                    </th>
                </tr>
            </thead>   
            <tbody>
                @if($acopio->count())  
                @foreach($acopio as $ac)
                <tr>
                    <th class="text-center"><a type="button" class="btn btn-info" href="/Boleta/{{$ac->aco_id}}" target="_blank"><span class="fa fa-file-pdf-o"></span></a></th>
                    <th class="text-center"><a type="button" class="btn btn-danger" href="/BoletaProv/{{$ac->aco_id}}" target="_blank"><span class="fa fa-file-pdf-o"></span></a></th>
                    <!--  <td>{{$ac->aco_id}}</td> -->
                    <td>{{$ac->tca_nombre}}</td>
                    <td>{{$ac->proc_nombre}}</td>
                    <td>{{$ac->aco_num_rec}}</td>
                    <td>{{$ac->aco_numaco}}</td>
                    <td>{{date('m-d-Y',strtotime($ac->aco_fecha_acop))}}</td>
                    <td>{{$ac->aco_cantidad}}</td>
                    <td>{{$ac->aco_peso_neto}}</td>
                    <td>{{$ac->aco_cos_un}}</td>
                    <th>{{$ac->aco_cos_total}}</th>
                </tr>
                @endforeach 
                @else
                <tr>
                    <td colspan="8">No hay registro !!</td>
                </tr>
                @endif
            </tbody>
        </table>
	<div class="text-center">
             {!! $acopio->render() !!}
        </div>
    </div>
@endsection
@push('scripts')
<script>

  
</script>
@endpush
