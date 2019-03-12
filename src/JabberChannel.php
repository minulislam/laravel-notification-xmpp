<?php

namespace NotificationChannels\Jabber;

use Exception;
use Illuminate\Notifications\Notification;
use NotificationChannels\Jabber\Exceptions\CouldNotSendNotification;

class JabberChannel
{
    protected $jabber;

    public function __construct(Jabber $jabber)
    {
        $this->jabber = $jabber;
    }

    public function send($notifiable, Notification $notification)
    {
        try {
            $to = $this->getTo($notifiable);
            $message = $notification->toJabber($notifiable);
            if (is_string($message)) {
                $message = JabberMessage::create($message);
            }
            if (! $message instanceof JabberMessage) {
                throw CouldNotSendNotification::invalidMessageObject($message);
            }
            if (isset($message->payload['text']) && $message->payload['chat_id']) {
                return $this->jabber->sendMessage($message->payload['text'], $message->payload['chat_id']);
            }
        } catch (Exception $exception) {
            throw CouldNotSendNotification::chatIdNotProvided($exception);
        }
    }

    protected function getTo($notifiable)
    {
        if ($notifiable->routeNotificationFor('jabber')) {
            return $notifiable->routeNotificationFor('jabber');
        }
        if (isset($notifiable->jabber)) {
            return $notifiable->jabber;
        }
        throw CouldNotSendNotification::chatIdNotProvided();
    }
}
