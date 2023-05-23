<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatConversation extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'users' => 'collection',
    ];

    const PRIVATE = 1;
    const GROUP = 2;

    public static function _get($id = null)
    {
        if ($id == null) {
            $conversations = self::with('created_by')->get();

            foreach ($conversations as $key => $conversation) {
                if ($conversation->type == 1) {
                    $conversations[$key]->to_user = self::getUsersOfConversation($conversation);
                } else {
                    $conversations[$key]->to_users = self::getUsersOfConversation($conversation);
                }
            }

            return $conversations;
        } else {
            $conversation = self::where('id', $id)->with('created_by')->first();

            if ($conversation->type == 1) {
                $conversation->to_user = self::getUsersOfConversation($conversation);
            } else {
                $conversation->to_users = self::getUsersOfConversation($conversation);
            }

            return $conversation;
        }
    }

    public static function _get_conversations_by_type($type)
    {
        $conversations = self::where('type', $type)->where('user_id', Auth::id())->orWhereJsonContains('users', Auth::id())->with(['messages' => function ($query) {
            return $query->latest('id')->first();
        }, 'created_by'])->orderByDesc('id')->get();
        // ->sortBy(function ($conversation) {
        //     $count_message = count($conversation->messages);
        //     return ($count_message > 0 ? $conversation->messages[$count_message - 1]->id : 0);
        // });

        foreach ($conversations as $key => $conversation) {
            if ($type == 1) {
                $conversations[$key]->to_user = self::getUsersOfConversation($conversation);
            } else {
                $conversations[$key]->to_users = self::getUsersOfConversation($conversation);
            }
        }

        return $conversations;
    }

    private static function getUsersOfConversation($conversation)
    {
        if ($conversation->type == 1) {
            return User::where('id', $conversation->users[0])->first();
        } else {
            return User::whereIn('id', $conversation->users)->get();
        }
    }

    public static function getToUserName($conversation)
    {
        $to_user_name = '';

        if ($conversation != null) {
            if (Auth::id() == $conversation['to_user']['id']) {
                $to_user_name = $conversation['created_by']['first_name'] . ' ' . $conversation['created_by']['last_name'];
            } else {
                $to_user_name = $conversation['to_user']['first_name'] . ' ' . $conversation['to_user']['last_name'];
            }
        }

        return $to_user_name;
    }

    public static function _create($data)
    {
        $conversation = new self;
        $conversation->fill($data);
        $conversation->user_id = Auth::id();
        $conversation->save();

        return $conversation->id;
    }

    public static function _delete($id)
    {
        self::where('id', $id)->delete();
    }

    public static function create_private_chat($to_user_id)
    {
        if (!User::checkUserExists($to_user_id)) return null;

        $conversation = self::check_conversation_exists($to_user_id);
        if ($conversation != null) return $conversation['id'];

        return self::_create([
            'type' => self::PRIVATE,
            'users' => [(int) $to_user_id],
        ]);
    }

    private static function check_conversation_exists($to_user_id)
    {
        $conversations = self::all()->toArray();

        foreach ($conversations as $conversation) {
            if ($conversation['type'] == self::PRIVATE && in_array($to_user_id, $conversation['users'])) {
                return $conversation;
            }
        }

        return null;
    }

    /**
     * Get all of the messages for the ChatConversation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    /**
     * Get all of the created_by for the ChatConversation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function created_by()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
