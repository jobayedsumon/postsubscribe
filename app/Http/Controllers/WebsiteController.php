<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WebsiteController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|unique:websites',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            try {
                $new_website = DB::table('websites')->insert([
                    'url' => $request->url,
                    'title' => $request->title,
                    'description' => $request->description
                ]);
                if ($new_website) {
                    return response()->json(['success' => 'Website created successfully'], 201);
                } else {
                    return response()->json(['error' => ' Failed creating website'], 500);
                }
            } catch (\Exception $exception) {
                return response()->json(['error' => $exception->getMessage()], 400);
            }
        }

    }
}
