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

        if ($request->trading_name) {
            $clients->where('trading_name', 'like', $request->trading_name . '%');
        }

        if ($request->company_name) {
            $clients->where('company_name', 'like', $request->company_name . '%');
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
        $client->trading_name = $data->trading_name;
        $client->company_name = $data->company_name;
        $client->ein = $data->ein;
        $client->state_registration = $data->state_registration;
        $client->email = $data->email;
        $client->phone_number = $data->phone_number;
        $client->notes = $data->notes;
        $client->save();
        return response()->json($client, 201);
    }

    public function update($id, Request $request) {
        $data = json_decode($request->getContent());

        $client = Client::find($id);

        if (!$client) {
            return response()->json(['message' => 'Client not found'], 404);
        }
        $client->trading_name = $data->trading_name;
        $client->company_name = $data->company_name;
        $client->ein = $data->ein;
        $client->state_registration = $data->state_registration;
        $client->phone_number = $data->phone_number;
        $client->email = $data->email;
        $client->notes = $data->notes;
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
