<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Subscriber;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\DB;

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

        DB::transaction(function () {
            $subscriber = Subscriber::create([
                'email' => $this->email
            ]);
    
            $notification = new VerifyEmail;
    
            $subscriber->notify($notification);
            
        }, $deadLockRetries = 5);
        
        $this->reset('email');
    }
}
