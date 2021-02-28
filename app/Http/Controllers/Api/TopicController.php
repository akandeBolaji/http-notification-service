<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Subscription;
use App\Models\Topic;

class TopicController extends Controller
{
    public function subscribe(Request $request, $topic)
    {
        $request->merge(['topic' => $topic]);
        $validator = Validator::make($request->all(), [
            'url' => 'required|url',
            'topic' => 'required|exists:topics,value'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return response()->json([
                'error' => 'invalid_input',
                'message' => $error,
            ], 400);
        }

        $topic = Topic::where('value', $request->topic)->first();

        $subscription = Subscription::where('url', $request->url)
                                    ->where('topic_id', $topic->id)
                                    ->first();

        if ($subscription) {
            return response()->json([
                'error' => 'duplicate_subscription',
                'message' => 'Subscription already exists',
            ], 400);
        }

        Subscription::create([
            'url' => $request->url,
            'topic_id' => $topic->id
        ]);

        return response()->json([
            'url' => $request->url,
            'topic' => $request->topic,
        ], 200);
    }
}
