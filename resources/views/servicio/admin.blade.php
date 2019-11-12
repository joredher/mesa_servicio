<div class="panel panel-success" style="border-color: rgba(48,151,209,0.5) !important;">
    <div class="panel-heading" style="background-color: rgba(48,151,209,0.5) !important;">
        <h3 class="panel-title" style="color: white">Estadísticas</h3>
    </div>
    <div class="panel-body">
        <table class="ui blue table table-bordered">
            <tr>
                <td>Total de servicios :<span class="badge">{{ $statistiques['total'] }}</span></td>
                <td style="padding-top: 0 !important;">
                    <table width="100%" class="table-condensed">
                        <tr>
                            <td colspan="2" class="center aligned"><b>USUARIOS ACTIVOS</b></td>
                        </tr>
                        <tr>
                            <td class="center aligned" style="padding-top: 0; padding-bottom: 0">Funcionarios:
                                <span class="badge">{{\App\User::All()
                                                ->where('id','<>',Auth::user()->id)
                                                ->where('role','user')
                                                ->count() }}</span>
                            </td>
                            <td class="center aligned" style="padding-top: 0; padding-bottom: 0">Agentes:
                                <span class="badge">{{\App\User::All()
                                                ->where('id','<>',Auth::user()->id)
                                                ->where('role','agent')
                                                ->count() }}</span>
                            </td>
                        </tr>
                    </table>
                    {{--          Total de Usuarios : <span class="badge">--}}
                    {{--              {{  \App\User::All()->where('id','<>',Auth::user()->id)->count() }}</span>--}}
                </td>
            </tr>
            <tr>
                <td>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td colspan="2"><b>Estados</b></td>
                        </tr>
                        <tr>
                            <td>Creación</td>
                            <td><span class="badge">{{ $statistiques['creation']}}</span></td>
                        </tr>
                        <tr>
                            <td>En curso</td>
                            <td><span class="badge">{{ $statistiques['encours']}}</span></td>
                        </tr>
                        <tr>
                            <td>Terminados</td>
                            <td><span class="badge">{{ $statistiques['realisee']}}</span></td>
                        </tr>
                    </table>
                    <div style="width:300px;">
{{--                        @if(count($tickets) >= 1)--}}
                        <canvas id="estados" width="200" height="200"></canvas>
{{--                        @endif--}}
                    </div>
                </td>
                <td>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td colspan="2"><b>Prioridades</b></td>
                        </tr>
                        @foreach ($priorites as $priorite)
                            <tr>
                                <td>{{ $priorite->nom}}</td>
                                <td><span class="badge">{{ $priorite->tickets->count()}}</span></td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>
@push('scripts')
    <script>
        // le canvas
        var ctx = document.getElementById("estados");
        //les données
        var cree = ({{ $statistiques['creation']}}/{{ $statistiques['total'] }})*100;
        var encours = ({{ $statistiques['encours']}}/{{ $statistiques['total'] }})*100;
        var traite = ({{ $statistiques['realisee']}}/{{ $statistiques['total'] }})*100;
        var data = {
            labels: [
                "Creación",
                "En curso",
                "Terminados"
            ],
            datasets: [
                {
                    data: [cree, encours, traite],
                    backgroundColor: [
                        "#FF6384",
                        "#36A2EB",
                        "#FFCE56"
                    ],
                    hoverBackgroundColor: [
                        "#FF6384",
                        "#36A2EB",
                        "#FFCE56"
                    ]
                }]
        };
        var options = {
            elements: {
                arc: {
                    borderColor: "#000000"
                }
            }
        };
        // Affichage
        if (cree !== null || encours || null || traite !== null) {
            var myPieChart = new Chart(ctx,
                {
                    type: 'doughnut',
                    data: data,// données
                    options: options
                }
            );
        }
    </script>
@endpush
