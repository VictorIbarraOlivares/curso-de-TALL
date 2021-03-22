<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Subscriber;

class LandingPage extends Component
{
    public $email;

    public function render()
    {
        return view('livewire.landing-page');
    }

    public function subscribe()
    {
        $subscriber = Subscriber::create([
            'email' => $this->email
        ]);
        
        $this->reset('email');
    }
}
