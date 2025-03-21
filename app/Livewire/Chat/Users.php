<?php

namespace App\Livewire\Chat;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Users extends Component
{
    public $search;


    public function render()
    {
        // $users = User::with("chats")->whereNot("id", auth()->id)->orderBy(function ($q) {
        //     return $q->chats->latest();
        // })->when($this->search, function ($q) {
        //     return   $q->where("name", "like", "%" . $this->search . "%");
        // });
        // dd($users);
        $users = User::with(['chats' => function ($query) {
            $query->latest();
        }])
            ->whereNot("users.id", auth()->id())  
            
            ->leftJoin('chats', function ($join) {
                $join->on('users.id', '=', 'chats.user_id')
                    ->whereIn('chats.id', function ($query) {
                        $query->select(DB::raw('MAX(id)'))
                            ->from('chats')
                            ->groupBy('user_id');
                    });
                })
            ->orderBy('chats.created_at', 'desc')
            ->when($this->search, function ($q) {
                return $q->where("users.name", "like", "%" . $this->search . "%");
            })
            ->select('users.*')
            ->get();
        dd($users);
        return view('livewire.chat.users');
    }
}
