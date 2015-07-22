<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Contracts\Mail\Mailer;

class SendEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $book;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($book, $user)
    {
        $this->book = $book;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $mailer->send('emails.BookAddNotification', ['book' => $this->book, 'user' => $this->user], function($m) {
            $m->to($this->user->email, $this->user->first_name.' '.$this->user->last_name)->subject('NEW BOOK');
        });
    }
}
