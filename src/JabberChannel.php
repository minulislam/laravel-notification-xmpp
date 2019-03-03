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

    /**
     * Send the given notification.
     *
     * @param mixed                                  $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\Jabber\Exceptions\CouldNotSendNotification
     */
    /*    public function send($notifiable, Notification $notification)
        {
            //$response = [a call to the api of your notification send]

    //        if ($response->error) { // replace this by the code need to check for errors
    //            throw CouldNotSendNotification::serviceRespondedWithAnError($response);
    //        }
        }
        */
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
        if (isset($message->payload['text']) && $message->payload['text']) {
            $params = $message->toArray();
            $this->jabber->sendMessage($params);
        }
    }
}
