<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidDataException;
use App\Models\User;
use Illuminate\Http\Request;
use ErrorException;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function create(Request $request)
    {

        try {

            $data = json_decode($request->getContent());

            $user = new User();
            $user->name = trim($data->name);
            $user->email = trim($data->email);
            $user->password = $data->password;

            $this->userDataValidator($user);

            $user->password = bcrypt($user->password);

            $user->save();

            return response()->json($user);
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error recording data', 'error' => $ex->getMessage()], 400);
        } catch (ErrorException $ex) {
            return response()->json(['message' => 'An Error Has Occurred', 'error' => $ex->getMessage()], 400);
        } catch (InvalidDataException $ex) {
            return response()->json(['message' => 'Invalid Data', 'error' => $ex->getMessage()], 400);
        }
    }

    public function update($id, Request $request)
    {
        try {

            $data = json_decode($request->getContent());

            $user = User::find($id);

            if (!$user) {
                return response()->json(['message' => 'Not Found'], 404);
            }

            $user->name = trim($data->name);
            $user->email = trim($data->email);

            $this->userDataValidator($user);

            $user->save();

            return response()->json($user);
        } catch (QueryException $ex) {
            return response()->json(['message' => 'Error recording data', 'error' => $ex->getMessage()], 400);
        } catch (ErrorException $ex) {
            return response()->json(['message' => 'An Error Has Occurred', 'error' => $ex->getMessage()], 400);
        } catch (InvalidDataException $ex) {
            return response()->json(['message' => 'Invalid Data', 'error' => $ex->getMessage()], 400);
        }
    }

    public function delete($id)
    {

        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json(['message' => 'Not Found'], 404);
            }

            $user->delete();

            return response()->json(['message' => 'Deleted']);
        } catch (Exception $ex) {
            return response()->json(['message' => 'An Error Has Occurred', 'error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Change user's password.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function change_passsword(Request $request)
    {
        try {
            $password = $request->password;
            $user = User::find(auth()->user()->id);
            //return response()->json(['auth' => auth()->user()]);
            //die;
            if (!$user) {
                return response()->json(['message' => 'Not Found'], 404);
            }
            $user->password = bcrypt($password);
            $user->save();
            return response()->json(['message' => 'Password changed successfully']);
        } catch (Exception $ex) {
            return response()->json(['message' => 'An Error Has Occurred', 'error' => $ex->getMessage()], 500);
        }
    }

    private function userDataValidator(User $user)
    {
        if (strlen($user->name) < 3) {
            throw new InvalidDataException('(nome) Very small name.');
        }
        if (!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidDataException('(email) E-mail is not valid.');
        }
        if (strlen($user->password) == 0) {
            throw new InvalidDataException('(password) Very small password.');
        }
    }
}
