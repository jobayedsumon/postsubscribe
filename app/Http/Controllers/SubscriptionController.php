<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'website_id' => 'required|exists:websites,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            try {
                $new_subscription = DB::table('subscriptions')->insert([
                    'user_id' => $request->user_id,
                    'website_id' => $request->website_id,
                ]);
                if ($new_subscription) {
                    return response()->json(['success' => 'Subscribed successfully'], 201);
                } else {
                    return response()->json(['error' => ' Failed subscribing'], 500);
                }
            } catch (\Exception $exception) {
                return response()->json(['error' => $exception->getMessage()], 400);
            }
        }


    }

}
