<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Empleados;
class EmpleadosController extends Controller
{
    private function rol(){
        $rolUsuario = Auth::user()->id_tipo;

        if(in_array($rolUsuario, array(1, 2)) == false){
          return true;
        }
    }
    public function index()
    {
        if($this->rol()){
            return response()->view('errors.404');
        }
        $empleados= Empleados::where('estado',1)->get();
        return view('empleados.index',['empleados'=>$empleados]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if($this->rol()){
            return response()->view('errors.404');
        }
        return view('empleados.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //dd($request->all());
         $ip_cliente = $_SERVER["REMOTE_ADDR"];
         $idusuario  = Auth::user()->id;
         $input=[
             'ci'=>$request['cedula'],
             'nombre'=>$request['nombre'],
             'direccion'=>$request['direccion'],
             'telefono'=>$request['telefono'],
             'email' =>$request['email'],
             'estado'=>'1',
             'id_usuariocrea'=>$idusuario,
             'id_usuariomod'=>$idusuario,
             'ip_usuariomod'=>$ip_cliente,

         ];
         Empleados::create($input);
         return redirect()->route('empleados')->withStatus(__('Proveedor Creado.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($this->rol()){
            return response()->view('errors.404');
        }
        $empleados= Empleados::where('ci',$id)->first();
        return view('empleados.edit',['proveedor'=>$empleados]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if($this->rol()){
            return response()->view('errors.404');
        }
        $empleados= Empleados::where('ci',$id)->first();
        return view('empleados.edit',['cliente'=>$empleados]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user= Empleados::where('ci',$id)->first();
        if($user!=null){
         $ip_cliente = $_SERVER["REMOTE_ADDR"];
         $idusuario  = Auth::user()->id;
         $input=[
          'ci'=>$request['cedula'],
          'nombre'=>$request['nombre'],
          'direccion'=>$request['direccion'],
          'telefono'=>$request['telefono'],
          'email' =>$request['email'],
          'estado'=>'1',
          'id_usuariocrea'=>$idusuario,
          'id_usuariomod'=>$idusuario,
          'ip_usuariomod'=>$ip_cliente,

         ];
         $user->update($input);
        }else{
            return 'error';
        }


        return redirect()->route('empleados')->withStatus(__('Empleados Actualizada.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
