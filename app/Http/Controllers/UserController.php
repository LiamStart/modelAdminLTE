<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Tipo_Usuario;
use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\React;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {

        return view('users.index', ['users' => $model->paginate(15)]);
    }

    /**
     * Show the form for creating a new user
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $type= Tipo_Usuario::all();
        $users= User::all();
        return view('users.create',['type_user'=>$type,'users'=>$users]);
    }

    /**
     * Store a newly created user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, User $model)
    {
        //dd($request->all());
        $ip_cliente = $_SERVER["REMOTE_ADDR"];
        $idusuario  = Auth::user()->id;
        $input=[
            'name'=>$request['name'],
            'email'=>$request['email'],
            'ci'=>$request['cedula'],
            'fecha_nacimiento'=>$request['f_nacimiento'],
            'telefono'=>$request['phone_number'],
            'id_tipo'=>$request['tipo_usuario'],
            'password' => Hash::make($request->get('password')),
            'id_usuariocrea'=>$idusuario,
            'id_usuariomod'=>$idusuario,
            'ip_usuariomod'=>$ip_cliente,

        ];
        User::create($input);

        return redirect()->route('user.index')->withStatus(__('Usuario Creado Correctamente.'));
    }

    /**
     * Show the form for editing the specified user
     *
     * @param  \App\User  $user
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user= User::where('id',$id)->first();
        $type= Tipo_Usuario::all();


        return view('users.edit', compact('user'),['type_user'=>$type,'user'=>$user]);
    }

    /**
     * Update the specified user in storage
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request,$id)
    {
        $user= User::where('id',$id)->first();
        $ip_cliente = $_SERVER["REMOTE_ADDR"];
        $idusuario  = Auth::user()->id;
        $input_actualiza=[
            'name'=>$request['name'],
            'email'=>$request['email'],
            'ci'=>$request['cedula'],
            'fecha_nacimiento'=>$request['f_nacimiento'],
            'telefono'=>$request['phone_number'],
            'id_tipo'=>$request['tipo_usuario'],
            'password' => Hash::make($request->get('password')),
            'id_usuariocrea'=>$idusuario,
            'id_usuariomod'=>$idusuario,
            'ip_usuariomod'=>$ip_cliente,
        ];
        $user->update($input_actualiza);

        return redirect()->route('user.index')->withStatus(__('Usuario Actualizado.'));
    }

    /**
     * Remove the specified user from storage
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User  $user)
    {
        if ($user->id == 1) {
            return abort(403);
        }

        $user->delete();

        return redirect()->route('user.index')->withStatus(__('Usuario Borrado.'));
    }
}
