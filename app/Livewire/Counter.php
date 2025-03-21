<?php

namespace App\Livewire;

use Livewire\Component;


class Counter extends Component
{

    public $data = [];
    public $user = "";
    public $count = 0;
    function add()
    {
        $this->count++;
    }
    function sub()
    {
        $this->count--;
    }

    public  $name = "ahmed";

    public function render()
    {
        return view('livewire.counter');
    }

    function  addData()
    {
        array_push($this->data, $this->user);
    }
}
