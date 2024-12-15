<?php

namespace App\Listeners;

use App\Events\RegisterAccount;
use App\Mail\VerifyAccount;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailVerifyAccount implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RegisterAccount $event): void
    {
        Mail::to($event->account->email)->send(new VerifyAccount($event->account));
    }
}