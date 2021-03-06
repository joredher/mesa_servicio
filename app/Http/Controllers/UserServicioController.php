<?php

namespace App\Http\Controllers;

use App\CategoriesUser;
use App\Ticket;
use App\Traitement;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;

class UserServicioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('isadmin')->only('assign');
    }

    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $tickets = Ticket::filtersService()->orderBy('orden')->orderBy('updated_at', 'desc')->paginate(10);
        } else if (Auth::user()->role === 'agent') {
            $tickets = Ticket::filtersService()->where('agent_id', Auth::user()->id)
                ->orderBy('updated_at', 'desc')->orderBy('orden')->paginate(10);
        } else {
            $tickets = Ticket::filtersService()->where('user_id', Auth::user()->id)
                ->orderBy('orden')->orderBy('updated_at', 'desc')->paginate(10);
        }

        return view('servicio.table', compact('tickets'));
    }

    public function consulter($id)
    {
        $traitements = Traitement::where('ticket_id', $id)->get();
        $ticket = Ticket::with('files')->findOrFail($id);
        $data = [];

        $param = null;
        if ($ticket->etat === 'Creado') {
            $ticket->etat = 'En curso';
            $ticket->orden = 2;
            $ticket->save();
        }

        return view('servicio.show', compact('ticket', 'traitements', 'param', 'data'));
    }

    public function conasignar($id)
    {
        $traitements = Traitement::where('ticket_id', $id)->get();
        $ticket = Ticket::with('files')->findOrFail($id);
        $data = [];
        $param = 2;
        $categorias = collect(CategoriesUser::where('categorie_id', '=', $ticket->categorie_id)->get());
        $users = $categorias->groupBy('user_id');
        foreach ($users as $key => $datum) {
            $user = null;
            foreach ($users[$key] as $dat) {
                $user = User::find($dat['user_id']);
            }
            array_push($data, $user);
        }

        return view('servicio.show', compact('ticket', 'traitements', 'param', 'data'));
    }

    public function assign(Request $request, $id)
    {
        $ticket = Ticket::with('files')->findOrFail((int) $id);
        $ticket->agent_id = ((int) $request->get('agents'));
        $ticket->save();

        Session::flash('message', "El servicio #$id se asignó correctamente.");

        return redirect('servicios_all');
    }
}
