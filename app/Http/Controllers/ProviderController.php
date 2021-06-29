<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidDataException;
use App\Models\Provider;
use ErrorException;
use Exception;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\InvalidTag;

class ProviderController extends Controller
{
    public function index(Request $request)
    {

        $providers = Provider::query();

        if ($request->id) {
            $providers->where('id', $request->id);
        }

        if ($request->trading_name) {
            $providers->where('trading_name', 'like', $request->razao . '%');
        }

        if ($request->company_name) {
            $providers->where('company_name', 'like', $request->fantasia . '%');
        }

        if ($request->ein) {
            $providers->where('ein', 'like', $request->fantasia . '%');
        }

        return response()->json($providers->get());
    }

    public function get($id)
    {
        $provider = Provider::find($id);

        if (!$provider) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return response()->json($provider);
    }

    public function create(Request $request)
    {
        try {
            $user = auth()->user();
            $data = json_decode($request->getContent());

            $provider = new Provider();
            $provider->trading_name = trim($data->trading_name);
            $provider->company_name = trim($data->company_name);
            $provider->ein = $data->ein;
            $provider->state_registration = $data->state_registration;
            $provider->phone_number = $data->phone_number;
            $provider->email = $data->email;
            $provider->notes = $data->notes;
            $provider->provides_tef = $data->provides_tef;
            $provider->provides_software = $data->provides_software;
            $provider->created_by = $user->id;

            $this->providerDataValidador($provider);

            if ($provider->save()) {
                return response()->json($provider);
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
            $provider = Provider::find($id);
            if (!$provider) {
                return response()->json(['message' => 'Not Found'], 404);
            }
            $data = json_decode($request->getContent());

            $provider->trading_name = trim($data->trading_name);
            $provider->company_name = trim($data->company_name);
            $provider->ein = $data->ein;
            $provider->state_registration = $data->state_registration;
            $provider->phone_number = $data->phone_number;
            $provider->email = $data->email;
            $provider->notes = $data->notes;
            $provider->provides_tef = $data->provides_tef;
            $provider->provides_software = $data->provides_software;

            $this->ProviderDataValidador($provider);

            if ($provider->save()) {
                return response()->json($provider);
            }
        } catch (ErrorException $ex) {
            return response()->json(['message' => 'An Error Has Occurred', 'error' => $ex->getMessage()], 400);
        } catch (InvalidDataException $ex) {
            return response()->json(['message' => 'Invalid Data', 'error' => $ex->getMessage()], 400);
        }
    }

    public function delete($id)
    {
        $Provider = Provider::find($id);

        if (!$Provider) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $Provider->delete();

        return response()->json(['message' => 'Deleted']);
    }

    public function tef()
    {
        $Providers  = Provider::where('provides_tef', true);

        return response()->json($Providers->get());
    }

    public function software()
    {
        $providers  = Provider::where('provides_software', true);

        return response()->json($providers->get());
    }

    private function providerDataValidador(Provider $provider)
    {
        if (strlen($provider->trading_name) == 0) {
            throw new InvalidDataException("(razao social) Very small text");
        }

        if (strlen($provider->company_name) == 0) {
            throw new InvalidDataException("(fantasia) Very small text");
        }
    }
}
