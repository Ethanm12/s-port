<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Http\Requests\ContactRequest;

class InboxMessage extends Notification
{
    use Queueable;


    protected $enquiry;

    /**
     * InboxMessage constructor.
     * @param ContactRequest $enquiry
     */
    public function __construct(contactRequest $enquiry)
    {
        $this->enquiry = $enquiry;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(config('admin.name') . ", you have a new enquiry from the website!")
            ->greeting(" ")
            ->salutation(" ")
            ->from(config('admin.noreply'), config('admin.name'))
            ->replyTo($this->enquiry->email, $this->enquiry->name)
            ->line('From: ' . $this->enquiry->name)
            ->line('Company: ' . $this->enquiry->company)
            ->line('Phone: ' . $this->enquiry->phone)
            ->line('Email: ' . $this->enquiry->email)
            ->line('Enquiry: ' . $this->enquiry->enquiry);

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
