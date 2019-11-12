@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-success" style="border-color: rgba(77,170,106,0.5) !important;">
                    <div class="panel-heading" style="background-color: rgba(48,151,209,0.5) !important;">
                        <h3 class="panel-title" style="display: flex !important;">
                            <div style="color: whitesmoke !important;">
                                Tratamiendo del servicio N° {{ $ticket->id}} creado por {{ $ticket->user->name}},
                                el {{ \Carbon\Carbon::parse($ticket->created_at)->format('d/m/Y')}}
                            </div>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="well">
                                    <b>Título :</b> {{ $ticket->subject }}
                                </div>
                                <div class="well">
                                    <b>Concepto servicio :</b> {{ $ticket->message }}
                                </div>

                                <br>
                                {!! Form::open(['method' => 'POST', 'url' => 'traitement/enregistrer', 'class' => 'form-horizontal']) !!}
                                {!! Form::hidden('ticket_id', $ticket->id) !!}
                                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                    {!! Form::label('description', 'Decripción de la intervención ') !!}
                                    {!! Form::textarea('description', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                    <small class="text-danger">{{ $errors->first('description') }}</small>
                                </div>
                                <div class="form-group{{ $errors->has('duree') ? ' has-error' : '' }}">
                                    {!! Form::label('duree', 'Tiempo(Cifras en Minutos)') !!}
                                    {!! Form::text('duree', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                    <small class="text-danger">{{ $errors->first('duree') }}</small>
                                </div>
                                <div class="form-group{{ $errors->has('etat_ticket') ? ' has-error' : '' }}">
                                    {!! Form::label('etat_ticket', 'Estado Servicio') !!}
                                    {!! Form::select('etat_ticket', $etats, null, ['class' => 'form-control', 'required' => 'required']) !!}
                                    <small class="text-danger">{{ $errors->first('etat_ticket') }}</small>
                                </div>
                                <div class="pull-left">
                                    <a href="{{ url("servicio/$ticket->id/consulter")}}"
                                       class="btn btn-danger">
                                        <i class="fas fa-reply"></i> Cerrar</a>
                                </div>
                                <div class="pull-right">
                                    {!! Form::reset("Limpiar", ['class' => 'btn btn-danger']) !!}
                                    {!! Form::button('<i class="fas fa-save"></i>',
                                        [
                                            'type' => 'submit',
                                            'id' => 'save',
                                            'data-loading-text' => ((isset($ticket['id']) || $ticket['id'] !== null)
                                                ? "Actualiz" : "Registr")."ando",
                                            'class' => 'btn btn-primary']) !!}
                                    {!! Form::close() !!}

                                </div>
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
    </script>
@endpush
