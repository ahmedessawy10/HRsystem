<?php

namespace App\Livewire\Chat;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Users extends Component
{
    public $search = "";
    public $activeUser;
    public $isLoading = false;

    public function render()
    {
        $users = User::with("chats")
            ->whereNot("id", auth()->id())
            ->when($this->search, function ($q) {
                return $q->where("name", "like", "%" . $this->search . "%");
            })
            ->get();

        return view('livewire.chat.users', compact("users"));
    }

    public function mount()
    {
        if (session()->has('active_chat')) {
            $this->activeUser = session()->get('active_chat');
            $this->dispatch('openChat', $this->activeUser);
        }
    }

    public function openChat($receiver_id)
    {
        $this->isLoading = true;
        $this->activeUser = $receiver_id;
        session()->put('active_chat', $receiver_id);
        $this->dispatch('openChat', $receiver_id);
        $this->isLoading = false;
    }
}