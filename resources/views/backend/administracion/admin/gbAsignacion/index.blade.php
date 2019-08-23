@extends('backend.template.app')

@section('htmlheader_title')
@endsection
@section('main-content')
@if(Session::has('message'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    {{Session::get('message')}}
</div>
@endif
@if(Session::has('messageError'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    {{Session::get('messageError')}}
</div>
@endif
{!! Form::open(array('route' => 'Asignacion.store','method'=>'POST','class'=>'')) !!}
<input type="hidden" name="rolacceso" value="{{$idrol}}">
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="pull-left">
                    Accesos Ingreso al Menu
                </h3>
                <h3 class="pull-right">
                    {{$nombreRol}}
                </h3>
            </div>
            <div class="box-body">
                <div class="btn-group" role="group">
                    <div class="form-group">
                        <label>
                            Roles
                        </label>
                        <select class="form-control" name="rolos" id="rolid" onchange="cambioRol(this.value);">
                            <option value="">-Seleccione-</option>
                            @foreach($rol as $vaciado_rol)
                            <option value="{{$vaciado_rol->rls_id}}">
                                {{$vaciado_rol->rls_rol}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
    <div id="no-more-tables">
        <table border="1" bordercolor="#999" class="col-md-4 table-striped table-condensed cf" id="lts-asignacion" style="">
            <thead class="cf">
                <tr>
                    <th colspan="4">
                        OPCIONES
                    </th>
                </tr>
                <tr>
                    <th>
                        <i class="fa fa-check-square-o fa-2x">
                        </i>
                    </th>
                    <th>
                        Grupo
                    </th>
                    <th>
                        Opcion
                    </th>
                    <th>
                        Contenido
                    </th>
                </tr>
            </thead>
            @foreach($opc as $o)
            <tr>
                <td data-title="Seleccionar">
                    <input id="{{ $o->opc_id }}" name="opciones[]" tabindex="1" type="checkbox" value="{{ $o->opc_id }}">
                    </input>
                </td>
                <td data-title="Grupo">
                    {{ $o->grp_grupo }}
                </td>
                <td data-title="Opcion">
                    {{ $o->opc_opcion }}
                </td>
                <td data-title="Contenido">
                    {{ $o->opc_contenido}}
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    <!--botones-->
    <div class="col-md-2">
        <button class="btn btn-theme03" name="agregar" type="submit" value="agregar">
            Agregar
        </button>
        <button class="btn btn-theme04" name="retirar" type="submit" value="retirar">
            Retirar
        </button>
    </div>
    <!--botones-->
    <!-- este div es para la segunda tabla-->
            <div id="no-more-tables">
                <table border="1" bordercolor="#999" class="col-md-4 table-striped table-condensed cf" id="lts-asignacion2">
                    <thead class="cf">
                        <tr>
                            <th colspan="6">
                                ACCESOS
                            </th>
                        </tr>
                        <tr>
                            <th>
                                <i class="fa fa-check-square-o fa-2x">
                                </i>
                            </th>
                            <th>
                                Rol
                            </th>
                            <th>
                                Opcion
                            </th>
                            <th>
                                Contenido
                            </th>
                            <th>
                                Registrado
                            </th>
                            <th>
                                Modificado
                            </th>
                        </tr>
                    </thead>
                    @foreach($acceso as $a)
                    <tr>
                        <td data-title="Seleccionar">
                            <input id="{{ $a->acc_id }}" name="asignaciones[]" tabindex="1" type="checkbox" value=" {{ $a->acc_id }}">
                            </input>
                        </td>
                        <td data-title="Rol">
                            {{ $a->rls_rol }}
                        </td>
                        <td data-title="Opcion">
                            {{ $a->opc_opcion }}
                        </td>
                        <td data-title="Contenido">
                            {{ $a->opc_contenido}}
                        </td>
                        <td data-title="Contenido">
                            {{ $a->acc_registrado}}
                        </td>
                        <td data-title="Contenido">
                            {{ $a->acc_modificado}}
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            </div>
            </div>
        </div>
    </div>
</div>
<!-- este div es para la primera tabla-->
@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        $("select").change(function(){
        var rol = $("#rolid").val();
        console.log("este es el rol",rol);
        $("#txtTabla").val(rol);
        $("#rls_id").submit();
        });
    });
    function cambioRol(idRol){
         window.location.href = '/AsignacionRol/'+idRol; //using a named route
    }
</script>
@endpush


