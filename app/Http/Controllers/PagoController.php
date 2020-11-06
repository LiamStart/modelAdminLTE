<?php

namespace App\Http\Controllers;

use App\Detalle_Entrega;
use App\Detalle_Factura_Ingreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Empleados;
use App\Log_Movimiento;
use App\Movimiento;
use App\Producto;
use App\Proveedor;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empleados= Proveedor::where('estado','1')->get();
        $contador_ctv= DB::table('detalle_entrega')->get()->count();
        $numero_factura=0;
        if($contador_ctv == 0){
            $num = '1';
            $numero_factura = str_pad($num, 9, "0", STR_PAD_LEFT);
        }else{

            //Obtener Ultimo Registro de la Tabla ct_compras
            $max_id = DB::table('detalle_entrega')->max('id');

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
        return view('pago.index',['empleados'=>$empleados,'numero'=>$numero_factura]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contador_ctv= DB::table('detalle_entrega')->get()->count();
        $numero_factura=0;
        if($contador_ctv == 0){
            $num = '1';
            $numero_factura = str_pad($num, 9, "0", STR_PAD_LEFT);
        }else{

            //Obtener Ultimo Registro de la Tabla ct_compras
            $max_id = DB::table('detalle_entrega')->max('id');

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

        return view('pago.index',['numero'=>$numero_factura]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ip_cliente = $_SERVER["REMOTE_ADDR"];
        $idusuario  = Auth::user()->ci;
        $contador= $request['contador'];
        $fecha_hoy= date('Y-m-d');
        if($contador!=null || $contador!=''){
            //Movimiento
            for($i=0; $i<=$contador; $i++){
                $consulta_producto=Producto::where('codigo',$request['codProdu'.$i])->first();
                //actualizar producto
                if($consulta_producto!=null){
                    $actualizar=[
                        'cantidad'=>$consulta_producto->cantidad-$request['cantidad'.$i],
                        'id_usuariomod'=>$idusuario,
                    ];
                    $consulta_producto->update($actualizar);
                }

                $consulta_maestro= Empleados::where('ci',$request['id_cliente'])->first();
                if($consulta_maestro!=null){
                    if(!is_null($request['codProdu'.$i])){
                        $movimiento=[
                            'codigo'=>$request['codigo_pedido'],
                            'id_producto'=>$request['codProdu'.$i],
                            'fecha'=>$fecha_hoy,
                            'observacion'=> 'Se entregó producto a maestro '.$consulta_maestro->nombre.' fecha :'.$fecha_hoy,
                            'estado'=> '1',
                            'id_usuariocrea'=>$idusuario,
                            'id_usuariomod'=>$idusuario,
                            'ip_usuariomod'=>$ip_cliente,
                        ];
                        $id_movimiento= Movimiento::insertGetId($movimiento);
                        $detalle_movimiento=[
                            'id_movimiento'=>$id_movimiento,
                            'id_producto'=>$request['codProdu'.$i],
                            'fecha'=>$fecha_hoy,
                            'estado'=>'1',
                            'observacion'=> 'Se entregó producto a maestro '.$consulta_maestro->nombre.' fecha :'.$fecha_hoy,
                            'id_usuariocrea'=>$idusuario,
                            'id_usuariomod'=>$idusuario,
                            'ip_usuariomod'=>$ip_cliente,
                        ];
                        $id_detalle= Log_Movimiento::insertGetId($detalle_movimiento);
                        $input=[
                            'codigo_pedido'=>$request['codigo_pedido'],
                            'id_producto'=>$request['codProdu'.$i],
                            'id_cliente'=>$request['id_cliente'],
                            'estado' =>'1',
                            'observacion'=> 'Se entregó producto a maestro '.$consulta_maestro->nombre.' fecha :'.$fecha_hoy,
                            'fecha'=>$fecha_hoy,
                            'id_usuariocrea'=>$idusuario,
                            'id_usuariomod'=>$idusuario,
                            'ip_usuariomod'=>$ip_cliente,
                        ];
                        $id_productos= Detalle_Entrega::insertGetId($input);
                    }
                   
                }


            }
            return 'ok';
        }
        return 'falla contador';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        //
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
