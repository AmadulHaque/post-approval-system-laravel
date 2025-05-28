<?php

namespace App\Jobs;
use App\Models\Post;
use App\Notifications\PostApproved;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPostApprovedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $post;
    public function __construct($id) {
        $this->post = Post::findOrFail($id);
    }

    public function handle()
    {
        $this->post->user->notify(new PostApproved($this->post->id));
    }
}
