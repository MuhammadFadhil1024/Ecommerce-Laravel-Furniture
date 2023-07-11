<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        try {

            $users = DB::table('users')->whereNotIn('id', [Auth::user()->id])->paginate(20);

            $response = [
                'message' => 'success',
                'data' => $users
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request, int $id)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|string|unique:users,email,' . $id,
                'roles' => 'required|string|in:ADMIN,USER'
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'failed update user', 'error' => $validator->errors()], 422);
            }

            $user = User::find($id);

            if ($user) {

                $user->name = $request->name;
                $user->email = $request->email;
                $user->roles = $request->roles;

                $user->save();

                return response()->json([
                    'message' => 'success',
                    'data' => $user
                ], 200);
            } else {
                return response()->json([
                    'message' => 'user not found'
                ], 404);
            }
        } catch (\Exception $e) {

            Log::error($e);
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete(int $id)
    {
        try {

            if ($id == Auth::user()->id) {
                return response()->json([
                    'message' => 'You cannot delete your own account'
                ], 422);
            }

            $user = User::find($id);

            if ($user) {
                $user->delete();

                return response()->json(['message' => 'success'], 200);
            } else {
                return response()->json(['message' => 'user not found'], 404);
            }
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
