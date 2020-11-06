<?php

namespace App\Http\Controllers;

use App\Configuracion;
use App\Detalle_Factura_Ingreso;
use App\Detalle_Ingreso;
use App\Producto;
use App\Empleados;
use App\Log_Movimiento;
use App\Movimiento;
use App\Factura_Ingreso;
use App\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\TipoProducto;
use Faker\Provider\Barcode;
use Illuminate\Support\Facades\DB;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use DNS1D;
class ProductoController extends Controller
{
    public function index()
    {
        $producto= Producto::where('estado',1)->where('tipo','1')->get();
        return view('producto.index',['producto'=>$producto]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipo= TipoProducto::where('estado',1)->get();
        return view('producto.create',['tipo'=>$tipo]);
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
             'codigo'=>$request['codigo'],
             'nombre'=>$request['nombre'],
             'id_tipo'=>$request['tipo'],
             'precio' =>$request['precio'],
             'precio_v' =>$request['precio_v'],
             'cantidad' =>$request['cantidad'],
             'stock_minimo' =>$request['stock_minimo'],
             'iva' =>$request['iva'],
             'estado'=>'1',
             'id_usuariocrea'=>$idusuario,
             'id_usuariomod'=>$idusuario,
             'ip_usuariomod'=>$ip_cliente,

         ];
         $value = $request->session()->get('caja');
         Producto::create($input);
         return redirect()->route('producto')->withStatus(__('Producto Creado.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $proveedor= Producto::where('ci',$id)->first();



        return view('producto.edit',['proveedor'=>$proveedor]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producto= Producto::where('codigo',$id)->first();
        $tipo= TipoProducto::where('estado',1)->get();


        return view('producto.edit',['producto'=>$producto,'tipo'=>$tipo]);
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
        $user= Producto::where('codigo',$id)->first();
        if($user!=null){
         $ip_cliente = $_SERVER["REMOTE_ADDR"];
         $idusuario  = Auth::user()->id;
         $input=[
            'codigo'=>$request['codigo'],
            'nombre'=>$request['nombre'],
            'id_tipo'=>$request['tipo'],
            'precio' =>$request['precio'],
            'precio_v' =>$request['precio_v'],
            'cantidad' =>$request['cantidad'],
            'stock_minimo' =>$request['stock_minimo'],
            'iva' =>$request['iva'],
            'estado'=>'1',
            'id_usuariocrea'=>$idusuario,
            'id_usuariomod'=>$idusuario,
            'ip_usuariomod'=>$ip_cliente,

        ];
         $user->update($input);
        }else{
            return 'error';
        }


        return redirect()->route('producto')->withStatus(__('Proveedor Actualizada.'));
    }

    /**
     * Remove the specified resource from storage.
     * Erro 515 se refiere que no funciona el query
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function codigo_barras($id){
        $user= Producto::where('codigo',$id)->first();
        if($user!=null && $user!='[]'){
            echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($user->codigo." ".$user->nombre, 'C39+',1,33,array(1,1,1), true) . '" alt="barcode"   />';
        }else{
            return 'error 515';
        }
    }
    public function buscar_codigo(Request $request){

        $codigo= $request['codigoEscaneado'];
        if($codigo!=null){
            $producto= Producto::where('codigo',$codigo)->first();
            if($producto!=null){
                if(($producto->cantidad)>0){
                    return $producto;
                }else{
                    return 'No hay producto';
                }
            }else{
                return 'No hay coincidencias';
            }
        }else{
            return 'No se encuentra código';
        }
    }
    public function buscarNombre(Request $request){

        $codigo= strtoupper($request['codigoEscaneado']);
        if($codigo!=null){
            $producto= Producto::where('nombre','like',$codigo)->first();
            if($producto!=null){
                if(($producto->cantidad)>0){
                    return $producto;
                }else{
                    return 'No hay producto';
                }

            }else{
                return 'No hay coincidencias';
            }
        }else{
            return 'No se encuentra código';
        }
    }
    public function ingreso(){
        $empleados= Proveedor::where('estado','1')->get();
        $configuracion = Configuracion::where('id','1')->first();
        $contador_ctv= DB::table('detalle_ingreso')->get()->count();
        $numero_factura=0;
        if($contador_ctv == 0){
            $num = '1';
            $numero_factura = str_pad($num, 9, "0", STR_PAD_LEFT);
        }else{

            //Obtener Ultimo Registro de la Tabla ct_compras
            $max_id = DB::table('detalle_ingreso')->max('id');

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
        $tipo= TipoProducto::where('estado','1')->get();

        return view('producto.ingreso',['empleados'=>$empleados,'numero'=>$numero_factura,'iva'=>$configuracion->valor,'tipo'=>$tipo]);
    }
    public function ingreso_store(Request $request){
        $ip_cliente = $_SERVER["REMOTE_ADDR"];
        $idusuario  = Auth::user()->ci;
        $consulta_maestro= Empleados::where('ci',$request['id_cliente'])->first();
        if($consulta_maestro!=null|| $consulta_maestro!='[]'){
            $fecha_hoy= date('Y-m-d');
            //Llenar producto nuevo

            $input = [
                'id_cliente'                    => $request['id_cliente'],
                'fecha'                         => $fecha_hoy,
                'estado'                        => '1',
                'observaciones'                   => 'El maestro '.$consulta_maestro->nombre.' fecha :'.$fecha_hoy.' || Entrego el producto finalizado.',
                'subtotal'                      => $request['subtotal_final1'],
                'iva_total'                     => $request['iva_final1'],
                'total_final'                   => $request['total_final1'],
                'ip_creacion'                   => $ip_cliente,
                'ip_modificacion'               => $ip_cliente,
                'id_usuariocrea'                => $idusuario,
                'id_usuariomod'                 => $idusuario,
            ];
            $id_compra = Factura_Ingreso::insertGetId($input);
            $variable = $request['contador'];
            if($variable!=null || $variable!=''){
                for ($i = 0; $i <=$variable; $i++) {
                    if (!is_null($request['nombre'.$i]) &&  !is_null($request['codigo'.$i])) {
                        $producto_new=[
                            'codigo'=>$request['codigo'.$i],
                            'nombre'=>$request['nombre'.$i],
                            'cantidad'=>$request['cantidad'.$i],
                            'iva'    =>$request['iva'.$i],
                            'tipo' =>'1',
                            'precio'=>$request['extendido'.$i],
                            'precio_v'=>$request['extendido'.$i],
                            'estado'=>'1',
                            'id_tipo'=>$request['tipo'.$i],
                            'stock_minimo'=>$request['cantidad'.$i],
                            'id_usuariocrea'=>$idusuario,
                            'id_usuariomod'=>$idusuario,
                            'ip_usuariomod'=>$ip_cliente,
                        ];
                        $s= Producto::insertGetId($producto_new);

                        Detalle_Factura_Ingreso::create([
                            'id_factura'                    => $id_compra,
                            'codigo'                        => $request['codigo'.$i],
                            'nombre'                        => $request['nombre'.$i],
                            'estado'                        => '1',
                            'cantidad'                      => $request['cantidad'.$i],
                            'total'                         => $request['extendido'.$i],
                            'precio'                        => $request['precio'.$i],
                            'iva'                           => $request['iva'.$i],
                            'ip_creacion'                   => $ip_cliente,
                            'ip_modificacion'               => $ip_cliente,
                            'id_usuariocrea'                => $idusuario,
                            'id_usuariomod'                 => $idusuario,
                        ]);
                        $movimiento=[
                            'codigo'=>$request['codigo_pedido'],
                            'id_producto'=>$request['codigo'.$i],
                            'fecha'=>$fecha_hoy,
                            'observacion'=> 'El maestro '.$consulta_maestro->nombre.' fecha :'.$fecha_hoy.' , Entregó producto terminado',
                            'estado'=> '1',
                            'id_usuariocrea'=>$idusuario,
                            'id_usuariomod'=>$idusuario,
                            'ip_usuariomod'=>$ip_cliente,
                        ];
                        $id_movimiento= Movimiento::insertGetId($movimiento);
                        $detalle_movimiento=[
                            'id_movimiento'=>$id_movimiento,
                            'id_producto'=>$request['codigo'.$i],
                            'fecha'=>$fecha_hoy,
                            'estado'=>'1',
                            'observacion'=> 'El maestro '.$consulta_maestro->nombre.' fecha :'.$fecha_hoy.' , Entregó producto terminado',
                            'id_usuariocrea'=>$idusuario,
                            'id_usuariomod'=>$idusuario,
                            'ip_usuariomod'=>$ip_cliente,
                        ];
                        $id_detalle= Log_Movimiento::insertGetId($detalle_movimiento);
                        $input=[
                            'codigo'=>$request['codigo_pedido'],
                            'id_producto'=>$request['codigo'.$i],
                            'id_cliente'=>$request['id_cliente'],
                            'estado' =>'1',
                            'observacion'=> 'El maestro '.$consulta_maestro->nombre.' fecha :'.$fecha_hoy.' , Entregó producto terminado',
                            'fecha'=>$fecha_hoy,
                            'id_usuariocrea'=>$idusuario,
                            'id_usuariomod'=>$idusuario,
                            'ip_usuariomod'=>$ip_cliente,
                        ];
                        $id_productos= Detalle_Ingreso::insertGetId($input);


                    }
                }
            }else{
                return 'error';
            }
            return 'ok';
        }else{
            return 'error empleado';
        }


    }

}
