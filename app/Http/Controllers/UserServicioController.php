<?php

namespace App\Http\Controllers;

use App\Priorite;
use App\Ticket;
use App\Traitement;
use App\UploadFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Session;

class UserServicioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware(['isagent', 'isadmin'])->only('consulter');
    }

    public function index(Request $request)
    {
        $admin = (Auth::user()->role === 'admin' || Auth::user()->role === 'agent');
        $priory = is_null($request->get('priory')) ? null : ((integer) $request->get('priory'));
        $etat = is_null($request->get('etat')) ? null : ((integer) $request->get('etat'));
        $cantidad = count(Ticket::all());

        //dd($priory, $request->get('etat'));
        if ($priory === 0 || $etat === 0) {
            if ($admin) {
                $tickets = Ticket::orderBy('updated_at', 'desc')
                    ->orderBy('orden')
                    ->paginate(10);
            } else {
                $tickets = Ticket::where('user_id', Auth::user()->id)
                    ->orderBy('orden')
                    ->orderBy('updated_at', 'desc')->paginate(10);
            }
        } else {
            if ($admin) {
                $tickets = Ticket::priory($priory)->status($etat)
                    ->orderBy('orden')->orderBy('updated_at', 'desc')->paginate(10);
            } else {
                $tickets = Ticket::priory($priory)->status($etat)
                    ->orderBy('orden')->orderBy('updated_at', 'desc')->where('user_id', Auth::user()->id)->paginate(10);
            }
        }

        return view('servicio.table', compact('tickets'));
    }

    public function consulter($id)
    {
        $traitements = Traitement::where('ticket_id', $id)->get();
        $param = null;
        $ticket = Ticket::with('files')->findOrFail($id);
        if ($ticket->etat === 'Creado') {
            $ticket->etat = 'En curso';
            $ticket->save();
        }

        return view('servicio.show', compact('ticket', 'traitements', 'param'));
    }
}
