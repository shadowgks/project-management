<?php

namespace App\Http\Controllers;

use App\Events\MessageEvent;
use App\Models\ChatMessage;
use Auth;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function getMessages()
    {
        return ChatMessage::_get();
    }

    public function getMessagesView()
    {
        try {
            return [
                'success' => true,
                'content' => view('layouts.renders.chat')->with([
                    'user_id' => Auth::id(),
                    'messages' => ChatMessage::_get_messages(),
                ])->render(),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => getErrorMessage($e),
            ];
        }
    }

    public function saveMessage(Request $request)
    {
        try {
            if (isset($request->id))
                ChatMessage::_save($request->message, $request->id);
            else
                ChatMessage::_save($request->message);

            event(new MessageEvent());
            return [
                'success' => true,
                'message' => __('Message saved successfully'),
                'content' => view('layouts.renders.chat')->with([
                    'user_id' => Auth::id(),
                    'messages' => ChatMessage::_get_messages(),
                ])->render(),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => getErrorMessage($e),
            ];
        }
    }
}
