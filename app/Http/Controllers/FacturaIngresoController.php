<?php

namespace App\Http\Controllers;

use App\Factura_Ingreso;
use App\Empresa;
use App\Detalle_Factura_Ingreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\FacturaExport;
use Excel;
class FacturaIngresoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facturas= Factura_Ingreso::all();
        return view('factura_ingreso.index',['facturas'=>$facturas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit(Request $request)
    {
        $id= $request['id'];
        if($id!=null){
            $factura_detalle= Detalle_Factura_Ingreso::where('estado','1')->where('id_factura',$id)->get();
            return view('factura_ingreso.edit',['factura'=>$factura_detalle]);
        }else{
            return 'error';
        }
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
    public function pago(Request $request){
        $id_factura= $request['id_factura'];
        $ip_cliente = $_SERVER["REMOTE_ADDR"];
        $idusuario  = Auth::user()->ci;
        if($id_factura!=null){
            $ingreso= Factura_Ingreso::where('id',$id_factura)->first();
            if($ingreso!=null || $ingreso!='[]'){
                $input=[
                    'estado'=>'2', //factura pagada
                    'id_usuariomod'=>$idusuario,
                    'ip_modificacion'=>$ip_cliente,
                ];
                $ingreso->update($input);
            }else{
                return 'No encuentra factura';
            }

        }else{
            return 'error vacio';
        }
    }
    public function excel_nomina(Request $request){
        $fecha_desde=date('Y-m-d');
        $fecha_hasta= date('Y-m-d');
        $empresa= Empresa::where('ci','1316262193')->first();
        return Excel::download(new FacturaExport($fecha_desde." 00:00:00",$fecha_hasta." 23:59:59",$empresa),'nomina.xlsx');
    }
}
