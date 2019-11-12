<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Ticket;
use App\Traitement;
use Auth;
use Session;
use Mail;
use App\Mail\TicketTraite;

class TraitementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(){}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //$id td du servicio à traiter
        $ticket = Ticket::findOrFail($id);
        $etats = [
            'en' => 'En curso',
            'tr' => 'Terminado',
        ];

        return view('taitement.new', compact('ticket', 'etats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'ticket_id' => 'required',
            'description' => 'required|min:6',
            'duree' => 'required',
        ]);
        $ticket_id = $request->input('ticket_id');
        Traitement::create([
            'description' => $request->input('description'),
            'duree' => $request->input('duree'),
            'user_id' => Auth::user()->id,
            'ticket_id' => $ticket_id,
        ]);
        $ticket = Ticket::where('id', $ticket_id)->first();
        if ($request->input('etat_ticket') === 'tr') // tester si le servicio est terminado
        {
            //$ticket = Ticket::where('id', $request->input('ticket_id'))->first();
            if (is_null($ticket->fecha_consulta)) {
                $ticket->fecha_consulta = Carbon::now()->toDateString();
            }
            $ticket->etat = 'Terminado';
            $ticket->save();

            // envoyer un mail pour le demandeur
            Mail::to($ticket->user->email)->send(new TicketTraite($ticket));
        } else {
            $ticket->fecha_consulta = Carbon::now()->toDateString();
            $ticket->save();
        }
        Session::flash('message', 'La respuesta se ha registrado correctamente.');

        //return redirect('/home');
        return redirect("servicio/$ticket_id/consulter");
    }
}
