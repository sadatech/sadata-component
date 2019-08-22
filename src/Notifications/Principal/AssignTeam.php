<?php

namespace Sada\SadataComponent\Notifications\Principal;

use Sada\SadataComponent\Models\Main\Roles;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignTeam extends Notification
{
    use Queueable;

    private $employee, $is_assign;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($employee = null, $is_assign = true)
    {
        $this->employee = $employee;
        $this->is_assign = $is_assign;
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

    public function toDatabase($notifiable)
    {
        $type = $this->is_assign ? 'assigned to' : 'unassigned from';

        $forEmployee = '<strong>You\'re</strong> ' . $type . ' <strong>' . $this->employee->name . ' Team</strong>.';
        $forTeamLeader = '<strong>' . $this->employee->name . '</strong> is ' . $type. ' <strong>Your Team</strong>.';

        return [
            'content' => $notifiable->role_id == Roles::EMPLOYEE ? $forEmployee : $forTeamLeader
        ];
    }
}
