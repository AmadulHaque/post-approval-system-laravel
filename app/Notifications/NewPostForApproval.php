<?php

namespace App\Notifications;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewPostForApproval extends Notification implements ShouldQueue
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
            ->subject('New Post Awaiting Approval')
            ->line('A new post has been submitted for approval.')
            ->action('Review Post', route('posts.edit', $this->post->id))
            ->line('Title: ' . $this->post->title);
    }
}
