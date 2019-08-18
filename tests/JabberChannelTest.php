<?php

namespace NotificationChannels\Jabber\Test;

use Fabiang\Xmpp\Client;
use Fabiang\Xmpp\Options;
use Illuminate\Notifications\Notification;
use Mockery;
use NotificationChannels\Jabber\Exceptions\CouldNotSendNotification;
use NotificationChannels\Jabber\Jabber;
use NotificationChannels\Jabber\JabberChannel;
use NotificationChannels\Jabber\JabberMessage;
use Orchestra\Testbench\TestCase;

class ThinqChannelTest extends MockeryTestCase
{
    public $thinq;
    public $channel;
    public $dispatcher;

    public function setUp()
    {
        parent::setUp();
        $this->thinq = Mockery::mock(Thinq::class);
        $this->dispatcher = Mockery::mock(Dispatcher::class);
        $this->channel = new ThinqChannel($this->thinq, $this->dispatcher);
    }

    /**
     * @test
     */
    public function can_send_thinq_message()
    {
        $notifiable = new class {
        };
        $notification = Mockery::mock(Notification::class);

        $message = new ThinqMessage('Message', '+1234567890', '+2346788778');
        $notification->shouldReceive('toThinq')->andReturn($message);

        $this->thinq->shouldReceive('withMessage')
            ->with($message)
            ->andReturn($this->thinq);
        $this->thinq->shouldReceive('sentSms')
            ->once();
        App::shouldReceive('environment')
            ->andReturn('production');
        $this->channel->send($notifiable, $notification);
    }
}

class ChannelTest extends TestCase
{
    /** @var Mockery\Mock */
    protected $Jabber;
    /** @var \Fabiang\Xmpp\Client */
    protected $client;
    /** @var \NotificationChannels\Jabber\JabberChannel */
    protected $channel;

    public function setUp()
    {
        parent::setUp();
        $jabberConfig = [
            'address'       => 'tcp://xmpp.org.uk:5222',
            'send-alias' => 'findsome987',
            'username'   => 'findsome987',
            'password'   => 'exp9007',
        ];

        $options = new Options($jabberConfig['address']);
        $options->setUsername($jabberConfig['username'])
                  ->setPassword($jabberConfig['password']);
        $this->client = new Client($options);

        $this->Jabber = Mockery::mock(Jabber::class);
        //  $this->Jabber = new Jabber($this->client);
        //  $this->client = Mockery::mock(Client::class);

        $this->channel = new JabberChannel($this->Jabber);
    }

    /** @test */
    public function it_can_send_a_message()
    {
        $this->Jabber->shouldReceive('sendMessage')->once()->with([
            'text'       => 'Laravel Notification Channels are awesome!',
            'chat_id'    => 12345,
        ]);
        $this->channel->send(new TestNotifiable(), new TestNotification());
    }

    /** @test */
    public function it_throws_an_exception_when_it_could_not_send_the_notification_because_no_chat_id_provided()
    {
        $this->setExpectedException(CouldNotSendNotification::class);
        $this->channel->send(new TestNotifiable(), new TestNotificationNoChatId());
    }
}

class TestNotifiable
{
    use \Illuminate\Notifications\Notifiable;

    /**
     * @return int
     */
    public function routeNotificationForJabber()
    {
        return false;
    }
}

class TestNotification extends Notification
{
    public function toJabber($notifiable)
    {
        return JabberMessage::create('Laravel Notification Channels are awesome!')->to(12345);
    }
}

class TestNotificationNoChatId extends Notification
{
    public function toJabber($notifiable)
    {
        return JabberMessage::create();
    }
}
