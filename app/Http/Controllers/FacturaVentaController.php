<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Configuracion;
use App\Detalle_Factura_Venta;
use App\FacturaVenta;
use App\FormasPago;
use App\Movimiento;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Log_Movimiento;
use App\Log_Detalle_Caja;
use Session;
use App\Producto;
use App\Empresa;
use App\Detalle_Caja;

class FacturaVentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ventas = FacturaVenta::where('estado', '1')->get();
        return view('factura_venta.index', ['ventas' => $ventas]);
    }

    public function create()
    {
        $empleados = Cliente::where('estado', '1')->get();
        $configuracion = Configuracion::where('id', '1')->first();
        $contador_ctv = DB::table('factura_venta')->get()->count();
        $numero_factura = 0;
        if ($contador_ctv == 0) {
            $num = '1';
            $numero_factura = str_pad($num, 9, "0", STR_PAD_LEFT);
        } else {

            //Obtener Ultimo Registro de la Tabla ct_compras
            $max_id = DB::table('factura_venta')->max('id');

            if (($max_id >= 1) && ($max_id < 10)) {
                $nu = $max_id + 1;
                $numero_factura = str_pad($nu, 9, "0", STR_PAD_LEFT);
            }

            if (($max_id >= 10) && ($max_id < 100)) {
                $nu = $max_id + 1;
                $numero_factura = str_pad($nu, 9, "0", STR_PAD_LEFT);
            }

            if (($max_id >= 100) && ($max_id < 1000)) {
                $nu = $max_id + 1;
                $numero_factura = str_pad($nu, 9, "0", STR_PAD_LEFT);
            }

            if ($max_id == 1000) {
                $numero_factura = $max_id;
            }
        }
        $formas_pago = FormasPago::where('estado', '1')->get();
        $idusuario2= Auth::user()->id;
        $caja= Detalle_Caja::where('id_usuario',$idusuario2)->where('estado','1')->where('fechaini','<',date('Y-m-d')." 23:59:59")->first();
        return view('factura_venta.create', ['empleados' => $empleados, 'iva' => $configuracion->valor, 'numero' => $numero_factura, 'formas_pago' => $formas_pago,'caja'=>$caja]);
    }

    public function store(Request $request)
    {
        //aqui va el guardado pero me falta aun
        $ip_cliente = $_SERVER["REMOTE_ADDR"];
        $idusuario  = Auth::user()->ci;
        $fecha_hoy = date('Y-m-d');
        $contador_ctv= DB::table('factura_venta')->get()->count();
        $sessiondata = session::get('caja');
        if(!is_null($sessiondata) && $sessiondata==1){
            if (!is_null($request['id_cliente'])) {
                $numero_factura=0;
                if($contador_ctv == 0){
                    $num = '1';
                    $numero_factura = str_pad($num, 9, "0", STR_PAD_LEFT);
                }else{
    
                    //Obtener Ultimo Registro de la Tabla ct_compras
                    $max_id = DB::table('factura_venta')->max('id');
    
                    if(($max_id>=1)&&($max_id<10)){
                    $nu = $max_id+1;
                    $numero_factura = str_pad($nu, 9, "0", STR_PAD_LEFT);
    
                    }
    
                    if(($max_id>=10)&&($max_id<99)){
                    $nu = $max_id+1;
                    $numero_factura = str_pad($nu, 9, "0", STR_PAD_LEFT);
    
                    }
    
                    if(($max_id>=100)&&($max_id<1000)){
                    $nu = $max_id+1;
                    $numero_factura = str_pad($nu, 9, "0", STR_PAD_LEFT);
    
                    }
    
                    if($max_id == 1000){
                    $numero_factura = $max_id;
    
                    }
    
    
                }
                $idusuario2  = Auth::user()->id;
                $caja= Detalle_Caja::where('id_usuario',$idusuario2)->where('estado','1')->whereBetween('fechaini',array(date('Y-m-d')." 00:00:00", date('Y-m-d')." 23:59:59"))->first();
                
                $consulta_cliente = Cliente::where('ci', $request['id_cliente'])->where('estado', '1')->first();
                if (!is_null($consulta_cliente) && !is_null($caja)) {
                    $input = [
                        'id_cliente'                    => $request['id_cliente'],
                        'fecha'                         => $fecha_hoy,
                        'nro_comprobante'               => $caja->caja->codigo."-".$numero_factura,
                        'secuencia'                     => $numero_factura,
                        'id_pago'                       => $request['formas_pago'],
                        'estado'                        => '1',
                        'observaciones'                 => $request['concepto'] . ' fecha :' . $fecha_hoy,
                        'subtotal0'                      => $request['subtotal_final'],
                        'subtotal12'                     => '0',
                        'iva_total'                     => $request['iva_final'],
                        'total_final'                   => $request['total_final'],
                        'ip_creacion'                   => $ip_cliente,
                        'ip_modificacion'               => $ip_cliente,
                        'id_usuariocrea'                => $idusuario,
                        'id_usuariomod'                 => $idusuario,
                    ];
                    if($request['iva_final']>0){
                        $input = [
                            'id_cliente'                    => $request['id_cliente'],
                            'fecha'                         => $fecha_hoy,
                            'secuencia'                     => $numero_factura,
                            'subtotal0'                     => '0',
                            'id_pago'                       => $request['formas_pago'],
                            'estado'                        => '1',
                            'observaciones'                 => $request['concepto'] . ' fecha :' . $fecha_hoy,
                            'subtotal12'                    => $request['subtotal_final'],
                            'iva_total'                     => $request['iva_final'],
                            'total_final'                   => $request['total_final'],
                            'ip_creacion'                   => $ip_cliente,
                            'ip_modificacion'               => $ip_cliente,
                            'id_usuariocrea'                => $idusuario,
                            'id_usuariomod'                 => $idusuario,
                        ];
                    }
                    //crear otro log
                    $log_caja= Log_Detalle_Caja::where('id_detalle_caja',$caja->id)->whereBetween('fecha',array(date('Y-m-d')." 00:00:00",date('Y-m-d')." 23:59:59"))->get();
                    if(!is_null($log_caja)){
                        Log_Detalle_Caja::create([
                            'estado'=>'1',
                            'descripcion'=>'Venta a '.$consulta_cliente->nombre,
                            'ingreso'=>$request['total_final'],
                            'fecha'=>date('Y-m-d H:i:s'),
                            'id_detalle_caja'=>$caja->id,
                            'egreso'=>'0',
                            'id_usuariocrea'=>$idusuario2,
                            'id_usuariomod'=>$idusuario,
                            'ip_usuariomod'=>$ip_cliente,
                        ]);
                    }
                    
                    $id_compra = FacturaVenta::insertGetId($input);
                    $variable = $request['contador'];
                    if ($variable != null || $variable != '') {
                        for ($i = 0; $i <=$variable; $i++) {
                            if (!is_null($request['codigo' . $i])) {
                                //actualizar cantidad de producto
    
                                $producto = Producto::where('codigo', $request['codigo' . $i])->first();
                                if (!is_null($producto)) {
                                    if ($producto->cantidad > 0) {
                                        $resta_cantidad= ($producto->cantidad)-$request['canti'.$i];
                                        if($resta_cantidad>0){
                                            $actualizar = [
                                                'cantidad'                      => $resta_cantidad,
                                                'ip_usuariomod'                 => $ip_cliente,
                                                'id_usuariocrea'                => $idusuario,
                                                'id_usuariomod'                 => $idusuario,
                                            ];
                                            $producto->update($actualizar);
                                            Detalle_Factura_Venta::create([
                                                'id_factura'                    => $id_compra,
                                                'codigo'                        => $request['codigo' . $i],
                                                'nombre'                        => $request['nombre' . $i],
                                                'estado'                        => '1',
                                                'cantidad'                      => $request['canti' . $i],
                                                'total'                         => $request['extendido' . $i],
                                                'precio'                        => $request['precio' . $i],
                                                'iva'                           => $request['iva' . $i],
                                                'ip_creacion'                   => $ip_cliente,
                                                'ip_modificacion'               => $ip_cliente,
                                                'id_usuariocrea'                => $idusuario,
                                                'id_usuariomod'                 => $idusuario,
                                            ]);
                                            $movimiento = [
                                                'codigo' => $request['codigo_pedido'],
                                                'id_producto' => $request['codigo' . $i],
                                                'fecha' => $fecha_hoy,
                                                'observacion' => 'El cliente ' . $consulta_cliente->nombre . ' fecha :' . $fecha_hoy . ' , se vendió producto',
                                                'estado' => '1',
                                                'id_usuariocrea' => $idusuario,
                                                'id_usuariomod' => $idusuario,
                                                'ip_usuariomod' => $ip_cliente,
                                            ];
                                            $id_movimiento = Movimiento::insertGetId($movimiento);
                                            $detalle_movimiento = [
                                                'id_movimiento' => $id_movimiento,
                                                'id_producto' => $request['codigo' . $i],
                                                'fecha' => $fecha_hoy,
                                                'estado' => '1',
                                                'observacion' => 'El cliente ' . $consulta_cliente->nombre . ' fecha :' . $fecha_hoy . ' , se vendió producto',
                                                'id_usuariocrea' => $idusuario,
                                                'id_usuariomod' => $idusuario,
                                                'ip_usuariomod' => $ip_cliente,
                                            ];
                                            $id_detalle = Log_Movimiento::insertGetId($detalle_movimiento);
                                        }else{
                                            return 'Cantidad no permitida de uso de productos.';
                                        }
    
                                    }
                                }
                            }
                        }
                    } else {
                        return 'error';
                    }
                } else {
                    return response()->json('errors');
                }
            }
        }else{
            return response()->json('Primero debes abrir caja antes de guardar una factura de venta.');
        }

    }
    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $empleados = Cliente::where('estado', '1')->get();
        $formas_pago = FormasPago::where('estado', '1')->get();
        $ventas= FacturaVenta::where('estado','1')->where('id',$id)->first();
        return view('factura_venta.edit',['empleados'=>$empleados,'formas_pago'=>$formas_pago,'ventas'=>$ventas,'numero'=>'1']);
    }
    public function anular(Request $request)
    {
        $ip_cliente = $_SERVER["REMOTE_ADDR"];
        $idusuario  = Auth::user()->ci;
        if(!is_null($request['id'])){
            $ventas = FacturaVenta::where('id', $request['id'])->first();
            if(!is_null($ventas)){
                $input = [
                    'estado'                        => '0',
                    'ip_creacion'                   => $ip_cliente,
                    'ip_modificacion'               => $ip_cliente,
                    'id_usuariocrea'                => $idusuario,
                    'id_usuariomod'                 => $idusuario,
                ];
                $ventas->update($input);

            }else{
                return 'error consulta';
            }
        }else{
            return 'error vacio';
        }
        return response()->json('ok');
    }

    public function destroy($id)
    {
        //
    }
    public function pdf(Request $request,$id){
        if(!is_null($id)){
            $fact_venta= FacturaVenta::find($id);
            $empresa= Empresa::where('ci','1316262193')->first();
            $vistaurl="factura_venta.pdf";
            $view =  \View::make($vistaurl, compact('fact_venta','empresa'))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            $pdf->setOptions(['dpi' => 150, 'isPhpEnabled' => true]);
            $pdf->setPaper('A4', 'portrait');

            return $pdf->stream('orden_venta-'.$id.'.pdf');
        }else{  
            return response()->json('error');
        }
    }
}
