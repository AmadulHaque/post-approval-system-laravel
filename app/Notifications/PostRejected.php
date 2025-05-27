<?php

namespace App\Notifications;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PostRejected extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Post $post) {}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Post Has Been Rejected')
            ->line('Your post has been rejected. Please revise and resubmit.')
            ->action('Review Post', route('frontend.posts.show', $this->post->slug))
            ->line('Title: ' . $this->post->title);
    }
}
