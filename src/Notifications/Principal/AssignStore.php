<?php

namespace Sada\SadataComponent\Notifications\Principal;

use Sada\SadataComponent\Models\Main\Roles;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignStore extends Notification
{
    use Queueable;

    private $param, $isAssign;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($param, $isAssign = true)
    {
        $this->param = $param;
        $this->isAssign = $isAssign;
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
     * Database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        $type = $this->isAssign ? 'assigned to' : 'unassigned from';

        // $forEmployee = "<strong>You're</strong> $type <strong>" . $this->param['store']->name . "</strong> store.";
        // $forTeamLeader = "<strong>" . $this->param['employee']->name . "</strong> $type <strong>" . $this->param['store']->name . "</strong>";

        $content = $notifiable->role_id == Roles::TEAM_LEADER
                    ? "<strong>" . $this->param['employee']->name . "</strong> $type <strong>" . $this->param['store']->name . "</strong>"
                    : "<strong>You're</strong> $type <strong>" . $this->param['store']->name . "</strong> store.";


        return [
            // 'content' => $notifiable->role_id == Roles::TEAM_LEADER ? $forTeamLeader : $forEmployee
            'content' => $content
        ];
    }
}
