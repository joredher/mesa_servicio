@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: rgba(48,151,209,0.5) !important; color: white">
                        <h4>
                            @if(isset($user->id) || $user !== null)
                                <i class="fas fa-user-edit"></i>&nbsp;
                            @endif
                            &nbsp;
                            {{ ((isset($user->id) || $user !== null) ? "Edición de " : 'Nuevo ') . 'usuario' }}
                        </h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                {!! Form::open(['method' => (!isset($user->id) || $user === null)
                                ? 'POST' : 'PUT', 'url' => 'users/'.((!isset($user->id) || $user === null)
                                ? 'enregistrer' : "enactualizar/$user->id") , 'class' => 'form-horizontal']) !!}
                                <div class="form-group{{ $errors->has('identification') ? ' has-error' : '' }}">
                                    {!! Form::label('identification', 'Número de Identificación:') !!}
                                    {!! Form::text('identification', $user['identification'],
                                        ['class' => 'form-control',
                                         'required' => ($user['id'] === null) ? 'required' : null,
                                         'placeholder' => 'CC'])
                                    !!}
                                    <small class="text-danger">{{ $errors->first('identification', 'El campo identificación es requerido.') }}</small>
                                </div>
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    {!! Form::label('name', 'Nombre Usuario:') !!}
                                    {!! Form::text('name', ((isset($user['id']) || $user['id'] !== null)
                                    ? $user->name : ''),
                                    ['class' => 'form-control',
                                    'required' => 'required',
                                    'placeholder' => 'Nombre completo']) !!}
                                    <small class="text-danger">{{ $errors->first('name', 'El campo nombre completo es requerido.') }}</small>
                                </div>
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    {!! Form::label('email', 'E-mail:') !!}
                                    {!! Form::text('email', ((isset($user['id']) || $user['id'] !== null)
                                    ? $user->email : ''),
                                    ['class' => 'form-control',
                                    'required' => 'required',
                                    'email' => 'email',
                                    'placeholder' => 'example@example.com']) !!}
                                    <small class="text-danger">{{ $errors->first('email') }}</small>
                                </div>
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    {!! Form::label('password', 'Contraseña:') !!}
                                    <div class="row">
                                        <div class="col-sm-10">
                                            {!! Form::password('password',
                                                [
                                                    'class' => 'form-control awesome',
                                                    'name' => 'password',
                                                    'placeholder' => '******',
                                                    'id' => 'password'
                                                ]) !!}
                                        </div>
                                        <div class="col-sm-1 col-sm-offset-1" style="padding: inherit !important;">
                                            <a class="btn btn-primary" id="view" onclick="viewPassword()">
                                                <i class="icono fas fa-eye"></i></a>
                                        </div>
                                    </div>
{{--                                    <div>--}}

{{--                                    </div>--}}
                                    <small class="text-danger">{{ $errors->first('password','El campo contraseña es obligatorio') }}</small>
                                </div>
                                <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                                    {!! Form::label('role', 'Rol:') !!}
                                    {!! Form::select('role', $roles, ((isset($user['id']) || $user['id'] !== null)
                                    ? $user->role : 'user'),
                                    ['class' => 'form-control',
                                    'required' => 'required',
                                    'email' => 'email',
                                    'id' => 'rolId',
                                    'onchange' => 'activeInputRole()' ]) !!}
                                    <small class="text-danger">{{ $errors->first('role') }}</small>
                                </div>
                                <div class="form-group {{ $errors->has('dependencia') ? ' has-error' : '' }} dependencia">
                                    {!! Form::label('dependencia', 'Dependencia :') !!}
                                    {!! Form::text('dependencia', ((isset($user['id']) || $user['id'] !== null)
                                    ? $user->dependencia : ''),
                                    ['class' => 'form-control',
                                    'required' => ($user['role'] === 'user') ? 'required' : null,
                                    'placeholder' => 'Dependencia']) !!}
                                    <small class="text-danger">{{ $errors->first('dependencia') }}</small>
                                </div>
{{--                                @if(isset($user['id) && ($user->role === 'agent'))--}}
                                <div class="form-group
                                        {{$errors->has('categories') ? ' has-error' : ''}}
                                        categorId">
                                    <h4>Categorias:</h4>
                                    <select multiple="multiple" name="categories[]" class="form-control"
                                            id="categories">
                                        @foreach($categories as $key => $category)
                                            <option value="{{ $category->id }}"
                                                    @if(isset($categorieSelected))
                                                    @foreach($categorieSelected as $itemKey)
                                                    @if($category->id ===$itemKey['categorie']['id'])
                                                    selected="selected"
                                                    @endif
                                                    @endforeach
                                                    @endif>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">{{ $errors->first('categories',
                                    'Debe seleccionar almenos una categoria.') }}</small>
                                </div>
{{--                                @endif--}}
                                <div class="pull-left">
                                    <a href="{{ url("users_all")}}"
                                       class="btn btn-danger">
                                        <i class="fas fa-reply"></i> Cerrar</a>
                                </div>
                                <div class="pull-right">
                                    {!! Form::reset("Limpiar", ['class' => 'btn btn-danger']) !!}
                                    {!! Form::button('<i class="fas fa-save"></i>',
                                        [
                                            'type' => 'submit',
                                            'id' => 'save',
                                            'data-loading-text' => ((isset($user['id']) || $user['id'] !== null)
                                                ? "Actualiz" : "Registr")."ando",
                                            'class' => 'btn btn-primary']) !!}
                                    {{--                                    {!! Form::submit(((isset($user->id) || $user !== null)--}}
                                    {{--                                    ? "Actuali" : "Registr")."ar", ['class' => 'btn btn-primary']) !!}--}}
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
@push('scripts')
    <script type="text/javascript">
        $('#save').on('click', function () {
            var $btn = $(this).button('loading')
            $btn.button('reset')
        })

        function viewPassword () {
            var tipo = document.getElementById('password');

            if (tipo.type === 'password') {
                tipo.type = 'text';
                $('.icono').removeClass('fas fa-eye-slash').addClass('fas fa-eye');
            } else {
                tipo.type = 'password'
                $('.icono').removeClass('fas fa-eye').addClass('fas fa-eye-slash');
            }
        }

        $(document).ready(function () {roleActivo();})
        function activeInputRole() {roleActivo();}

        function roleActivo() {
            var role = document.getElementById('rolId').value
            if (role === 'user') {
                $('.dependencia').show()
                $('.categorId').hide()
            } else if (role === 'agent') {
                $('.categorId').show()
                $('.dependencia').hide()
            } else {
                $('.categorId').hide()
                $('.dependencia').hide()
            }
        }
    </script>
@endpush