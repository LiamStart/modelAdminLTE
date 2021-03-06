<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Cliente;
class ClienteController extends Controller
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
       $cliente= Cliente::where('estado',1)->get();
       return view('cliente.index',['cliente'=>$cliente]);
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
       return view('cliente.create');
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
        Cliente::create($input);
        return redirect()->route('cliente')->withStatus(__('Cliente Creado.'));
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
       $cliente= Cliente::where('ci',$id)->first();



       return view('cliente.edit',['cliente'=>$cliente]);
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
       $cliente= Cliente::where('ci',$id)->first();

       return view('cliente.edit',['cliente'=>$cliente]);
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
       $user= Cliente::where('ci',$id)->first();
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


       return redirect()->route('cliente')->withStatus(__('Cliente Actualizada.'));
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
