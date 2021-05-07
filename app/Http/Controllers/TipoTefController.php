<?php

namespace App\Http\Controllers;

use App\Models\TipoTef;
use Illuminate\Http\Request;

class TipoTefController extends Controller
{
    public function index() {
        return response()->json(TipoTef::all());
    }

    public function get($id) {
        $tipo_tef = TipoTef::find($id);

        if (!$tipo_tef) {
            return response()->json(['message' => 'Type TEF not found'], 404);
        }

        return response()->json($tipo_tef);

    }

    public function create(Request $request) {
        $data = json_decode( $request->getContent() );
        $type_tef = new TipoTEF();
        $type_tef->descricao = $data->descricao;
        $type_tef->save();
        return response()->json($type_tef);
    }
}
