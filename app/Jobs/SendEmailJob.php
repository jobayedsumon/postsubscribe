<?php

namespace App\Jobs;

use App\Mail\SendNewPost;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $post;
    private $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($post, $email)
    {
        //
        $this->post = $post;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $post_email= new SendNewPost($this->post);
        Mail::to($this->email)->send($post_email);

    }
}
