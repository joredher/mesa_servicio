<?php

namespace App\Http\Controllers;

use App\Categories;
use App\UploadFile;
use Illuminate\Http\Request;
use DB;
use App\Ticket;
use App\Traitement;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Session;
use Excel;

class ServicioController extends Controller
{
    protected $rules = [
        'subject' => 'required',
        'message' => 'required|min:10',
        'priorite_id' => 'required',
    ];

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isadmin')->only('export_xls');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $priorites = DB::table('priorites')->pluck('nom', 'id');

        return view('servicio.create', compact('priorites'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('files')) {
            $nFiles = count($request->file('files'));
            foreach (range(0, $nFiles) as $item) {
                $this->rules['files.' . $item] = 'image|mimes:jpeg,bmp,png|max:2000';
            }
        }

        $this->validate($request, $this->rules);

        $data = array_add($data, 'user_id', Auth::user()->id);
        $data = array_add(
            $data,
            'categorie_id',
            Categories::where('name', '=', 'Soporte Técnico')->first()['id']
        );
        $data = array_add($data, 'fecha_creacion', Carbon::now()->toDateTimeString());
        $ticket = Ticket::create($data);

        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                $originalName = $file->getClientOriginalName();
                $uploadImage  = "public/tickets/$ticket->id/";
                $file->storeAs($uploadImage, $originalName);
                $file->move(public_path('/') . $uploadImage, $originalName);
                //Storage::disk('public')->put("tickets/$ticket->id",$originalName);
                //$fileName = pathinfo($originalName,PATHINFO_FILENAME);

                $upload = new UploadFile();
                $upload->name_file = $originalName;
                $upload->path = $uploadImage;
                $upload->ticket_id = $ticket->id;
                $upload->save();
            }
        }

        Session::flash('message', 'El servicio ha sido creado éxitosamente.');

        return redirect('servicios_all');
    }

    public function changeEtatToTerminado($id)
    {
        $ticket = Ticket::findOrFail((int) $id);
        $ticket->etat = 'Terminado';
        $ticket->save();
        return redirect('servicios_all');
    }

    public function ver($id)
    {
        $traitements = Traitement::where('ticket_id', $id)->get();
        $ticket = Ticket::with('files')->findOrFail($id);
        $param = 1;

        return view('servicio.show', compact('ticket', 'traitements', 'param'));
    }


    public function export_xls()
    {
        Excel::create('servicios', function ($excel) {
            $excel->sheet('servicios', function ($sheet) {
                $sheet->loadView('export.ticket_xls');
            })->export('xls');
        });

        return redirect('/');
    }
}
