<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FeedbackSent extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($group_id, $name, $title, $type)
    {   
        $this->group_id = $group_id;
        $this->name = $name;
        $this->title = $title;
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
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        $routePrefix = $this->getRoutePrefix();

        return [
            'link' => url($routePrefix . '/project/' . $this->group_id),
            'data' => $this->name . ' commented in post ' . $this->title, 
        ];
    }

    private function getRoutePrefix() 
    {
        if ($this->type == 'office') {
            $routePrefix = 'office';
        } elseif ($this->type == 'faculty') {
            $routePrefix = 'faculty';
        } else{
            $routePrefix = '';
        }

        return $routePrefix;
    }
}
