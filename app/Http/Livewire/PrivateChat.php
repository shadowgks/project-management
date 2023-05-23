<?php

namespace App\Http\Livewire;

use App\Events\MessageEvent;
use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Traits\AppTrait;
use Auth;
use Livewire\Component;

class PrivateChat extends Component
{
    use AppTrait;

    public $base_data = [
        'user_id' => null,
        'conversations' => [],
        'conversations_count' => 0,
        'messages' => [],
        'messages_count' => 0,
    ];

    public $values = [
        'search' => '',
        'content' => '',
        'current_conversation' => null,
        'current_conversation_id' => null,
    ];

    public function render()
    {
        return view('livewire.private-chat');
    }

    public function mount($id = null)
    {
        if ($id != null) {
            $conversation_id = ChatConversation::create_private_chat($id);

            if ($conversation_id != null)
                $this->getMessagesOfConversation($conversation_id);
        }

        $this->base_data['user_id'] = Auth::id();
        $this->base_data['conversations'] = ChatConversation::_get_conversations_by_type(ChatConversation::PRIVATE)->toArray();
        $this->base_data['conversations_count'] = count($this->base_data['conversations']);
    }

    public function getMessagesOfConversation($conversation_id)
    {
        $this->req(function () use ($conversation_id) {
            $this->values['current_conversation_id'] = $conversation_id;
            $this->values['current_conversation'] = ChatConversation::_get($conversation_id)->toArray();
            $this->base_data['messages'] = ChatMessage::_get_messages($conversation_id)->toArray();
            $this->base_data['messages_count'] = count($this->base_data['messages']);
            $this->dispatchBrowserEvent('setChatConversation', [
                'chat_conversation_id' => $conversation_id,
            ]);
        });
    }

    public function saveMessage()
    {
        $this->req(function () {
            if (empty($this->values['content'])) {
                return;
            }

            $message_data = [
                'type' => ChatMessage::TEXT,
                'content' => $this->values['content'],
                'chat_conversation_id' => $this->values['current_conversation_id'],
            ];

            ChatMessage::_save($message_data, $this->appOptions['id']);
            $this->values['content'] = '';
            event(new MessageEvent([
                'type' => ChatConversation::PRIVATE,
                'message' => $message_data,
                'chat_conversation_id' => $this->values['current_conversation_id'],
            ]));
        });
    }

    public function getDataAfterSave($conversation_id = null)
    {
        $this->base_data['conversations'] = ChatConversation::_get_conversations_by_type(ChatConversation::PRIVATE)->toArray();
        $this->base_data['conversations_count'] = count($this->base_data['conversations']);

        if (!empty($conversation_id)) {
            $this->base_data['messages'] = ChatMessage::_get_messages($conversation_id)->toArray();
            $this->base_data['messages_count'] = count($this->base_data['messages']);
        }
    }

    public function searchConversation()
    {
        // dd($this->values['search']);
    }
}
