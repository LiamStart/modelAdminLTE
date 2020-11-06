<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Proveedor;
class ProveedorController extends Controller
{
    public function index()
    {
        $proveedor= Proveedor::where('estado',1)->get();
        return view('proveedor.index',['proveedor'=>$proveedor]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('proveedor.create');
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
         Proveedor::create($input);
         return redirect()->route('proveedor')->withStatus(__('Proveedor Creado.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proveedor= Proveedor::where('ci',$id)->first();



        return view('proveedor.edit',['proveedor'=>$proveedor]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proveedor= Proveedor::where('cis',$id)->first();



        return view('proveedor.edit',['proveedor'=>$proveedor]);
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
        $user= Proveedor::where('ci',$id)->first();
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


        return redirect()->route('proveedor')->withStatus(__('Proveedor Actualizada.'));
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
