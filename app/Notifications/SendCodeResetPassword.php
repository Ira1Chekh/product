<?php

namespace App\Notifications;

use App\Models\PasswordReset;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendCodeResetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    public PasswordReset $code;

    public function __construct(PasswordReset $code)
    {
        $this->code = $code;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Reset Password Notification')
            ->line('You are receiving this email because we received a password reset request for your account')
            ->action('Reset Password', route('password.reset', [
                'token' => $this->code->token,
                'email' => $this->code->email,
            ], false))
            ->line('This password reset link will expire in 60 minutes.')
            ->line('If you did not request a password reset, no further action is required.');
    }

}
