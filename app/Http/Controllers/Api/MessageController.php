<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Events\SendMessage;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Event;

class MessageController extends Controller
{
    public function listMessages(User $user){
        $userFrom = \Auth::user()->id;
        $userTo = $user->id;

        $messages = Message::where(
            function($query) use ($userFrom, $userTo){
                $query->where([
                    'from' => $userFrom,
                    'to' => $userTo
                ]);
            }
        )->orWhere(
            function($query) use ($userFrom, $userTo){
                $query->where([
                    'from' => $userTo,
                    'to' => $userFrom
                ]);
            }
        )->orderBy('created_at', 'ASC')->get();

        return response()->json([
            'messages' => $messages
        ], Response::HTTP_OK);
    }

    public function store(Request $request){
        $message = Message::create([
            'from' => \Auth::user()->id,
            'to' => $request->to,
            'content' => filter_var($request->content, FILTER_SANITIZE_STRIPPED)
        ]);

        if($message){
            // event(new SendMessage($message, $request->to));
            SendMessage::dispatch($message, $request->to);
            return response()->json([
                'success' => true
            ], Response::HTTP_CREATED);
        }
        return response()->json([
            'success' => false
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
