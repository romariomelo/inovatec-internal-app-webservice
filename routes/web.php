<?php

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
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
    dd(User::all());
    return view('welcome');
});

Route::get('/clear', function() {
    echo 'Clear views<br />';
    Artisan::call('view:clear');
    echo 'Clear configurations<br />';
    Artisan::call('config:clear');
    echo 'Clear routes<br />';
    Artisan::call('route:clear');
});

Route::get('/reset-database', function() {
    $tables = DB::select('SHOW TABLES');
    foreach($tables as $table) {
        $table_name = $table->Tables_in_inovatec;
        echo "Excluindo $table_name<br />";
        DB::statement("DROP TABLE if EXISTS $table_name");
    }
});

Route::get('/teste', function () {
    return 'teste';
});
