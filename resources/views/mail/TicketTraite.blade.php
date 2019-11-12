Buen día !<br>
El servicio  N° {{ $ticket->id }} a sido respondido <br>
Soluciones Realizadas
<hr>
<table style="background:#F5F5F5">
    <tr>
        <td>Concepto</td>
        <td>Fecha</td>
        <td>Técnico</td>
    </tr>
    @foreach ($ticket->traitements as $traitement)
        <tr>
            <td>{{ $traitement->description}}</td>
            <td>{{ $traitement->created_at}}</td>
            <td>{{ $traitement->technicien->name}}</td>
        </tr>
    @endforeach
</table>
Coordialemente<br>
Servicio de Mantenimiento
