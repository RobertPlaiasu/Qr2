<?php

namespace App\Listeners;

use App\Events\SendInvitation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\InvitationMail;
use Illuminate\Support\Facades\Mail;

class SendInvitationMail implements ShouldQueue
{

    /**
     * Handle the event.
     *
     * @param  SendInvitation  $event
     * @return void
     */
    public function handle(SendInvitation $event)
    {
        Mail::to($event->invitation->email)->send(new InvitationMail($event->invitation));
    }
}
