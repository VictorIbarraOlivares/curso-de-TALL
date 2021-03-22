<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Subscriber;

class LandingPage extends Component
{
    public $email;

    protected $rules = [
        'email' => 'required|unique:subscribers,email|email:filter',
    ];

    public function render()
    {
        return view('livewire.landing-page');
    }

    public function subscribe()
    {
        $this->validate();
        
        $subscriber = Subscriber::create([
            'email' => $this->email
        ]);
        
        $this->reset('email');
    }
}
