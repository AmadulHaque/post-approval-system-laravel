<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\User;
use App\Notifications\PostRejected;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPostRejectedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Post $post) {}

    public function handle()
    {
        $admin = User::where('role',1)->first();
        $admin->notify(new PostRejected($this->post));
    }
}
