@extends('admin.app')
@section('htmlheader_title')
Edit
@endsection
@section('main-content')

<div class="col-md-5 col-md-offset-3">
    <div class="thumbnail">
        <div class="caption">
            <h3 class="text-center"><b>EDITAR ACCESO</b></h3><hr>
            {!! Form::model($acceso,['route' => ['Acceso.update',$acceso->acc_id],'method'=>'PUT'])!!}
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <strong>Grupo</strong>
                        {!! Form::Label('item','Opciones:')!!}
                        {!! Form::select('opc_id', $opc, null,['class'=>'form-control','name'=>'acc_opc_id', 'id'=>'acc_opc_id']) !!}
                    </div>
                    <div class="form-group">
                        <strong>Grupo</strong>
                        {!! Form::Label('item','Roles:')!!}
                        {!! Form::select('rls_id', $rol, null,['class'=>'form-control','name'=>'acc_rls_id', 'id'=>'acc_rls_id']) !!}
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center"><hr> 
                       <p  align="right"> <a href="{{ route('Acceso.index') }}" class="btn btn-default">&nbsp; Volver</i></a>
                           <button type="submit" class="btn btn-warning">Guardar</button></p>
                       </div>
                   </div>
               </div>
               {!! Form::close() !!}
           </div>
       </div>
   </div>
   @endsection





