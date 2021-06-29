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
    try {
        // TESTA CONEXÃO COM O BANCO DE DADOS
        DB::connection()->getPdo();
        return response()->json(['message' => 'Conexão realizada com sucesso.']);
    } catch (Exception $ex) {
        return response()->json(['message' => $ex->getMessage()]);
    }
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

    echo Artisan::call('migrate');

    $u = new User();
    $u->email = 'romario@inovatecstore.com.br';
    $u->name = 'Romario';
    $u->password = bcrypt('123');
    $u->save();
});
