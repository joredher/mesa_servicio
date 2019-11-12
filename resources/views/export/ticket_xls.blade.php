<table>
    <tr style="color:red;">
        <td>#</td>
        <td>Titulo</td>
        <td>Descripción</td>
        <td>Estado</td>
        <td>Prioridad</td>
        <td>Usuario</td>
        <td>Fecha Creación</td>
        <td>Fecha Consulta</td>
        <td>Respuesta</td>
        <td>Tiempo Solución Agente</td>
        <td>Agente</td>
        <td>Fecha de Terminado</td>
    </tr>
    @foreach (\App\Ticket::All() as $ticket)
        <tr>
            <td>{{ $ticket->id }}</td>
            <td>{{ $ticket->subject }}</td>
            <td>{{ $ticket->message }}</td>
            <td>{{ $ticket->etat}}</td>
            <td>{{ $ticket->priorite->nom}}</td>
            <td>{{ $ticket->user->name}}</td>
            <td>{{ \Carbon\Carbon::parse($ticket->created_at)->format('Y-m-d') }}</td>
            <td>{{ !is_null($ticket->fecha_consulta) ? \Carbon\Carbon::parse($ticket->fecha_consulta)->format('Y-m-d') : 'N/A'}}</td>
            <td>{{ is_null($ticket->fecha_consulta) ? 'No Registra' : \App\Traitement::where('ticket_id','=',$ticket->id)->latest()->first()->description }}</td>
            <td>{{ is_null($ticket->fecha_consulta) ? 'No Registra' : (\App\Traitement::where('ticket_id','=',$ticket->id)->latest()->first()->duree . ' min') }}</td>
            <td>{{ is_null($ticket->fecha_consulta) ? 'No Registra' : \App\Traitement::where('ticket_id','=',$ticket->id)->latest()->first()->technicien['name'] }}</td>
            <td>{{ ($ticket->etat === 'Terminado') ? \Carbon\Carbon::parse($ticket->updated_at)->format('Y-m-d') : '' }}</td>
        </tr>
    @endforeach
</table>
