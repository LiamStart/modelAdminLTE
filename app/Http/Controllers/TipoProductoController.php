<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\TipoProducto;
class TipoProductoController extends Controller
{
    public function index()
    {
        $tipo= TipoProducto::where('estado',1)->get();
        return view('tipo_producto.index',['tipo'=>$tipo]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tipo_producto.create');
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
            'nombre'=>$request['nombre'],
            'descripcion'=>$request['descripcion'],
            'estado'=>'1',
            'id_usuariocrea'=>$idusuario,
            'id_usuariomod'=>$idusuario,
            'ip_usuariomod'=>$ip_cliente,

         ];
         TipoProducto::create($input);
         return redirect()->route('tipo_producto')->withStatus(__('Tipo Producto Creado.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente= TipoProducto::where('ci',$id)->first();



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
        $tipo= TipoProducto::where('id',$id)->first();

        return view('tipo_producto.edit',['cliente'=>$tipo]);
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
        $user= TipoProducto::where('id',$id)->first();
        if($user!=null){
         $ip_cliente = $_SERVER["REMOTE_ADDR"];
         $idusuario  = Auth::user()->id;
         $input=[
          'nombre'=>$request['nombre'],
          'descripcion'=>$request['descripcion'],
          'estado'=>'1',
          'id_usuariocrea'=>$idusuario,
          'id_usuariomod'=>$idusuario,
          'ip_usuariomod'=>$ip_cliente,

         ];
         $user->update($input);
        }else{
            return 'error';
        }


        return redirect()->route('tipo_producto')->withStatus(__('Cliente Actualizada.'));
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
