<?php

namespace App\Http\Controllers;

use App\Categories;
use App\CategoriesUser;
use App\User;
use Illuminate\Support\Facades\Input;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    protected $roles = ['admin' => 'Administrador', 'user' => 'Usuario', 'agent' => 'Agente'];

    protected $rules = [
        'identification' => 'required',
        'name' => 'required',
        'email' => 'required|email',
        'role' => 'required',
    ];

    public function __construct()
    {
        $this->middleware(['auth', 'isadmin']);
    }

//    public function index(Request $request)
//    {
//        $users = User::byName($request->get('name'))
//                        ->where('id','<>',Auth::user()->id)->orderBy('id','desc')->paginate();
//        return view('user.table',compact('users'));
//    }

    public function show(Request $request)
    {
        $name = Input::get('name');
        $role = Input::get('role');
        if ($name || $role) {
            $users = User::byNameUser($name)->role($role)->where('id', '<>', Auth::user()->id)->orderBy('id', 'desc')->paginate(100);
        } else {
            $users = User::where('id', '<>', Auth::user()->id)->orderBy('id', 'desc')->paginate(100);
        }
        return view('user.table', compact('users'));
    }

    public function create()
    {
        $categories = Categories::all();
        $roles = $this->roles;
        $user = null;

        return view('user.partials.create', compact('user', 'roles', 'categories'));
    }

    public function store(Request $request)
    {
        dd($request->all());
        if (Auth::user()->role === 'user') {
            $this->rules['dependencia'] = 'required';
        }

        $this->validate($request, $this->rules);

        $user = new User();
        $this->saveAtrributosUser($request, $user);

        $user->password = isset($request->password) ? $request->password : bcrypt($request->identification);
        $user->save();

        if ($this->esRolAgente($request)) {
            if ($user->categories !== null) {
                $user->categories()->detach();
            }
            $this->asignarCategorias($request, $user);
        }

        Session::flash('message', 'El usuario ha sido creado éxitosamente.');

        return redirect('users_all');
    }

    public function edit(User $user)
    {
        $categories = Categories::all();
        $categorieSelected = CategoriesUser::with('categorie')->where('user_id', $user->id)->get();
        $roles = $this->roles;

        return view('user.partials.create', compact('user', 'roles', 'categories', 'categorieSelected'));
    }

    public function update(Request $request, $user)
    {
        if ($this->esRolAgente($request)) {
            $this->rules['categories'] = 'required';
        }
        $this->validate($request, $this->rules);

        $user = User::find($user);
        $this->saveAtrributosUser($request, $user);

        if ($this->esRolAgente($request)) {
            if ($user->categories !== null) {
                $user->categories()->detach();
            }
            $this->asignarCategorias($request, $user);
        }

        if ($request->password !== null) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        Session::flash('message', 'El usuario ha sido actualizado éxitosamente.');

        return redirect('users_all');
    }

    public function destroy(User $user)
    {
        if (count($user->tickets) >= 1 || count($user->traitemnts) >= 1) {
            Session::flash('message_delete', 'El usuario presenta registros en el sistema, no es posible eliminarlo');
        } else {
            $user->categories()->detach();
            $user->delete();
            Session::flash('message_delete', 'El usuario fue eliminado éxitosamente');
        }

        return redirect('users_all');
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function esRolAgente(Request $request)
    {
        return $request->role === 'agent';
    }

    /**
     * @param Request $request
     * @param $user
     */
    private function asignarCategorias(Request $request, $user)
    {
        foreach ($request->categories as $category) {
            $user->categories()->attach((int) $category);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     */
    public function saveAtrributosUser(Request $request, User $user)
    {
        $user->identification = $request->identification;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->dependencia = $request->dependencia;
    }
}
