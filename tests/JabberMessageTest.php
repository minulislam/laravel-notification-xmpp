<?php

namespace NotificationChannels\Jabber\Test;

use NotificationChannels\Jabber\JabberMessage;

class JabberMessageTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_accepts_content_when_constructed()
    {
        $message = new JabberMessage('Laravel Notification Channels are awesome!');
        $this->assertEquals('Laravel Notification Channels are awesome!', $message->payload['text']);
    }

    /** @test */
    public function the_recipients_chat_id_can_be_set()
    {
        $message = new JabberMessage();
        $message->to(12345);
        $this->assertEquals(12345, $message->payload['chat_id']);
    }

    /** @test */
    public function the_notification_message_can_be_set()
    {
        $message = new JabberMessage();
        $message->content('Laravel Notification Channels are awesome!');
        $this->assertEquals('Laravel Notification Channels are awesome!', $message->payload['text']);
    }

    /** @test */
    public function additional_options_can_be_set_for_the_message()
    {
        $message = new JabberMessage();
        $message->options(['foo' => 'bar']);
        $this->assertEquals('bar', $message->payload['foo']);
    }

    /** @test */
    public function it_can_determine_if_the_recipient_chat_id_has_not_been_set()
    {
        $message = new JabberMessage();
        $this->assertTrue($message->toNotGiven());

        $message->to(12345);
        $this->assertFalse($message->toNotGiven());
    }

    /** @test */
    public function it_can_return_the_payload_as_an_array()
    {
        $message = new JabberMessage('Laravel Notification Channels are awesome!');
        $message->to(12345);
        $message->options(['foo' => 'bar']);
        $expected = [
            'text' => 'Laravel Notification Channels are awesome!',
            'chat_id' => 12345,
            'foo' => 'bar',
        ];

        $this->assertEquals($expected, $message->toArray());
    }
}
