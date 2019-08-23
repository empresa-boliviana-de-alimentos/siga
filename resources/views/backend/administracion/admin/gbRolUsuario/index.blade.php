@extends('backend.template.app')
@section('main-content')
{!! Form::open(array('route' => 'RolUsuario.store','method'=>'POST','class'=>'')) !!}

@if(Session::has('message'))
<div class="alert alert-success alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	{{Session::get('message')}}
</div>
@endif

<h2>Usuario Rol</h2>

<div class="row">
	<div class="col-md-5">
		<div id="no-more-tables">
			<table class="col-md-12 table-striped table-condensed cf" id="lts-usuario" border="1" bordercolor="#999">
				<thead class="cf">
					<tr>
						<th colspan="4"> Usuarios </th>
					</tr>
					<tr>
						<th><i class="fa fa-check-square-o fa-2x"></i></th>
						<th>ID</th>
						<th>Nombre</th>
						<th>Clave</th>
					</tr>
				</thead>
				@foreach($rolUser as $u)

				<tr>
					<td data-title="Seleccionar">
						<input tabindex="1" type="radio" name="usuario[]" id="{{ $u->usr_id }}" value="{{ $u->usr_id }}">
					</td>
					<td data-title="ID">{{ $u->usr_id }}</td>
					<td data-title="Nombre">{{ $u->usr_usuario }}</td>
					<td data-title="Clave">{{ $u->usr_clave}}</td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
	<div class="col-md-6" >
		<div id="no-more-tables">
			<table class="col-md-12 table-striped table-condensed cf" id="rolasignado" border="1" bordercolor="#999">
				<thead class="cf">
					<tr>
						<th colspan="4"> Roles Asignados </th>
					</tr>
					<tr>
						<th><i class="fa fa-check-square-o fa-2x"></i></th>
						<th>ID</th>
						<th>Usuario</th>
						<th>Rol</th>
					</tr>
				</thead>
				@foreach($rolusuario as $ar)
				<tr>
					<td data-title="Seleccionar">
						<input type="checkbox" name="rolasignado[]" id="{{ $ar->usrls_id }}" value=" {{ $ar->usrls_id }}">
					</td>
					<td data-title="ID">{{ $ar->rls_id }}</td>
					<td data-title="Usuario">{{ $ar->usr_usuario}}</td>
					<td data-title="Rol">{{ $ar->rls_rol}}</td>
				</tr>
				@endforeach

			</table>
			&nbsp;
		</div>
		<div  align="center">
			<button type="submit" name="Asignar" class="btn btn-default" style="background:#61BC8C" ><span class="fa fa-chevron-left" ></span> Asignar</button>
			&nbsp; &nbsp;
			<button type="submit" name="Desasignar" class="btn btn-default" style="background:#61BC8C"><span class="fa fa-chevron-right" ></span>Desasignar</button>
		</div>&nbsp;
		<div class="col-lg-12" >
			<div id="no-more-tables">
				<table class="col-md-12 table-striped table-condensed cf" id="rolnoasignado"  border="1" bordercolor="#999">
					<thead class="cf">
						<tr>
							<th colspan="4"> Roles No Asignados </th>
						</tr>
						<tr>
							<th><i class="fa fa-check-square-o fa-2x"></i></th>
							<th>ID</th>
							<th>Usuario</th>
							<th>Rol</th>
						</tr>
					</thead>

					@foreach($rol as $r)
					<tr>
						<td data-title="Seleccionar">
							<input tabindex="1" type="checkbox" name="rolnoasignado[]" id="{{ $r->rls_id }}" value=" {{ $r->rls_id }}">
						</td>
						<td data-title="ID">{{ $r->rls_id }}</td>
						<td data-title="Usuario">{{ $r->usr_usuario}}</td>
						<td data-title="Rol">{{ $r->rls_rol}}</td>
					</tr>
					@endforeach
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    
    $('form').submit(function(e){
        // si la cantidad de checkboxes "chequeados" es cero,
        // entonces se evita que se envíe el formulario y se
        // muestra una alerta al usuario
        if ($('input[type=checkbox]:checked').length === 0) {
            e.preventDefault();
            alert('Debe seleccionar al menos una opcion');
        }
    });

</script>
@endpush

