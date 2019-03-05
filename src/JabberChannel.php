<?php

namespace NotificationChannels\Jabber;

use Exception;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Notifications\Notification;
use NotificationChannels\Jabber\Exceptions\CouldNotSendNotification;

class JabberChannel
{
    protected $jabber;

    protected $events;

    public function __construct(Jabber $jabber, Dispatcher $events)
    {
        $this->jabber = $jabber;
        $this->events = $events;
    }

    public function send($notifiable, Notification $notification)
    {
        try {
            $to = $this->getTo($notifiable);
            $message = $notification->toJabber($notifiable);
            if (is_string($message)) {
                $message = JabberMessage::create($message);
            }
            if (!$message instanceof JabberMessage) {
                throw CouldNotSendNotification::invalidMessageObject($message);
            }
            if (isset($message->payload['text']) && $message->payload['chat_id']) {
                return $this->jabber->sendMessage($message->payload['text'], $message->payload['chat_id']);
            } else {
                throw new \Exception('Error Processing Request', 1);
            }
        } catch (Exception $e) {
            $event = new NotificationFailed(
                $notifiable,
                $notification,
                'twilio',
             ['message' => $exception->getMessage(), 'exception' => $exception]
         );
            if (function_exists('event')) { // Use event helper when possible to add Lumen support
                event($event);
            } else {
                $this->events->fire($event);
            }
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
