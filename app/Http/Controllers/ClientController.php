<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request) {
        $clients = Client::query();

        if ($request->id) {
            $clients->where('id', $request->id);
        }

        return response()->json($clients->get());
    }

    public function get($id) {
        $client = Client::find($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        return response()->json($client);
    }

    public function create(Request $request) {
        $data = json_decode($request->getContent());
        $client = new Client();
        $client->razao = $data->razao;
        $client->fantasia = $data->fantasia;
        $client->cnpj = $data->cnpj;
        $client->ie = $data->ie;
        $client->save();
        return response()->json($client, 201);
    }

    public function update($id, Request $request) {
        $data = json_decode($request->getContent());

        $client = Client::find($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }
        $client->razao = $data->razao;
        $client->fantasia = $data->fantasia;
        $client->cnpj = $data->cnpj;
        $client->ie = $data->ie;
        $client->save();
        return response()->json($client, 202);
    }

    public function delete($id, Request $request) {

        $client = Client::find($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }

        if ($client->delete()) {
            return response()->json(['message' => 'Deleted'], 202);
        }
    }
}
