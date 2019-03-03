<?php

namespace NotificationChannels\Jabber;

use Fabiang\Xmpp\Client as JabberClient;
use Fabiang\Xmpp\Options;
use Fabiang\Xmpp\Protocol\Message;
use Fabiang\Xmpp\Protocol\Presence;
use Fabiang\Xmpp\Protocol\Roster;
use Psr\Log\LoggerInterface;

class Jabber
{
    protected $options;
    protected $client;
    protected $config = [];
    protected $logger;
    protected $message;
    protected $roster;
    protected $presence;

    public function __construct(
        array           $config = [],
        JabberClient    $client = null,
        LoggerInterface $logger = null
    ) {
        $this->setConfig($config);
        $this->client = $client;
        $this->logger = $logger ?: app('log');
    }

    protected function client()
    {
        return $this->client ?: $this->client = new JabberClient($this->getOptions());
    }

    protected function setOptions($options = [])
    {
        $this->options = (new Options($options['address']))
            ->setUsername($options['username'])
            ->setPassword($options['password'])
            ->setLogger($this->logger);
    }

    protected function getOptions()
    {
        return $this->options;
    }

    protected function setConfig($config)
    {
        $this->config = $config;
        $this->setOptions($config['login']);

        return $this;
    }

    public function message()
    {
        return $this->message ?: $this->message = new Message();
    }

    public function setMessage($msg)
    {
        return $this->message()->setMessage($msg);
    }

    public function setTo($jabberId)
    {
        return $this->message()->setTo($jabberId);
    }

    public function sendMessage($params=[])
    {
        $this->connect();

        return $this
            ->client()
            ->send($this
                    ->message()
                    ->setMessage($params['text'])
                    ->setTo($params['chat_id']));
    }

    public function roster()
    {
        return $this->roster ?: $this->roster = new Roster();
    }

    public function presence()
    {
        return $this->presence ?: $this->presence = new Presence();
    }

    public function sendPresence()
    {
        return $this->client()->send($this->presence());
    }

    public function sendRoster()
    {
        return $this->client()->send($this->roster());
    }

    public function joinChannel($params=[])
    {
        $this->connect();

        return $this->client()->send(
            $this->presence()
                 ->setTo($params['channel_name'])
                 ->setPassword($params['channel_password'])
                 ->setNickName('mynick')
        );
    }

    public function sendChannelMessage($params=[])
    {
        $this->connect();

        $this->message()->setMessage($params['text'])
             ->setTo($params['channel_name'])
             ->setType(Message::TYPE_GROUPCHAT);

        return  $this->client()->send($this->message());
    }

    public function connect()
    {
        return $this->client()->connect();
    }

    public function disConnect()
    {
        return $this->client()->disconnect();
    }
}
