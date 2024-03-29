<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SubtaskCreated extends Notification
{
    use Queueable;

    protected $group_id;
    protected $task_title;
    protected $subtask_title;
    protected $name;
    protected $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($group_id, $task_id, $subtask_title, $name, $type)
    {
        $this->group_id = $group_id;
        $this->task_id = $task_id;
        $this->subtask_title = $subtask_title;
        $this->name = $name;
        $this->type = $type;
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
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        $routePrefix = $this->getRoutePrefix();

        return [
            'link' => url($routePrefix . '/project/' . $this->group_id . '/task-'. $this->task_id),
            'name' => $this->name,
            'data' => "You're Assign to the Subtask: ". $this->subtask_title . ".",
        ];
    }

    private function getRoutePrefix()
    {
        if ($this->type == 'office') {
            $routePrefix = 'office';
        } elseif ($this->type == 'faculty') {
            $routePrefix = 'faculty';
        } else {
            $routePrefix = '';
        }

        return $routePrefix;
    }
}
