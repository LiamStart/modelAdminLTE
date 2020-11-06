<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\TipoPregunta;
class TipoPreguntaController extends Controller
{
    public function index(Request $request){
        $tipo= TipoPregunta::where('estado',1)->get();
        return view('tipo_pregunta.index',['tipo'=>$tipo]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tipo_pregunta.create');
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
            'descripcion'=>$request['nombre'],
            'estado'=>'1',
            'id_usuariocrea'=>$idusuario,
            'tipo_preguntacol'=>$request['color-picker'],
            'id_usuariomod'=>$idusuario,
            'ip_usuariomod'=>$ip_cliente,

         ];
         TipoPregunta::create($input);
         return redirect()->route('tipo_pregunta')->withStatus(__('Tipo Pregunta Creado.'));
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
        $tipo= TipoPregunta::where('id',$id)->first();

        return view('tipo_pregunta.edit',['cliente'=>$tipo]);
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
        $user= TipoPregunta::where('id',$id)->first();
        if($user!=null){
         $ip_cliente = $_SERVER["REMOTE_ADDR"];
         $idusuario  = Auth::user()->id;
         $input=[
    
          'descripcion'=>$request['nombre'],
          'estado'=>'1',
          'tipo_preguntacol'=>$request['color-picker'],
          'id_usuariocrea'=>$idusuario,
          'id_usuariomod'=>$idusuario,
          'ip_usuariomod'=>$ip_cliente,

         ];
         $user->update($input);
        }else{
            return 'error';
        }


        return redirect()->route('tipo_pregunta')->withStatus(__('Cliente Actualizada.'));
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
