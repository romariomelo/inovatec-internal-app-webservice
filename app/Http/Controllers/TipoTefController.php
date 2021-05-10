<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidDataException;
use App\Models\TipoTef;
use Illuminate\Http\Request;

class TipoTefController extends Controller
{
    public function index()
    {
        return response()->json(TipoTef::all());
    }

    public function get($id)
    {
        $tipo_tef = TipoTef::find($id);

        if (!$tipo_tef) {
            return response()->json(['message' => 'Type TEF not found'], 404);
        }

        return response()->json($tipo_tef);
    }

    public function create(Request $request)
    {
        $data = json_decode($request->getContent());
        $type_tef = new TipoTEF();
        $type_tef->descricao = $data->descricao;
        $type_tef->save();
        return response()->json($type_tef);
    }

    public function update($id, Request $request)
    {

        try {

            $data = json_decode($request->getContent());

            $tipo_tef = TipoTef::find($id);

            if (!$tipo_tef) {
                return response()->json(['message' => 'Not Found'], 404);
            }

            $tipo_tef->descricao = trim($data->descricao);

            $this->tefTypeDataValidator($tipo_tef);

            if ($tipo_tef->save()) {
                return response()->json($tipo_tef);
            }
        } catch (InvalidDataException $ex) {
            return response()->json(['message' => 'Invalid Data', 'error' => $ex->getMessage()], 400);
        }
    }

    public function delete($id)
    {
        $tipo_tef = TipoTef::find($id);

        if (!$tipo_tef) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        if ($tipo_tef->delete()) {
            return response()->json(['message' => 'Deleted'], 202);
        }
    }

    private function tefTypeDataValidator(TipoTEF $tipo_tef)
    {
        if (strlen($tipo_tef->descricao) == 0) {
            throw new InvalidDataException('Very short description');
        }
    }
}
