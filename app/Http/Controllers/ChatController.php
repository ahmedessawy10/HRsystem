<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Chat;
use App\Events\UserTyping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Laravel\Reverb\Events\MessageSent;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return  view("chat");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        //
    }



    public function ai_chat(Request $request)
    {
        try {
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . env('CHAT_GPT_KEY'),

                // "HTTP-Referer": "<YOUR_SITE_URL>", 
                // "X-Title": "<YOUR_SITE_NAME>", 
                "Content-Type" => "application/json"

            ])->post('https://openrouter.ai/api/v1/chat/completions', [
                "model" => "deepseek/deepseek-chat:free",
                "messages" => [
                    [
                        "role" => "user",
                        "content" => "how make pizza",
                        "limit" => 30
                    ]
                ],
                "temperature" => 0,
                "max_tokens" => 2048
            ]);

            return $response->json()['choices'][0]['message']['content'];
        } catch (Throwable $e) {
            return "Chat GPT Limit Reached. This means too many people have used this demo this month and hit the FREE limit available. You will need to wait, sorry about that.";
        }
    }


    public function sendMessage(Request $request, $receiverId)
    {
        // save message to DB
        $message = Chat::create([
            'sender_id'     => Auth::id(),
            'receiver_id'   => $receiverId,
            'message'       => $request['message']
        ]);

        // Fire the message event
        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['status' => 'Message sent!']);
    }

    public function typing()
    {
        // Fire the typing event
        broadcast(new UserTyping(Auth::id()))->toOthers();
        return response()->json(['status' => 'typing broadcasted!']);
    }

    public function setOnline()
    {
        Cache::put('user-is-online-' . Auth::id(), true, now()->addMinutes(5));
        return response()->json(['status' => 'Online']);
    }

    public function setOffline()
    {
        Cache::forget('user-is-online-' . Auth::id());
        return response()->json(['status' => 'Offline']);
    }
}
