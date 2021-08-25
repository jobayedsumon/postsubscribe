<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            try {
                $new_user = DB::table('users')->insert([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                if ($new_user) {
                    return response()->json(['success' => 'User created successfully'], 201);
                } else {
                    return response()->json(['error' => ' Failed creating user'], 500);
                }
            } catch (\Exception $exception) {
                return response()->json(['error' => $exception->getMessage()], 400);
            }
        }

    }
}
