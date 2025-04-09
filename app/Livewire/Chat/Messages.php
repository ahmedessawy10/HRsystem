<?php

namespace App\Livewire\Chat;

use App\Events\MessageChatSend;
use App\Models\Chat;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;


class Messages extends Component
{
    public $messages = [];
    public $user;
    public $message;
    public $viewchat;
    public $isLoading = false;

    protected $rules = [
        'message' => 'required|min:2',
    ];

    protected function messages()
    {
        return [
            'message.required' => __('project.message_required'),
            'message.min' => __('project.message_min_length'),
        ];
    }

    protected $listeners = ["openChat" => "getMessage"];

    protected function getListeners()
    {
        return [
            "openChat" => "getMessage",
            "echo-private:chat." . Auth::id() . ",MessageChatSend" => 'broadcastedMessageReceived'
        ];
    }

    public function mount()
    {
        $this->viewchat = false;

        if (session()->has('active_chat')) {
            $receiverId = session()->get('active_chat');
            $this->getMessage($receiverId);
        }
    }
    public function render()
    {
        return view('livewire.chat.messages', [
            "messages" => $this->messages
        ]);
    }
    #on["openChat"]
    public function getMessage($receiverId)
    {
        try {
            $this->isLoading = true;
            $this->user = User::find($receiverId);
            $this->loadMessages($receiverId); // Move after user check
            $this->viewchat = true;
        } finally {
            $this->isLoading = false;
        }
    }

    public function sendMessage()
    {
        try {
            $this->isLoading = true;
            // $this->validate();   

            if (!$this->user) {
                throw new \Exception('No recipient selected');
            }

            $mess = Chat::create([
                'sender_id'   => Auth::id(),
                'receiver_id' => $this->user->id,
                'message'     => $this->message,
            ]);

            $this->reset('message');
            $this->loadMessages($this->user->id);
            broadcast(new MessageChatSend($mess))->toOthers();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to send message: ' . $e->getMessage());
        } finally {
            $this->isLoading = false;
        }
    }

    public function broadcastedMessageReceived($event)
    {
        $message = $event['message'] ?? [];
        $senderId = $message['sender_id'] ?? null;
        $receiverId = $message['receiver_id'] ?? null;

        if ($this->user && ($senderId == $this->user->id || $receiverId == $this->user->id)) {
            $this->loadMessages($this->user->id);
        }
    }

    public $perPage = 50;

    public function loadMessages($receiverId = null)
    {
        if ($receiverId) {
            $this->user = User::find($receiverId);
        }

        if ($this->user) {
            // Mark messages as read
            Chat::where('sender_id', $this->user->id)
                ->where('receiver_id', Auth::id())
                ->where('is_read', false)
                ->update(['is_read' => true]);

            // Load messages
            $messages = Chat::where(function ($query) use ($receiverId) {
                $query->where('sender_id', Auth::id())
                    ->where('receiver_id', $receiverId);
            })
                ->orWhere(function ($query) use ($receiverId) {
                    $query->where('sender_id', $receiverId)
                        ->where('receiver_id', Auth::id());
                })
                ->orderBy('created_at', 'asc')
                ->get();

            // Group messages by date without using morphing
            $this->messages = $messages->groupBy(function ($message) {
                return $message->created_at->format('Y-m-d');
            })->toArray();
        }
    }
    public function closeChat()
    {
        $this->viewchat = false;
        $this->user = null;
        $this->messages = [];
        $this->message = '';
        session()->forget('active_chat');
    }
}