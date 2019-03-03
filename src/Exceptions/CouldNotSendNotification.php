<?php

namespace NotificationChannels\Jabber\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($response)
    {
        return new static('Descriptive error message.');
    }

    public static function chatIdNotProvided()
    {
        return new static('Jabber notification XMPP ID was not provided. Please refer usage docs.');
    }
}
