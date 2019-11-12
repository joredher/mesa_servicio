@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default" style="border-color: #4DAA6A !important;">
                    <div class="panel-heading" style="background-color: rgba(48,151,209,0.8) !important; color: white">
                        <h3 style="color: white">Sistema de gestión de servicios</h3></div>
                    <div class="panel-body">
                        @if(Auth::user()->role==='admin')
                            @include('servicio.admin')
                        @else
                            @include('servicio.table')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
