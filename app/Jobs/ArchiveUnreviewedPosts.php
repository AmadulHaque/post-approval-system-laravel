<?php

namespace App\Jobs;

use App\Enum\PostStatus;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ArchiveUnreviewedPosts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        Post::where('status', PostStatus::DRAFT->value)
            ->where('created_at', '<=', Carbon::now()->subDays(3))
            ->update(['status' => PostStatus::ARCHIVED->value]);
    }
}
