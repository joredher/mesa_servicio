@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="modal fade" id="myConsult" role="dialog">
                <div class="modal-dialog modal-sm" style="margin-top: 20%">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" style="color: #0f0f10 !important;"
                                    data-dismiss="modal">&times;
                            </button>
                            <h3 class="modal-title" id="myModalLabel">
                                ¿Está seguro de responder el servicio?<br>
                            </h3>
                            <small>Al <b>aceptar</b> el estado del servicio cambiara</small>
                            .
                        </div>
                        <div class="modal-footer">
                            <div class="pull-right">
                                <a type="button" class="btn btn-default btn-sm" onclick="myConsult(1)">Close</a>
                                <a type="button"
                                   id="resTicket" class="btn btn-primary btn-sm">Aceptar</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-success" style="border-color: rgba(77,170,106,0.5) !important;">
                    <div class="panel-heading" style="background-color: rgba(48,151,209,0.5) !important;">
                        <h3 class="panel-title" style="display: flex !important;">
                            @if(Auth::user()->role !== 'admin')
                                <div class="h3_form" style="padding-left: 1px !important">
                                    {{'LISTA DE SERVICIOS ' . (Auth::user()->role === 'user' ? '' : 'ASIGNADOS') }}
                                </div>
                            @else
                                <div class="h3_form" style="margin-top: 0.5% !important;">
                                    {{'LISTA DE SERVICIOS  ' . (Auth::user()->role === 'user' ? '' : '') }}
                                </div>
                            @endif

                            @if(Auth::user()->role !== 'agent')
                                <div style="margin-left: auto !important;">
                                    <a href="{{ url('servicio/nouveau')}}" class="btn btn-primary">Crear Servicio</a>
                                </div>
                                @if(Auth::user()->role === 'admin')
                                    <div style="padding-left: 0.8mm">
                                        <a href="{{ url('/admin/tickets/export/xls')}}"
                                           data-toggle="tooltip"
                                           data-placement="top"
                                           title="Exportar XLS"
                                           class="btn btn-primary">
                                            <i class="fas fa-file-excel"></i>
                                        </a>
                                    </div>
                                @endif
                            @endif
                        </h3>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            {!! Form::model(\Illuminate\Support\Facades\Request::all(),
                            ['method' =>'GET', 'url' => 'servicios_all',
                            'class' => 'navbar-form navbar-left pull-right','role'=> 'search']) !!}
                            <div class="form-group">
                                {!! Form::select('etat', config('options.status'), null, ['class' => 'form-control']) !!}
                                {!! Form::select('priory', config('options.priorities'), null, ['class' => 'form-control']) !!}
                            </div>
                            {!! Form::button('<i class="fas fa-search"></i>',['type' => 'submit','class' => 'btn btn-info btn-md']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-hovered ">
                            <tr>
                                <td>#</td>
                                <td width="20%">Fecha creación</td>
                                <td>Título</td>
                                <td>Prioridad</td>
                                <td>Estado</td>
                                <td>Días/Tiempo Respuesta</td>
                                @if(Auth::user()->role !== 'agent')
                                    <td>Fecha de consulta</td>
                                @endif
                                <td class="text-center">Opciones</td>
                            </tr>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->id }}</td>
                                    <td>{{ $ticket->created_at}}</td>
                                    <td>{{ $ticket->subject}}</td>
                                    <td>{{ $ticket->priorite->nom}}</td>
                                    <td>{{ $ticket->etat }}</td>
                                    <td style="color:{!! $ticket->dias['color'] !!} !important;
                                            font-weight: bold !important;">{{$ticket->dias['time']}}</td>
                                    <!--Días de creado-->
                                    @if(Auth::user()->role !== 'agent')
                                        <td>{{$ticket->fecha_consulta === null
                                            ? 'Sin consultar'
                                            : \Carbon\Carbon::parse($ticket->fecha_consulta)->format('Y-m-d')
                                        }}</td>
                                    @endif
                                    <td class="row">
                                        <div class="{{($ticket->etat !== 'Terminado')
                                                       ? (is_null($ticket->fecha_consulta)
                                                            ? 'col-sm-6' : 'col-sm-4') : 'col-sm-12'}} text-center">
                                            <a href="{{ url('servicio/'.$ticket->id.'/ver')}}"
                                               data-toggle="tooltip"
                                               data-placement="top"
                                               title="Ver Respuesta/s"
                                               class="btn btn-primary btn-sm">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        </div>
                                        @if((Auth::user()->role === 'agent' && $ticket->etat !== 'Terminado')
                                        || (Auth::user()->role === 'admin' && $ticket->etat !== 'Terminado' && !is_null($ticket->fecha_consulta)))
                                            <div class="{{(is_null($ticket->fecha_consulta)
                                                            ? 'col-sm-6' : 'col-sm-4')}} text-center">
                                                <a href="{{ url('servicio/'.$ticket->id.'/consulter')}}"
                                                   data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="Responder"
                                                   class="btn btn-success btn-sm">
                                                    <i class="fas fa-file-alt"></i>
                                                </a>
                                            </div>
                                        @endif
                                        @if(Auth::user()->role === 'admin' && $ticket->etat !== 'Terminado' && is_null($ticket->fecha_consulta))
                                            <div class="{{(is_null($ticket->fecha_consulta)
                                                            ? 'col-sm-6' : 'col-sm-4')}} text-center">
                                                <a data-toggle="modal"
                                                   data-placement="top"
                                                   data-target="#myConsult"
                                                   onclick="myConsult([{{Auth::user()}}, {{$ticket}}])"
                                                   title="Responder"
                                                   id="modalUno"
                                                   class="btn btn-success btn-sm">
                                                    <i class="fas fa-file-alt"></i>
                                                </a>
                                            </div>
                                        @endif
                                        @if((Auth::user()->role  === 'admin' || Auth::user()->role === 'agent')
                                        && $ticket->etat !== 'Terminado' && (!is_null($ticket->fecha_consulta)))
                                            <div class="col-sm-4 text-center">
                                                <a href="{{ url('servicio/'.$ticket->id.'/terminado')}}"
                                                   data-toggle="tooltip"
                                                   data-placement="top"
                                                   title="{{"Finalizar Servicio #$ticket->id"}}"
                                                   class="btn btn-warning btn-sm">
                                                    <i class="fas fa-hourglass-end"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {{ $tickets->appends(\Illuminate\Support\Facades\Request::only(['priory','etat']))->render() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        function myConsult(value) {
            if (value !== 1) {
                if (value[0].role === "admin") {
                    const ticket = value[1];
                    $("#resTicket").attr("href", {!! json_encode(url('')) !!}+'/servicio/' + ticket.id + '/consulter');
                }
            } else {
                $("#resTicket").removeAttr('href');
            }
        }
    </script>
@endpush