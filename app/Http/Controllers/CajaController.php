<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Caja;
use App\User;
use App\Empresa;
use App\FacturaVenta;
use App\Detalle_Caja;
use Excel;
use App\Exports\CajaExport;
use App\Exports\CajaExport2;
use App\Log_Detalle_Caja;
use Illuminate\Support\Facades\Session;
class CajaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $caja= Caja::where('estado',1)->get();
        return view('caja.index',['caja'=>$caja]);
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
        return view('caja.create');
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
             'nro_caja'=>$request['nro_caja'],
             'nombre'=>$request['nombre'],
             'nombre_encargado'=>$request['nombre_encargado'],
             'estado'=>'1',
             'id_usuariocrea'=>$idusuario,
             'id_usuariomod'=>$idusuario,
             'ip_usuariomod'=>$ip_cliente,

         ];
         Caja::create($input);
         return redirect()->route('caja.index')->withStatus(__('Caja Actualizada.'));
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
        $caja= Caja::where('id',$id)->first();



        return view('caja.edit',['caja'=>$caja]);
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
        $caja= Caja::where('id',$id)->first();



        return view('caja.edit',['caja'=>$caja]);
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
        $user= Caja::where('id',$id)->first();
        $ip_cliente = $_SERVER["REMOTE_ADDR"];
        $idusuario  = Auth::user()->id;
        $input=[
            'nro_caja'=>$request['nro_caja'],
            'nombre'=>$request['nombre'],
            'nombre_encargado'=>$request['nombre_encargado'],
            'estado'=>'1',
            'id_usuariocrea'=>$idusuario,
            'id_usuariomod'=>$idusuario,
            'ip_usuariomod'=>$ip_cliente,

        ];
        $user->update($input);

        return redirect()->route('caja.index')->withStatus(__('Caja Actualizada.'));
    }

    public function destroy($id)
    {
        //
    }
    public function abrir(){
        $grupo = '1';
        $fechadesde= date('Y-m-d');
        $ip_cliente = $_SERVER["REMOTE_ADDR"];
        $fechahasta= date('Y-m-d');
        $idusuario  = Auth::user()->id;
        $validate= Detalle_Caja::whereBetween('fechaini',array($fechadesde." 00:00:00",$fechahasta." 23:59:59"))->where('id_usuario',$idusuario)->first();
        if(!is_null($validate)){
            if($validate->montofin!=null || $validate->montofin>0){
                return response()->json('Ya se abrio caja en éste día.');
            }else{
                
                Session::put('caja', $grupo);
                $usuario= User::where('id',$validate->id_usuario)->first();
                //abrimos el detalle de caja
    
                Log_Detalle_Caja::create([
                    'estado'=>'1',
                    'descripcion'=>'Se aperturó caja con el valor de '.$validate->montoini,
                    'ingreso'=>$validate->montoini,
                    'fecha'=>date('Y-m-d H:i:s'),
                    'id_detalle_caja'=>$validate->id,
                    'egreso'=>'0',
                    'id_usuariocrea'=>$idusuario,
                    'id_usuariomod'=>$idusuario,
                    'ip_usuariomod'=>$ip_cliente,
                ]);
    
                return view('asignacion.abrir_caja',['fecha'=>$fechadesde,'usuario'=>$usuario,'valor'=>$validate->montoini]);
            }
            
           
        }else{
            return response()->json('Error aun no se abre caja para este usuario.');
        }

        return response()->json('error');
    }
    public function cierre(){
        $grupo = '0';
        $fechadesde= date('Y-m-d');
        $fechahasta= date('Y-m-d');
        $ip_cliente = $_SERVER["REMOTE_ADDR"];
        $idusuario  = Auth::user()->id;
        $validate= Detalle_Caja::whereBetween('fechaini',array($fechadesde." 00:00:00",$fechahasta." 23:59:59"))->where('id_usuario',$idusuario)->first();
        if(!is_null($validate)){
            Session::put('caja', $grupo);
            $usuario= User::where('id',$validate->id_usuario)->first();
            $ventas= FacturaVenta::where('estado','1')->where('fecha',$fechadesde)->where('id_usuariocrea',$usuario->ci)->get();
            if(!is_null($ventas)){
                $contador= $ventas->count();
                $acumulador=0;
                foreach($ventas as $value){
                    $acumulador+= $value->total_final;
                }
                $idusuario  = Auth::user()->id;
                $input=[
                    'ventas'=>$contador,
                    'fechafin'=>date('Y-m-d H:i:s'),
                    'montofin'=>$acumulador,
                    'id_usuariomod'=>$idusuario,
                ];
                $validate->update($input);
                //caja detalles
                Log_Detalle_Caja::create([
                    'id_detalle_caja'=>$validate->id,
                    'estado'=>'1',
                    'descripcion'=>'Se cerró caja con el valor de '.$validate->montofin,
                    'egreso'=>$validate->montofin,
                    'fecha'=>date('Y-m-d H:i:s'),
                    'id_usuariocrea'=>$idusuario,
                    'id_usuariomod'=>$idusuario,
                    'ip_usuariomod'=>$ip_cliente,
                ]);
                return view('asignacion.cerrar_caja',['fecha'=>$fechadesde,'usuario'=>$usuario,'valor'=>$acumulador]);
            }
            return response()->json('error');
        }
       
        return response()->json('error');
    }
    public function asignacion(Request $request){
        $usuarios= User::all();
        $caja= Caja::where('estado','1')->get();
        return view('caja.asignacion',['usuario'=>$usuarios,'caja'=>$caja]);
    }
    public function storeasig(Request $request){
        
        $ip_cliente = $_SERVER["REMOTE_ADDR"];
        $idusuario  = Auth::user()->id;
        $fechadesde= date('Y-m-d');
        $fechahasta= date('Y-m-d');
        if(!is_null($request['id_usuario'])){
            $validate= Detalle_Caja::whereBetween('fechaini',array($fechadesde." 00:00:00",$fechahasta." 23:59:59"))->where('id_caja',$request['id_caja'])->where('id_usuario',$request['id_usuario'])->first();
            if(is_null($validate)){
                $input=[
                    'id_caja'=>$request['id_caja'],
                    'id_usuario'=>$request['id_usuario'],
                    'montoini'=>$request['valor'],
                    'estado'=>'1',
                    'fechaini'=>date('Y-m-d H:i:s'),
                    'id_usuariocrea'=>$idusuario,
                    'id_usuariomod'=>$idusuario,
                    'ip_usuariomod'=>$ip_cliente,
        
                ];
                $id_caja= Detalle_Caja::insertGetId($input);
                $valor= $request['valor'];
                $id_usuario= $request['id_usuario'];
                $fecha_desde= date('Y-m-d H:i:s');
                $usuario= User::where('id',$id_usuario)->first();
                $empresa= Empresa::where('ci','1316262193')->first();
                return view('caja.modaldetalle',['usuario'=>$usuario,'valor'=>$valor,'fecha'=>$fecha_desde,'empresa'=>$empresa]);
            }else{
                return response()->json('La caja ya ha sido asignada el día de hoy.');
            } 
        }

        
        return redirect()->route('caja.asignacion');
    }
    public function resumen(){
        $caja= Detalle_Caja::where('estado','1')->get();
        return view('caja.resumen',['caja'=>$caja]);
    }
    public function midetallecaja(){
        $fechadesde= date('Y-m-d');
        $fechahasta= date('Y-m-d');
        $idusuario  = Auth::user()->id;
        $validate= Detalle_Caja::whereBetween('fechaini',array($fechadesde." 00:00:00",$fechahasta." 23:59:59"))->where('id_usuario',$idusuario)->first();
        if(!is_null($validate)){
            $caja= Log_Detalle_Caja::where('estado','1')->where('id_detalle_caja',$validate->id)->get();
            return view('caja.midetalle',['caja'=>$caja]);
        }else{
            return view('errors.404');
        }
        return response()->json('error');
    }
    public function guardflu(Request $request){
        //dd($request);
        $id= $request['id_caja'];
        $valor= $request['monto'];
        $ip_cliente = $_SERVER["REMOTE_ADDR"];
        $motivo= $request['motivo'];
        $idusuario  = Auth::user()->id;
        $fechadesde= date('Y-m-d');
        $fechahasta= date('Y-m-d');
        if(!is_null($id) || !is_null($valor) || !is_null($motivo)){
            $validate= Detalle_Caja::whereBetween('fechaini',array($fechadesde." 00:00:00",$fechahasta." 23:59:59"))->where('id_usuario',$idusuario)->first();
            //dd($validate);
            if(!is_null($validate)){
                
                $log= Log_Detalle_Caja::where('estado','1')->where('id_detalle_caja',$id)->whereBetween('fecha',array($fechadesde." 00:00:00",$fechahasta." 23:59:59"))->get();
                $acumulador=0;
                $acumulador2=0;
                foreach($log as $value){
                    $acumulador+= $value->egreso;
                    $acumulador2+=$value->ingreso;
                }
                $val= $valor+$acumulador;
                $vals= $acumulador2;
                if($vals>$val){
                    Log_Detalle_Caja::create([
                        'id_detalle_caja'=>$id,
                        'estado'=>'1',
                        'fecha'=>date('Y-m-d H:i:s'),
                        'descripcion'=>$motivo,
                        'ingreso'=>'0',
                        'egreso'=>$valor,
                        'id_usuariocrea'=>$idusuario,
                        'id_usuariomod'=>$idusuario,
                        'ip_usuariomod'=>$ip_cliente,
                    ]);
                    return response()->json("ok");
                }
                else{
                    return response()->json("No se puede restar más que el monto inicial");
                }
            }
            
            
          
        }else{
            return response()->json("error");
        }
    }
    public function excel_caja( Request $request,$id){
        $fechadesde= date('Y-m-d');
        $fechahasta= date('Y-m-d');
        $idusuario  = Auth::user()->id;
        if(!is_null($id)){
            $caja= Log_Detalle_Caja::where('estado','1')->where('id_detalle_caja',$id)->get();
            $validate= Detalle_Caja::whereBetween('fechaini',array($fechadesde." 00:00:00",$fechahasta." 23:59:59"))->where('id_usuario',$idusuario)->first();
            if(!is_null($validate)){
                $fecha_desde= $validate->fechaini;
                $fecha_hasta= $validate->fechafin;
                if($fecha_hasta==null){
                    $fecha_hasta= date('Y-m-d H:i:s');
                }
                $empresa= Empresa::where('ci','1316262193')->first();
               /* Excel::store('Reporte de Caja-'.$fecha_desde.'-al-'.$fecha_hasta, function($excel) use($empresa, $caja, $fecha_hasta, $fecha_desde) {
                    $excel->sheet('Informe Saldo', function($sheet) use ($empresa, $fecha_desde, $fecha_hasta, $caja) {
                        $sheet->mergeCells('A1:H1');
                        $sheet->cell('A1', function($cell) use ($empresa) {
                            // manipulate the cel
                            $cell->setValue($empresa->nombre);
                            $cell->setFontWeight('bold'); 
                            $cell->setFontSize('15');
                            $cell->setAlignment('center');
                            $cell->setBorder('thin', 'thin', '', 'thin');
                        });
                        $sheet->mergeCells('A2:H2');
                        $sheet->cell('A2', function($cell) use ($empresa) {
                            // manipulate the cel
                            $cell->setValue($empresa->ci);
                            $cell->setFontWeight('bold'); 
                            $cell->setFontSize('15');
                            $cell->setAlignment('center');
                            $cell->setBorder('', 'thin', 'thin', 'thin');
                        });
                        $sheet->mergeCells('A3:H3');
                        $sheet->cell('A3', function($cell) {
                            // manipulate the cel
                            $cell->setValue("INFORME CAJA");
                            $cell->setFontWeight('bold'); 
                            $cell->setFontSize('15');
                            $cell->setAlignment('center');
                            $cell->setBorder('thin', 'thin', 'thin', 'thin');
                        });
                        $sheet->mergeCells('A4:H4');
                        $sheet->cell('A4', function($cell) use($fecha_desde, $fecha_hasta)  {
                            // manipulate the cel
                            if($fecha_desde!=null){
                                $cell->setValue("Desde ".$fecha_desde." Hasta ". date("d-m-Y", strtotime($fecha_hasta)));
                            }else{
                                $cell->setValue("Al ". date("d-m-Y", strtotime($fecha_hasta)));
                            }
                            $cell->setFontWeight('bold');
                            $cell->setFontSize('12');
                            $cell->setAlignment('center');
                            $cell->setBorder('thin', 'thin', 'thin', 'thin');
                        });
                        //$sheet->mergeCells('A4:A5');
                        $sheet->cell('A5', function($cell) {
                            // manipulate the cel
                            $cell->setValue('FECHA Y HORA');
                            $cell->setBorder('thin', 'thin', 'thin', 'thin'); 
                        });
                        $sheet->mergeCells('B5:E5');
                        $sheet->cell('B5', function($cell) {
                            // manipulate the cel
                            $cell->setValue('DESCRIPCION');
                            $cell->setBorder('thin', 'thin', 'thin', 'thin');
                            
                        });
                        $sheet->cell('F5', function($cell) {
                            // manipulate the cel
                            $cell->setValue('ENTRADA');
                            $cell->setBorder('thin', 'thin', 'thin', 'thin'); 
                        });
                        $sheet->cell('G5', function($cell) {
                            // manipulate the cel
                            $cell->setValue('SALIDA');
                            $cell->setBorder('thin', 'thin', 'thin', 'thin'); 
                        });
                        
                        // DETALLES
                        
                        $sheet->setColumnFormat(array(
                            'F' => '0.00', 
                            'G' => '0.00', 
                            
                        ));
                       
                        $i = $this->setDetalles($caja, $sheet, 6,$fecha_hasta);
                        // $i = $this->setDetalles($pasivos, $sheet, $i);
                        // $i = $this->setDetalles($patrimonio, $sheet, $i, $totpyg);
        
                        //  CONFIGURACION FINAL 
                        $sheet->cells('A3:G3', function($cells) {
                            // manipulate the range of cells
                            $cells->setBackground('#0070C0');
                            // $cells->setFontSize('10');
                            $cells->setFontWeight('bold');
                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            $cells->setValignment('center');
                        });
        
                        $sheet->cells('A5:G5', function($cells) {
                            // manipulate the range of cells
                            $cells->setBackground('#cdcdcd'); 
                            $cells->setFontWeight('bold');
                            $cells->setFontSize('12');
                        });
        
        
                        $sheet->setWidth(array(
                            'A'     =>  12,
                            'B'     =>  12,
                            'C'     =>  12,
                            'D'     =>  12,
                            'E'     =>  12,
                            'F'     =>  12,
                            'G'     =>  12,
                            'H'     =>  12,
                        ));
        
                    });
                })->export('xlsx');*/
                
                return Excel::download(new CajaExport($fecha_desde,$fecha_hasta,$empresa),'reporte_caja.xlsx');
            }
           
        }
        return response()->json('error');
    }
    public function excel_caja2( Request $request){
        $fechadesde= date('Y-m-d');
        $fechahasta= date('Y-m-d');
        $idusuario  = Auth::user()->id;
        $id='0';
        if(!is_null($id)){
           
            $validate= Detalle_Caja::whereBetween('fechaini',array($fechadesde." 00:00:00",$fechahasta." 23:59:59"))->where('id_usuario',$idusuario)->first();
            if(!is_null($validate)){
                $fecha_desde= $validate->fechaini;
                $fecha_hasta= $validate->fechafin;
                if($fecha_hasta==null){
                    $fecha_hasta= date('Y-m-d H:i:s');
                }
                $empresa= Empresa::where('ci','1316262193')->first();
               /* Excel::store('Reporte de Caja-'.$fecha_desde.'-al-'.$fecha_hasta, function($excel) use($empresa, $caja, $fecha_hasta, $fecha_desde) {
                    $excel->sheet('Informe Saldo', function($sheet) use ($empresa, $fecha_desde, $fecha_hasta, $caja) {
                        $sheet->mergeCells('A1:H1');
                        $sheet->cell('A1', function($cell) use ($empresa) {
                            // manipulate the cel
                            $cell->setValue($empresa->nombre);
                            $cell->setFontWeight('bold'); 
                            $cell->setFontSize('15');
                            $cell->setAlignment('center');
                            $cell->setBorder('thin', 'thin', '', 'thin');
                        });
                        $sheet->mergeCells('A2:H2');
                        $sheet->cell('A2', function($cell) use ($empresa) {
                            // manipulate the cel
                            $cell->setValue($empresa->ci);
                            $cell->setFontWeight('bold'); 
                            $cell->setFontSize('15');
                            $cell->setAlignment('center');
                            $cell->setBorder('', 'thin', 'thin', 'thin');
                        });
                        $sheet->mergeCells('A3:H3');
                        $sheet->cell('A3', function($cell) {
                            // manipulate the cel
                            $cell->setValue("INFORME CAJA");
                            $cell->setFontWeight('bold'); 
                            $cell->setFontSize('15');
                            $cell->setAlignment('center');
                            $cell->setBorder('thin', 'thin', 'thin', 'thin');
                        });
                        $sheet->mergeCells('A4:H4');
                        $sheet->cell('A4', function($cell) use($fecha_desde, $fecha_hasta)  {
                            // manipulate the cel
                            if($fecha_desde!=null){
                                $cell->setValue("Desde ".$fecha_desde." Hasta ". date("d-m-Y", strtotime($fecha_hasta)));
                            }else{
                                $cell->setValue("Al ". date("d-m-Y", strtotime($fecha_hasta)));
                            }
                            $cell->setFontWeight('bold');
                            $cell->setFontSize('12');
                            $cell->setAlignment('center');
                            $cell->setBorder('thin', 'thin', 'thin', 'thin');
                        });
                        //$sheet->mergeCells('A4:A5');
                        $sheet->cell('A5', function($cell) {
                            // manipulate the cel
                            $cell->setValue('FECHA Y HORA');
                            $cell->setBorder('thin', 'thin', 'thin', 'thin'); 
                        });
                        $sheet->mergeCells('B5:E5');
                        $sheet->cell('B5', function($cell) {
                            // manipulate the cel
                            $cell->setValue('DESCRIPCION');
                            $cell->setBorder('thin', 'thin', 'thin', 'thin');
                            
                        });
                        $sheet->cell('F5', function($cell) {
                            // manipulate the cel
                            $cell->setValue('ENTRADA');
                            $cell->setBorder('thin', 'thin', 'thin', 'thin'); 
                        });
                        $sheet->cell('G5', function($cell) {
                            // manipulate the cel
                            $cell->setValue('SALIDA');
                            $cell->setBorder('thin', 'thin', 'thin', 'thin'); 
                        });
                        
                        // DETALLES
                        
                        $sheet->setColumnFormat(array(
                            'F' => '0.00', 
                            'G' => '0.00', 
                            
                        ));
                       
                        $i = $this->setDetalles($caja, $sheet, 6,$fecha_hasta);
                        // $i = $this->setDetalles($pasivos, $sheet, $i);
                        // $i = $this->setDetalles($patrimonio, $sheet, $i, $totpyg);
        
                        //  CONFIGURACION FINAL 
                        $sheet->cells('A3:G3', function($cells) {
                            // manipulate the range of cells
                            $cells->setBackground('#0070C0');
                            // $cells->setFontSize('10');
                            $cells->setFontWeight('bold');
                            $cells->setBorder('thin', 'thin', 'thin', 'thin');
                            $cells->setValignment('center');
                        });
        
                        $sheet->cells('A5:G5', function($cells) {
                            // manipulate the range of cells
                            $cells->setBackground('#cdcdcd'); 
                            $cells->setFontWeight('bold');
                            $cells->setFontSize('12');
                        });
        
        
                        $sheet->setWidth(array(
                            'A'     =>  12,
                            'B'     =>  12,
                            'C'     =>  12,
                            'D'     =>  12,
                            'E'     =>  12,
                            'F'     =>  12,
                            'G'     =>  12,
                            'H'     =>  12,
                        ));
        
                    });
                })->export('xlsx');*/
                
                return Excel::download(new CajaExport2($fecha_desde,$fecha_hasta,$empresa),'reporte_caja.xlsx');
            }
           
        }
        return response()->json('error');
    }
    public function setDetalles($consulta,$sheet, $i,$fecha_hasta){
        foreach($consulta as $value){
            $sheet->cell('A'.$i, function($cell) use($value) {
                // manipulate the cel
                $cell->setValue($value->fecha); 
                $cell->setBorder('thin', 'thin', 'thin', 'thin');
                // $this->setSangria($cont, $cell);
            });
            $sheet->mergeCells('B'.$i.':E'.$i);
            $sheet->cell('B'.$i, function($cell) use($value) {
                // manipulate the cel
                $cell->setValue($value->descripcion); 
                $cell->setBorder('thin', 'thin', 'thin', 'thin');
                // $this->setSangria($cont, $cell);
            });
            $sheet->cell('F'.$i, function($cell) use($value) {
                // manipulate the cel
                $cell->setValue($value->ingreso); 
                $cell->setBorder('thin', 'thin', 'thin', 'thin');
                // $this->setSangria($cont, $cell);
            });
            $sheet->cell('G'.$i, function($cell) use($value) {
                // manipulate the cel
                $cell->setValue($value->egreso); 
                $cell->setBorder('thin', 'thin', 'thin', 'thin');
                // $this->setSangria($cont, $cell);
            });
          
            $i++;
        }
        $i++;
        $sheet->mergeCells('A'.$i.':D'.$i);
        $sheet->cell('A'.$i, function($cell)  {
            // manipulate the cel
            $cell->setValue('______________________________'); 
           
            // $this->setSangria($cont, $cell);
        });
        $sheet->mergeCells('F'.$i.':G'.$i);
        $sheet->cell('F'.$i, function($cell)  {
            // manipulate the cel
            $cell->setValue('______________________________'); 
           
            // $this->setSangria($cont, $cell);
        });
        $i++;
        $sheet->mergeCells('A'.$i.':D'.$i);
        $sheet->cell('A'.$i, function($cell)  {
            // manipulate the cel
            $cell->setValue('FIRMA'); 
           
            // $this->setSangria($cont, $cell);
        });
        $sheet->mergeCells('F'.$i.':G'.$i);
        $sheet->cell('F'.$i, function($cell)  {
            // manipulate the cel
            $cell->setValue('FIRMA2'); 
           
            // $this->setSangria($cont, $cell);
        });
        $sheet->getStyle('A'.$i)->getAlignment()->setWrapText(true);

        $sheet->cells('F5:F'.$i, function($cells) { 
            $cells->setAlignment('right');
        });
        $sheet->cells('G5:G'.$i, function($cells) {     
            $cells->setAlignment('right');
        });
        $sheet->cells('H5:H'.$i, function($cells) { 
            $cells->setAlignment('right');
        });
        return $i;
    }
}
