<?php

namespace NotificationChannels\Jabber\Test;

use Mockery;
use Illuminate\Notifications\Notification;
use NotificationChannels\Jabber\JabberMessage;
use NotificationChannels\Jabber\Exceptions\CouldNotSendNotification;
use PHPUnit\Framework\TestCase;
use Norgul\Xmpp\Options;
use Norgul\Xmpp\XmppClient;

class ChannelTest extends TestCase
{
  /** @var Mockery\Mock */
  protected $Jabber;
  /** @var \Fabiang\Xmpp\Client */
  protected $client;
  /** @var \NotificationChannels\Jabber\JabberChannel */
  protected $channel;

  protected static $host     = 'xmpp.is';
  protected static $port     = 5222;
  protected static $username = 'b0t';
  protected static $password = 'IeCh1ahyahr7thieCa2quai5';

  protected function setUp(): void
  {
    parent::setUp();
    // $jabberConfig = [
    //   'address'       => 'tcp://xmpp.org.uk:5222',
    //   'send-alias' => 'findsome987',
    //   'username'   => 'findsome987',
    //   'password'   => 'exp9007',
    // ];

    $options = new Options();
    $options
        ->setHost(self::$host)
        ->setPort(self::$port)
        ->setUsername(self::$username)
        ->setPassword(self::$password);

    $client = new XmppClient($options);
    $client->connect();

    $client->iq->getRoster();

    $client->message->send('Hello world', 'f4bio@xmpp.is');

    // $options = new Options($jabberConfig['address']);
    // $options->setUsername($jabberConfig['username'])
    //   ->setPassword($jabberConfig['password']);
    // $this->client = new Client($options);

    $this->Jabber = Mockery::mock(Jabber::class);
    //  $this->Jabber = new Jabber($this->client);
    $this->client = Mockery::mock(Client::class);

    // $this->channel = new JabberChannel($this->Jabber);
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
    $this->expectException(CouldNotSendNotification::class);
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
