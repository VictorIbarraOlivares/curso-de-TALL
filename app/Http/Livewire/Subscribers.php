<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Subscriber;

class Subscribers extends Component
{
    public function render()
    {
        $subscribers = Subscriber::all();
        return view('livewire.subscribers')->with([
            'subscribers' => $subscribers,
        ]);
    }

    public function delete(Subscriber $subscriber)
    {
        $subscriber->delete();
    }
}
