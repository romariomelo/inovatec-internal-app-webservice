<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidDataException;
use App\Models\Fornecedor;
use ErrorException;
use Exception;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\InvalidTag;

class FornecedorController extends Controller
{
    public function index(Request $request)
    {

        $fornecedores = Fornecedor::query();

        if ($request->id) {
            $fornecedores->where('id', $request->id);
        }

        if ($request->razao) {
            $fornecedores->where('razao', 'like', $request->razao . '%');
        }

        if ($request->fantasia) {
            $fornecedores->where('fantasia', 'like', $request->fantasia . '%');
        }

        if ($request->cnpj) {
            $fornecedores->where('cnpj', 'like', $request->fantasia . '%');
        }

        return response()->json($fornecedores->get());
    }

    public function get($id)
    {
        $fornecedor = Fornecedor::find($id);

        if (!$fornecedor) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return response()->json($fornecedor);
    }

    public function create(Request $request)
    {
        try {
            $data = json_decode($request->getContent());

            $fornecedor = new Fornecedor();
            $fornecedor->razao = trim($data->razao);
            $fornecedor->fantasia = $data->fantasia;
            $fornecedor->cnpj = $data->cnpj;
            $fornecedor->ie = $data->ie;
            $fornecedor->fornece_tef = $data->fornece_tef;
            $fornecedor->fornece_software = $data->fornece_software;

            $this->FornecedorDataValidador($fornecedor);

            if ($fornecedor->save()) {
                return response()->json($fornecedor);
            }
        } catch (ErrorException $ex) {
            return response()->json(['message' => 'An Error Has Occurred', 'error' => $ex->getMessage()], 400);
        } catch (InvalidDataException $ex) {
            return response()->json(['message' => 'Invalid Data', 'error' => $ex->getMessage()], 400);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $fornecedor = Fornecedor::find($id);
            if (!$fornecedor) {
                return response()->json(['message' => 'Not Found'], 404);
            }
            $data = json_decode($request->getContent());

            $fornecedor->razao = trim($data->razao);
            $fornecedor->fantasia = $data->fantasia;
            $fornecedor->cnpj = $data->cnpj;
            $fornecedor->ie = $data->ie;
            $fornecedor->fornece_tef = $data->fornece_tef;
            $fornecedor->fornece_software = $data->fornece_software;

            $this->FornecedorDataValidador($fornecedor);

            if ($fornecedor->save()) {
                return response()->json($fornecedor);
            }
        } catch (ErrorException $ex) {
            return response()->json(['message' => 'An Error Has Occurred', 'error' => $ex->getMessage()], 400);
        } catch (InvalidDataException $ex) {
            return response()->json(['message' => 'Invalid Data', 'error' => $ex->getMessage()], 400);
        }
    }

    public function delete($id)
    {
        $fornecedor = Fornecedor::find($id);

        if (!$fornecedor) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $fornecedor->delete();

        return response()->json(['message' => 'Deleted']);
    }

    private function FornecedorDataValidador(Fornecedor $fornecedor)
    {
        if (strlen($fornecedor->razao) == 0) {
            throw new InvalidDataException("(razao) Very small text");
        }

        if (strlen($fornecedor->fantasia) == 0) {
            throw new InvalidDataException("(fantasia) Very small text");
        }
    }
}
