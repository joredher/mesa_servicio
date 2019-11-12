<table class="table table-striped table-bordered table-hovered ">
  <tr>
    <td>Fecha creación</td>
    <td>Mensaje</td>
    <td>Prioridad</td>
    <td>Estado</td>
    <td>Fecha de consulta</td>
  </tr>
  @foreach ($tickets as $ticket)
    <tr>
      <td>{{ $ticket->created_at}}</td>
      <td>{{ $ticket->message}}</td>
      <td>{{ $ticket->priorite->nom}}</td>
      <td>{{ $ticket->etat}}</td>
      <td>{{ $ticket->updated_at}}</td>
    </tr>
  @endforeach
</table>
{{ $tickets->render() }}
