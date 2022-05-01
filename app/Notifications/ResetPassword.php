<?php

namespace App\Notifications;

use App\Models\BounceEmail;
use App\Repositories\BounceEmailRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    private $token;
    private $expired;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $token, string $expired)
    {
        $this->token = $token;
        $this->expired =$expired;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $subject = '【アイナビトラック】パスワードの再設定をお願いします。';
        $url = route('password.reset', ['token' => $this->token, 'email' => $notifiable->email]);

        return (new MailMessage)
            ->subject($subject)
            ->view('emails.common.password_reset', [
                'url' => $url,
                'expired' => $this->expired
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
