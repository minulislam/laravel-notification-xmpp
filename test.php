<?php

require 'vendor/autoload.php';
error_reporting(-1);

use Monolog\Logger;
use Fabiang\Xmpp\Client;
use Fabiang\Xmpp\Options;
use Fabiang\Xmpp\Protocol\Roster;
use Fabiang\Xmpp\Protocol\Message;
use Monolog\Handler\StreamHandler;
use Fabiang\Xmpp\Protocol\Presence;

$logger = new Logger('xmpp');
$logger->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));
$infos = [
    'host'       => 'xmpp.org.uk',
    'send-alias' => 'findsome987',
    'username'   => 'findsome987',
    'password'   => 'exp9007',
];
$hostname = 'xmpp.org.uk';
$port = 5222;
$connectionType = 'tcp';
$address = "$connectionType://$hostname:$port";

$username = 'findsome987';
$password = 'exp9007';

$options = new Options($address);
$options->setLogger($logger)
        ->setUsername($username)
        ->setPassword($password);

$client = new Client($options);

$client->connect();
//$client->send(new Roster);
//$client->send(new Presence);

$message = new Message();
        $message->setMessage('itas jabber')->setTo('nopm@xmpp.jp');
     $client->send($message);
$client->disconnect();
