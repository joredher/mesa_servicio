@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: rgba(48,151,209,0.5) !important; color: white">
                        <h4>
                            <i class="fas fa-list-alt"></i>&nbsp;
                            &nbsp;Nuevo servicio
                        </h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                {!! Form::open(['method' => 'POST', 'url' => 'servicio/enregistrer', 'class' => 'form-horizontal',
                                      'files' => true, 'enctype'=>'multipart/form-data']) !!}
                                <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                                    {!! Form::label('subject', 'Tema :') !!}
                                    {!! Form::text('subject', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                    <small class="text-danger">{{ $errors->first('subject', 'El campo tema es requerido.') }}</small>
                                </div>
                                <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                                    {!! Form::label('message', 'Descripción :') !!}
                                    {!! Form::textarea('message', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                    <small class="text-danger">{{ $errors->first('message', 'El campo descripción debe contener al menos 10 caracteres.') }}</small>
                                </div>
                                <div class="form-group{{ $errors->has('priorite_id') ? ' has-error' : '' }}">
                                    {!! Form::label('priorite_id', 'Prioridad') !!}
                                    {!! Form::select('priorite_id', $priorites, null, ['class' => 'form-control', 'required' => 'required']) !!}
                                    <small class="text-danger">{{ $errors->first('priorite_id') }}</small>
                                </div>
                                <div class="form-group{{ $errors->has('priorite_id') ? ' has-error' : '' }}">
                                    {!! Form::file('files',['name' => 'files[]','multiple' => 'multiple']) !!}
                                </div>
                                <div class="pull-left">
                                    <a href="{{ url("servicios_all")}}"
                                       class="btn btn-danger">
                                        <i class="fas fa-reply"></i> Cerrar</a>
                                </div>
                                <div class="pull-right">
                                    {!! Form::reset("Cancelar", ['class' => 'btn btn-danger']) !!}
                                    {!! Form::submit("Registrar", ['class' => 'btn btn-primary']) !!}
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
