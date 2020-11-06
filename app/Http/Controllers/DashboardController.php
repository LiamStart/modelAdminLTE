<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if(Auth::check()){
            $month    = date('m');
            $year     = date('Y');
            $fecha    = date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
            $fecha2   = date('m-d');
            $fecha3   = $fecha;
            $fecha3   = strtotime('+1 month', strtotime($fecha3));
            $variable = date('m', $fecha3);
            $fecha3   = date('m', $fecha3);
            $fecha    = date('m');

            $ch = DB::select("SELECT *
                FROM users
                WHERE
                id_tipo <> 2 AND
                fecha_nacimiento LIKE '%-" . $fecha2 . "'
                ORDER BY DAY(fecha_nacimiento) ASC");

            $ca = DB::select("SELECT *
                FROM users
                WHERE
                id_tipo <> 2 AND
                fecha_nacimiento LIKE '%-" . $fecha . "-%' AND
                fecha_nacimiento NOT LIKE '%" . $fecha2 . "'
                ORDER BY DAY(fecha_nacimiento) ASC");
            $pm = DB::select("SELECT *
                FROM users
                WHERE
                id_tipo <> 2 AND
                fecha_nacimiento LIKE '%-" . $fecha3 . "-%'
                ORDER BY DAY(fecha_nacimiento) ASC");
           
            $users= DB::table('users')->where('estado','1')->get()->count();

            $useraccess= DB::table('users')->where('estado','1')->get();
            return view('dashboard',['ch'=>$ch,'ca'=>$ca,'pm'=>$pm,'userx'=>$users,'useraccess'=>$useraccess]);
        }else{
            return view('auth.login');
        }

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
    public function edit($id)
    {
        //
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
