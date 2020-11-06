<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PreguntaCabecera;
use App\PreguntaDetalle;
use Illuminate\Support\Facades\Auth;
use App\TipoPregunta;
class PreguntaController extends Controller
{
    public function index(){
        $pregunta= PreguntaCabecera::where('estado','1')->get();
        return view('pregunta.index',['pregunta'=>$pregunta]);
    }
    public function create()
    {
        $tipo_pregunta= TipoPregunta::where('estado','1')->get();
        return view('pregunta.create',['tipo'=>$tipo_pregunta]);
    }
    public function store(Request $request)
    {
         //dd($request->all());
         $ip_cliente = $_SERVER["REMOTE_ADDR"];
         $idusuario  = Auth::user()->id;
         $input=[
            'descripcion'=>$request['descripcion'],
            'tipo'=>$request['tipo'],
            'estado'=>'1',
            'id_usuariocrea'=>$idusuario,
            'id_usuariomod'=>$idusuario,
            'ip_usuariomod'=>$ip_cliente,

         ];
         $id_pregunta=PreguntaCabecera::insertGetId($input);

         for($i=0; $i<=$request['contador']; $i++){
             if(!is_null($request['opciones'.$i])){
                $input2=[
                    'id_cabecera'=>$id_pregunta,
                    'respuesta'=>$request['res'.$i],
                    'opcion'=>$request['opciones'.$i],
                 ];
                 PreguntaDetalle::create($input2);
             }
         }

         return redirect()->route('pregunta')->withStatus(__('Tipo Pregunta Creado.'));
    }
    public function edit($id)
    {
        $pregunta= PreguntaCabecera::where('estado','1')->where('id',$id)->first();
        $pregunta_detalle= PreguntaDetalle::where('estado','1')->where('id_cabecera',$id)->get();
        $tipo_pregunta= TipoPregunta::where('estado','1')->get();
        return view('pregunta.edit',['pregunta'=>$pregunta,'detalles'=>$pregunta_detalle,'tipo'=>$tipo_pregunta]);
       
        
    }
    public function update($id,Request $request)
    {
         //dd($request->all());
         date_default_timezone_set("America/Guayaquil");
         $ip_cliente = $_SERVER["REMOTE_ADDR"];
         $idusuario  = Auth::user()->id;
         $pregunta= PreguntaCabecera::where('estado','1')->where('id',$id)->first();
         $pregunta_detalle= PreguntaDetalle::where('estado','1')->where('id_cabecera',$id)->get();
         $input=[
            'descripcion'=>$request['descripcion'],
            'tipo'=>$request['tipo'],
            'estado'=>'1',
            'id_usuariocrea'=>$idusuario,
            'id_usuariomod'=>$idusuario,
            'ip_usuariomod'=>$ip_cliente,

         ];
         $pregunta->update($input);
         foreach($pregunta_detalle as $value){
             $id_detalle=$value->id;
             $pregunta_detallex= PreguntaDetalle::where('estado','1')->where('id',$id_detalle)->first();
             if(!is_null($pregunta_detallex)){
                $pregunta_detallex->estado=0;
                $pregunta_detallex->save();
             }
         }
         for($i=0; $i<=$request['contador']; $i++){
            if(!is_null($request['opciones'.$i])){
               $input2=[
                   'id_cabecera'=>$id,
                   'respuesta'=>$request['res'.$i],
                   'opcion'=>$request['opciones'.$i],
                ];
                PreguntaDetalle::create($input2);
            }
        }
         

         return redirect()->route('pregunta')->withStatus(__('Tipo Pregunta Creado.'));
    }
}
