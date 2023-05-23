<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'to_user_id' => 'collection',
    ];

    const TEXT = 1;
    const FILE = 2;

    public static function _get($id = null)
    {
        if ($id == null) {
            return self::with('created_by')->get();
        } else {
            return self::where('id', $id)->with('created_by')->first();
        }
    }

    public static function _get_messages($chat_conversation = null, $reverse = false)
    {
        if ($chat_conversation == null)
            return ($reverse ? self::with('created_by')->orderByDesc('id')->limit(30)->get()->reverse() : self::with('created_by')->orderByDesc('id')->limit(30)->get());
        else
            return ($reverse ? self::where('chat_conversation_id', $chat_conversation)->with('created_by')->orderByDesc('id')->limit(30)->get()->reverse() : self::where('chat_conversation_id', $chat_conversation)->with('created_by')->orderByDesc('id')->limit(30)->get());
    }

    public static function _get_last_message($chat_conversation)
    {
        return self::where('chat_conversation_id', $chat_conversation)->with('created_by')->orderByDesc('id')->first();
    }

    public static function _save($data, $id = null)
    {
        if ($id == null) {
            $message = new self;
        } else {
            $message = self::find($id);
        }

        $message->fill($data);
        $message->user_id = Auth::id();
        $message->save();
    }

    public static function _delete($id)
    {
        self::where('id', $id)->delete();
    }

    /**
     * Get the created_by associated with the Message
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function to_user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Get the created_by associated with the Message
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function created_by()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
