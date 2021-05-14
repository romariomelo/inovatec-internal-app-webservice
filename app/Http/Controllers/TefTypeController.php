<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidDataException;
use App\Models\TefType;
use Illuminate\Http\Request;

class TefTypeController extends Controller
{
    public function index()
    {
        return response()->json(TefType::all());
    }

    public function get($id)
    {
        $tipo_tef = TefType::find($id);

        if (!$tipo_tef) {
            return response()->json(['message' => 'Type TEF not found'], 404);
        }

        return response()->json($tipo_tef);
    }

    public function create(Request $request)
    {
        $data = json_decode($request->getContent());
        $tef_type = new TefType();
        $tef_type->description = $data->description;
        $tef_type->save();
        return response()->json($tef_type);
    }

    public function update($id, Request $request)
    {

        try {

            $data = json_decode($request->getContent());

            $tef_type = TefType::find($id);

            if (!$tef_type) {
                return response()->json(['message' => 'Not Found'], 404);
            }

            $tef_type->description = trim($data->description);

            $this->tefTypeDataValidator($tef_type);

            if ($tef_type->save()) {
                return response()->json($tef_type);
            }
        } catch (InvalidDataException $ex) {
            return response()->json(['message' => 'Invalid Data', 'error' => $ex->getMessage()], 400);
        }
    }

    public function delete($id)
    {
        $tipo_tef = TefType::find($id);

        if (!$tipo_tef) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        if ($tipo_tef->delete()) {
            return response()->json(['message' => 'Deleted'], 202);
        }
    }

    private function tefTypeDataValidator(TefType $tipo_tef)
    {
        if (strlen($tipo_tef->description) == 0) {
            throw new InvalidDataException('Very short description');
        }
    }
}
