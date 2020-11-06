<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PreguntaCabecera;
use App\PreguntaDetalle;
use App\PreguntaUsuario;
use App\PreguntaUsuarioDetalle;
use Illuminate\Support\Facades\Auth;
use App\TipoPregunta;
use App\User;
use Illuminate\Support\Facades\DB;
class TestController extends Controller
{
    public function index(){
        $pregunta= PreguntaCabecera::where('estado','1')->get();
         
        return view('test.index',['preguntas'=>$pregunta]);
    }
    public function store(Request $request)
    {
         //dd($request->all());
         $ip_cliente = $_SERVER["REMOTE_ADDR"];
         $idusuario  = Auth::user()->id;
         $nombreusuario= Auth::user()->name;
         //dd($request->all());


         $input=[
            'nombre'=>$nombreusuario,
            'id_pregunta'=>$request['cabecera'],
            'estado'=>'1',
            'id_usuariocrea'=>$idusuario,
         ];
         $id_pregunta=PreguntaUsuario::insertGetId($input);
        //dd($request['mirespuesta']);
         foreach($request['mirespuesta'] as $key=>$sx){
         
                 //$id_pregunta=2;
            
            $consulta_plis=PreguntaDetalle::where('id',$sx)->first();
            $tipo="";
            $verificar=0;
            if(isset($consulta_plis->cabecera)){
                $tipo= $consulta_plis->cabecera->tipo;
            }
            if($consulta_plis->respuesta==1){
                $verificar=1;
            }
            $x=[ 
                'id_cabecera'=>$id_pregunta,
                'id_detalle'=>$sx,
                'tipo'=>$tipo,
                'check'=>$verificar,
            ];
            //dd($x);
            $id_preguntas=PreguntaUsuarioDetalle::insertGetId($x);
         }

         return redirect()->route('test')->withStatus(__('Tipo Pregunta Creado.'));
    }
    public function mytest(){
        $idusuario  = Auth::user()->id;
        $pregunta= PreguntaUsuario::where('estado','1')->where('id_usuariocrea',$idusuario)->get();
         
        return view('mitest.index',['pregunta'=>$pregunta]);
    }
    public function observar($id){
        $idusuario  = Auth::user()->id;
        $verificar= PreguntaUsuarioDetalle::where('id_cabecera',$id)->get();
        $pregunta= PreguntaCabecera::where('estado','1')->get();
        return view('mitest.observar',['verificar'=>$verificar,'preguntas'=>$pregunta]);
    }
    public function estadisticos($id){
        $idusuario  = Auth::user()->id;
        $verificar= DB::table('preguntas_usuario_detalle')->where('id_cabecera',$id)->select(DB::raw('SUM(preguntas_usuario_detalle.check) as total'),'preguntas_usuario_detalle.tipo')->groupBy('preguntas_usuario_detalle.tipo')
        ->get();
        $pregunta= PreguntaCabecera::where('estado','1')->get();
        $tipo_pregunta= TipoPregunta::where('estado','1')->get();
        $arrayacumulativo=[];
        //dd($verificar);
        $ved=0;
       
        return view('mitest.estadisticos',['verificar'=>$verificar,'preguntas'=>$pregunta,'tipo_pregunta'=>$tipo_pregunta]);
    }
    public function index2(Request $request){
        $idusuario  = Auth::user()->id;
        $id=$request['id_estudiante'];
        $fecha_desde= str_replace('/','-',$request['desde']);
        $fecha_hasta= str_replace('/','-',$request['hasta']);

        //dd($fecha_hasta);
        $verificar=[];
        if(!is_null($id)){
            $cabecera= DB::table('preguntas_usuario')->where('id_usuariocrea',$id)->whereBetween('created_at',[$request['desde']." 00:00:00",$request['hasta']." 23:59:59"])->first();
            //dd($cabecera);
            if(!is_null($cabecera)){
                $verificar= DB::table('preguntas_usuario_detalle')->where('id_cabecera',$cabecera->id)->select(DB::raw('SUM(preguntas_usuario_detalle.check) as total'),'preguntas_usuario_detalle.tipo')->groupBy('preguntas_usuario_detalle.tipo')
                ->get();
            }
           
        }

        $pregunta= PreguntaCabecera::where('estado','1')->get();
        $tipo_pregunta= TipoPregunta::where('estado','1')->get();
        $arrayacumulativo=[];
        $estudiantes= User::where('id_tipo','2')->get();
        $id_us=$id;
        //dd($verificar);
        $ved=0;
       
        return view('estadisticos.index',['verificar'=>$verificar,'preguntas'=>$pregunta,'tipo_pregunta'=>$tipo_pregunta,'estudiantes'=>$estudiantes,'id_us'=>$id_us,'fecha_desde'=>$fecha_desde,'fecha_hasta'=>$fecha_hasta]);
    }
}
