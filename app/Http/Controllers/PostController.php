<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'website_id' => 'required',
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        } else {
            try {
                $new_post = DB::table('posts')->insertGetId([
                    'website_id' => $request->website_id,
                    'title' => $request->title,
                    'description' => $request->description,
                ]);

                if ($new_post) {
                    $subscribers = DB::table('users')
                        ->join('subscriptions', 'users.id', '=', 'subscriptions.user_id')
                        ->select('users.email')
                        ->where('subscriptions.website_id', $request->website_id)
                        ->get();
                    $post = DB::table('posts')->where('id', $new_post)->first();
                    foreach ($subscribers as $subscriber) {
                        $this->dispatch(new SendEmailJob($post, $subscriber->email));
                    }

                    return response()->json(['success' => 'Post created successfully'], 201);
                } else {
                    return response()->json(['error' => ' Failed creating post'], 500);
                }
            } catch (\Exception $exception) {
                return response()->json(['error' => $exception->getMessage()], 400);
            }
        }


    }

}
