<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ExportCompleted extends Notification
{
    use Queueable;

    protected $fileName;
    /**
     * Create a new notification instance.
     */
    public function __construct($fileName)
    {
        //
        $this->fileName = $fileName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        //{{ url('/download-export/' . $fileName) }}
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Download your file', url('/download-export/' . $this->fileName))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public function build()
    {
        return $this->subject('Your Export is Ready')
                    ->view('exports')
                    ->with(['fileName' => $this->fileName]);
    }
}
