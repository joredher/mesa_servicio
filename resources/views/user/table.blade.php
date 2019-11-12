@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @if(Session::has('message_delete'))
                <div class="alert alert-warning">
                    <p style="text-align:center">{{ Session::get('message_delete')}}</p>
                </div>
            @endif
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: rgba(48,151,209,0.5) !important;">
                        <div class="row">
                            <div class="col-md-6 middle" style="margin-top: 1.0% !important;">
                                <h4 style="color: white"><i class="fas fa-user-alt"></i>
                                    &nbsp;<b>Usuarios</b></h4></div>
                            <div class="col-md-6 text-right">
                                <a href="{{ url('users/nouveau')}}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Agregar</a>

                                {{--                                <button type="button" onclick="{{ url('users/nouveau') }}" class="btn btn-default navbar-btn btn-primary">--}}
                                {{--                                    <i class="plus circle icon"></i> Agregar</button>--}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            {!! Form::model(Request::only(['name','role']),['method' =>'GET', 'url' => 'users_all',
                            'class' => 'navbar-form navbar-left pull-right','role'=> 'search']) !!}
                            <div class="form-group">
                                {!! Form::text('name',null,['class' => 'form-control',
                                'placeholder'=>'Nombre de Usuario','name'=>'name']) !!}
                                {!! Form::select('role', ['' => 'Seleccione un rol','user' => 'Usuario','agent' => 'Agente'],
                                null, ['class' => 'form-control']) !!}
                            </div>
                            {!! Form::button('<i class="fas fa-search"></i>',['type' => 'submit','class' => 'btn btn-info btn-md']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="ui blue table table-striped table-bordered table-hovered">
                            <tr>
                                <td>#</td>
                                <td>Identificación</td>
                                <td width="25%">Nombre</td>
                                <td width="30%">Email</td>
                                <td class="center aligned" width="10%">Rol</td>
                                <td class="center aligned">Acciones</td>
                            </tr>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td >{{ $user->identification }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td class="center aligned">{{ ($user->role === 'user')
                                            ? 'Usuario' : ($user->role === 'agent' ? 'Agente' : 'Administrador') }}</td>
                                    <td class="center aligned" style="padding: 0 !important;">
                                        <div>
                                            @if($user->role === 'user')
                                                <div class="col-sm-12 col-md-4">
                                                    <a data-toggle="tooltip"
                                                       data-placement="bottom"
                                                       title="{{"Dependencia: $user->dependencia"}}"
                                                       class="btn btn-red text-success">
                                                        <i class="fas fa-info text-info"></i></a>
                                                </div>
                                            @endif
                                            <div class="col-sm-12 {{$user->role === 'user' ? 'col-md-4' : 'col-md-6' }}">
                                                <a href="{{ url("users/edit/$user->id")}}"
                                                   data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="Editar"
                                                   class="btn btn-red text-success">
                                                    <i class="fas fa-edit text-success"></i></a>
                                            </div>
                                            <div class="col-sm-12 {{$user->role === 'user' ? 'col-md-4' : 'col-md-6' }}">
                                                {!! Form::open(['method' => 'DELETE',
                                                'url' =>'users/delete/'.$user->id ,
                                                'class' => 'form-horizontal']) !!}
                                                <button class="btn btn-red text-danger"
                                                        style="background-color: transparent !important;"
                                                        data-toggle="tooltip"
                                                        data-placement="top"
                                                        title="Eliminar"
                                                        id="submit" name="submit" type="submit">
                                                    <i class="fas fa-trash text-danger"></i>
                                                </button>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </table>
                        {{--                                @if($ticket->etat!=='traité')--}}
                        {{--                                    <a href="{{ url('servicio'.$ticket->id.'/traiter')}}" class="btn btn-primary">Tratar</a>--}}
                        {{--                                @endif--}}
                    </div>
                </div>


            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
{{--@push('scripts')--}}
{{--    <script type="text/javascript">--}}
{{--        $(function () {--}}
{{--            $('[data-toggle="tooltip"]').tooltip()--}}
{{--        })--}}
{{--    </script>--}}
{{--@endpush--}}