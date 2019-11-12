@extends('layouts.app')

@section('style-id')
    <style type="text/css">
        .logo {
            width: 46% !important;
        }

        .panel-size {
            margin-top: 10% !important;
            margin-left: 15% !important;
            margin-right: 15% !important;
            box-shadow: 0 12px 12px 4px rgba(0, 0, 0, .1)
        }

        .panel-size .panel-heading {
            max-height: 283px !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }

        .bg_gradient {
            background-image: linear-gradient(to left,
            #ea0f16, #f1222f, #f73245, #fb4159, #fe506c, #fe526c,
            #ff536d, #ff556d, #ff4c5a, #ff4544, #ff412b, #ff4100) !important;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default panel-size">
                    <div class="panel-heading text-center" style="background-color: #FAFAFA !important;">
                        <img src="{{ asset('img/authors/19832/19832.jpg') }}" class="logo" alt="Logo">
                    </div>
                    <div class="panel-body bg_gradient">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email"
                                       style="color: white !important; font-weight: bolder !important;"
                                       class="col-md-4 control-label">Correo Electrónico</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label style="color: white !important; font-weight: bolder !important;"
                                       for="password" class="col-md-4 control-label">Contraseña</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label style="color: white !important; font-weight: bolder !important;">
                                            <input type="checkbox" name="remember"> Recordar
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Iniciar Sesión
                                    </button>

                                    <a style="color: white !important; font-weight: bolder !important;"
                                       class="btn btn-link" href="{{ url('/password/reset') }}">
                                        ¿Olvidaste la contraseña?
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
