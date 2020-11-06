<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('dashboard');
});


Auth::routes();
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/user/create', 'UserController@create')->name('user.create');
Route::get('/user/editr/{id}', 'UserController@edit')->name('users.edit');
Route::post('/user/update/{id}', 'UserController@update')->name('users.update');
Route::post('/user/store', 'UserController@store')->name('users.store');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/profile/photo','ProfileController@upload_photo')->name('profile_photo');
Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});
Route::resource('caja', 'CajaController');
Route::get('/asignar', 'CajaController@asignacion')->name('caja.asignacion');
Route::post('/cajau/asignar/store', 'CajaController@storeasig')->name('caja.asiganarstore');
Route::get('/caja/edit/{id}', 'CajaController@edit')->name('caja.edit');
Route::post('/caja/update/{id}', 'CajaController@update')->name('caja.update');
#CLIENTE
Route::get('/cliente', 'ClienteController@index')->name('cliente');
Route::get('/cliente/create', 'ClienteController@create')->name('cliente.create');
Route::get('/cliente/editar/{id}', 'ClienteController@edit')->name('cliente.edit');
Route::post('/cliente/update/{id}', 'ClienteController@update')->name('cliente.update');
Route::post('/cliente/store', 'ClienteController@store')->name('cliente.store');
#PROVEEDOR
Route::get('/proveedor', 'ProveedorController@index')->name('proveedor');
Route::get('/proveedor/create', 'ProveedorController@create')->name('proveedor.create');
Route::get('/proveedor/editar/{id}', 'ProveedorController@edit')->name('proveedor.edit');
Route::post('/proveedor/update/{id}', 'ProveedorController@update')->name('proveedor.update');
Route::post('/proveedor/store', 'ProveedorController@store')->name('proveedor.store');
# PRODUCTOS
Route::get('/producto', 'ProductoController@index')->name('producto');
Route::get('/producto/create', 'ProductoController@create')->name('producto.create');
Route::get('/producto/editar/{id}', 'ProductoController@edit')->name('producto.edit');
Route::post('/producto/update/{id}', 'ProductoController@update')->name('producto.update');
Route::post('/producto/store', 'ProductoController@store')->name('producto.store');
Route::get('/producto/codigo/barras/{id}', 'ProductoController@codigo_barras')->name('producto.barras');

#TIPOS
Route::get('/tipo', 'TipoPreguntaController@index')->name('tipo_pregunta');
Route::get('/pregunta/tipo/create', 'TipoPreguntaController@create')->name('tipo_pregunta.create');
Route::get('/pregunta/tipo/editar/{id}', 'TipoPreguntaController@edit')->name('tipo_pregunta.edit');
Route::post('/pregunta/tipo/update/{id}', 'TipoPreguntaController@update')->name('tipo_pregunta.update');
Route::post('/pregunta/tipo/store', 'TipoPreguntaController@store')->name('tipo_pregunta.store');
#EMPLEADOS
Route::get('/empleados', 'EmpleadosController@index')->name('empleados');
Route::get('/empleados/create', 'EmpleadosController@create')->name('empleados.create');
Route::get('/empleados/editar/{id}', 'EmpleadosController@edit')->name('empleados.edit');
Route::post('/empleados/update/{id}', 'EmpleadosController@update')->name('empleados.update');
Route::post('/empleados/store', 'EmpleadosController@store')->name('empleados.store');
#INGRESO PRODUCTOS
Route::get('/ingresar', 'ProductoController@ingreso')->name('producto.ingreso');
Route::get('/producto/buscar/codigo', 'ProductoController@buscar_codigo')->name('producto.buscar_codigo');
Route::get('/producto/buscar/nombre', 'ProductoController@buscarNombre')->name('producto.buscar_nombre');
Route::post('/producto/ingreso/store', 'ProductoController@ingreso_store')->name('producto.ingreso_store');
#abrir caja
Route::get('/caja/abrir/control', 'CajaController@abrir')->name('caja.abrir');
Route::get('/caja/cierre/session', 'CajaController@cierre')->name('caja.cierre');

#pago
Route::get('/entrega', 'PagoController@index')->name('entrega');
Route::get('/factura/ingreso', 'FacturaIngresoController@index')->name('factura_ingreso');
Route::get('/factura/ingresos/detalle', 'FacturaIngresoController@edit')->name('factura_ingreso.edit');
Route::post('/factura/ingreso/pago', 'FacturaIngresoController@pago')->name('factura_ingreso.pago');
Route::post('/entrega/store', 'PagoController@store')->name('entrega.store');
Route::match(['get','post'],'/empleados/search','EmpleadosController@search')->name('empleados.search');

#movimiento
Route::get('/movimiento', 'MovimientoController@index')->name('movimiento');


#ventas
Route::get('/ventas','FacturaVentaController@index')->name('ventas');
Route::get('/ventas/pdf/{id}','FacturaVentaController@pdf')->name('ventas.pdf');
Route::get('/fventas/crear','FacturaVentaController@create')->name('ventas.create');
Route::get('/ventas/edit/{id}','FacturaVentaController@edit')->name('ventas.edit');
Route::post('/ventas/store', 'FacturaVentaController@store')->name('ventas.store');
Route::get('/ventas/anular', 'FacturaVentaController@anular')->name('ventas.anular');


#insumos 
Route::get('/insumos', 'InsumosController@index')->name('insumos');
Route::get('/insumos/create', 'InsumosController@create')->name('insumos.create');
Route::get('/insumos/editar/{id}', 'InsumosController@edit')->name('insumos.edit');
Route::post('/insumos/update/{id}', 'InsumosController@update')->name('insumos.update');
Route::post('/insumos/store', 'InsumosController@store')->name('insumos.store');

#cajas 
Route::get('/resumen', 'CajaController@resumen')->name('caja.resumen');
Route::get('/flujo', 'CajaController@midetallecaja')->name('caja.midetallecaja');

Route::post('/guard/fluj', 'CajaController@guardflu')->name('caja.guardflu');
Route::match(['get','post'],'/excel/flujocaja/{id}','CajaController@excel_caja')->name('caja.excel_caja');
Route::match(['get','post'],'/excel/caja','CajaController@excel_caja2')->name('caja.excel_caja2');
Route::get('/factura/excel_nomina', 'FacturaIngresoController@excel_nomina')->name('factura_ingreso.excel_nomina');


Route::get('/pregunta', 'PreguntaController@index')->name('pregunta');
Route::get('/pregunta/create', 'PreguntaController@create')->name('pregunta.create');
Route::get('/pregunta/editar/{id}', 'PreguntaController@edit')->name('pregunta.edit');
Route::post('/pregunta/update/{id}', 'PreguntaController@update')->name('pregunta.update');
Route::post('/pregunta/store', 'PreguntaController@store')->name('pregunta.store');

Route::get('/test', 'TestController@index')->name('test');
Route::post('/test/store', 'TestController@store')->name('test.store');
Route::match(['get','post'],'/xestadisticos', 'TestController@index2')->name('estadisticos');

Route::get('/mytest', 'TestController@mytest')->name('my.test');
Route::get('/mytest/estadisticos/{id}', 'TestController@estadisticos')->name('mitest.estadisticos');
Route::get('/mytest/observar/{id}', 'TestController@observar')->name('mitest.observar');
