<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Subscriber;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Notifications\VerifyEmail;

class LandingPage extends Component
{
    public $email;
    public $showSubscribe = false;
    public $showSuccess = false;

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
            $notification::createUrlUsing(function($notifiable) {
                return URL::temporarySignedRoute(
                    'subscribers.verify',
                    now()->addMinutes(30),
                    [
                        'subscriber' => $notifiable->getKey(),
                        'hash' => sha1($notifiable->getEmailForVerification()),
                    ]
                );

            });

            $subscriber->notify($notification);
            
        }, $deadLockRetries = 5);
        
        $this->reset('email');
        $this->showSubscribe = false;
        $this->showSuccess = true;
    }
}
