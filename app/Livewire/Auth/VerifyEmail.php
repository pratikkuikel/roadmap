<?php

namespace App\Livewire\Auth;

use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Livewire\Component;
use Mary\Traits\Toast;

class VerifyEmail extends Component
{
    use Toast;
    use WithRateLimiting;

    public function resendVerification()
    {
        try {
            $this->rateLimit(3);
        } catch (TooManyRequestsException $exception) {
            $this->error("Slow down! Please wait another {$exception->secondsUntilAvailable} seconds to send verification mail.");
        }

        auth()->user()->sendEmailVerificationNotification();

        $this->success('Verification Link sent, Please check your Mail');
    }

    public function render()
    {
        return view('livewire.auth.verify-email');
    }
}
