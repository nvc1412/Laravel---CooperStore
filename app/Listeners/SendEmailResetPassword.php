<?php

namespace App\Listeners;

use App\Events\ForgotedPassword;
use App\Mail\ForgotPassword;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailResetPassword implements ShouldQueue
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
    public function handle(ForgotedPassword $event): void
    {
        Mail::to($event->customer->email)->send(new ForgotPassword($event->customer, $event->token));
    }
}