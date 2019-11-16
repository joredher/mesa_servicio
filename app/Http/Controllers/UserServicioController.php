<?php

namespace App\Http\Controllers;

use App\AsignService;
use App\CategoriesUser;
use App\Priorite;
use App\Ticket;
use App\Traitement;
use App\UploadFile;
use App\User;
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
        //$this->middleware('isadmin')->only('assign');
    }

    public function index(Request $request)
    {
        $admin = (Auth::user()->role === 'admin');
        $agent = Auth::user()->role === 'agent';
        $priory = is_null($request->get('priory')) ? null : ((integer) $request->get('priory'));
        $etat = is_null($request->get('etat')) ? null : ((integer) $request->get('etat'));

        if ($priory === 0 || $etat === 0) {
            if ($admin) {
                $tickets = Ticket::orderBy('updated_at', 'desc')->orderBy('orden')->paginate(10);
            }
            else if ($agent) {
                $tickets = Ticket::where('agent_id', Auth::user()->id)
                    ->orderBy('updated_at', 'desc')->orderBy('orden')->paginate(10);
            } else {
                $tickets = Ticket::where('user_id', Auth::user()->id)
                    ->orderBy('orden')
                    ->orderBy('updated_at', 'desc')->paginate(10);
            }
        } else {
            if ($admin) {
                $tickets = Ticket::priory($priory)->status($etat)
                    ->orderBy('orden')->orderBy('updated_at', 'desc')->paginate(10);
            }
            else if ($agent) {
                $tickets = Ticket::priory($priory)->status($etat)
                    ->orderBy('updated_at', 'desc')->orderBy('orden')
                    ->where('agent_id', Auth::user()->id)->paginate(10);
            } else {
                $tickets = Ticket::priory($priory)->status($etat)
                    ->orderBy('orden')->orderBy('updated_at', 'desc')->where('user_id', Auth::user()->id)->paginate(10);
            }
        }

        return view('servicio.table', compact('tickets'));
    }

    public function consulter($id)
    {
        $var = (int) Input::get('var');
        $traitements = Traitement::where('ticket_id', $id)->get();
        $ticket = Ticket::with('files')->findOrFail($id);
        $data = [];
        if ((typeOf($var) !== 'undefined') && $var === 1) {
            $param = 2;
            $categorias = collect(CategoriesUser::where('categorie_id','=', $ticket->categorie_id)->get());
            $users = $categorias->groupBy('user_id');
            foreach ($users as $key => $datum) {
                $user = null;
                foreach ($users[$key] as $dat) {
                    $user = User::find($dat['user_id']);
                }
                array_push($data, $user);
            }
        } else {
            $param = null;
            if ($ticket->etat === 'Creado') {
                $ticket->etat = 'En curso';
                $ticket->orden = 2;
                $ticket->save();
            }
        }

        return view('servicio.show', compact('ticket', 'traitements', 'param','data'));
    }

    public function assign (Request $request, $id)
    {
        $ticket = Ticket::with('files')->findOrFail((int) $id);
        $ticket->agent_id = ((int) $request->get('agents'));
        $ticket->save();

        Session::flash('message', "El servicio #$id se asignó correctamente.");

        return redirect('servicios_all');
    }
}
