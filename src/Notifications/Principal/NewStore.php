<?php

namespace Sada\SadataComponent\Notifications\Principal;

use Sada\SadataComponent\Models\Main\Roles;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewStore extends Notification
{
    use Queueable;

    private $store, $param;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($store, $param = [])
    {
        $this->store = $store;
        $this->param = $param;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'content' => auth()->user()->employee->name . ' created and assigned new store <strong>' . $this->store->name . '</strong>',
            'url' => $notifiable->role_id == Roles::ADMIN ? route('employee.migrate_store', $this->param['employee_id']) : '#'
        ];
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
