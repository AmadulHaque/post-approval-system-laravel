<?php

namespace App\Notifications;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PostApproved extends Notification implements ShouldQueue
{
    use Queueable;

    public $post;
    public function __construct($id) {
        $this->post = Post::findOrFail($id);
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Post Has Been Approved')
            ->line('Your post has been approved and is now live.')
            ->action('Review Post', route('frontend.posts.show', $this->post->slug))
            ->line('Title: ' . $this->post->title);
    }
}
