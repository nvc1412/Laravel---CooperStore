<?php

namespace App\Listeners;

use App\Events\CheckoutBill;
use App\Mail\VerifyBill;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailVerifyBill implements ShouldQueue
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
    public function handle(CheckoutBill $event): void
    {
        Mail::to($event->bill->customer->email)->send(new VerifyBill($event->bill, $event->token));
    }
}