<?php

namespace NotificationChannels\Jabber;

use Illuminate\Notifications\Notification;
use NotificationChannels\Jabber\Exceptions\CouldNotSendNotification;

class JabberChannel
{
    /**
     * @var Jabber
     */
    protected $jabber;

    /**
     * Channel constructor.
     *
     * @param Jabber $jabber
     */
    public function __construct(Jabber $jabber)
    {
        $this->jabber = $jabber;
    }


    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toJabber($notifiable);
        if (is_string($message)) {
            $message = JabberMessage::create($message);
        }
        if ($message->toNotGiven()) {
            if (! $to = $notifiable->routeNotificationFor('jabber')) {
                throw CouldNotSendNotification::chatIdNotProvided();
            }
            $message->to($to);
        }
        if (isset($message->content) && $message->to) {

            $this->jabber->sendMessage($message->content,$message->to);
        }
    }
}
