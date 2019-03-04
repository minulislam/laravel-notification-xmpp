<?php

require 'vendor/autoload.php';
error_reporting(-1);

use Fabiang\Xmpp\Client;
use Fabiang\Xmpp\Options;
use Fabiang\Xmpp\Protocol\Message;
use Fabiang\Xmpp\Protocol\Presence;
use Fabiang\Xmpp\Protocol\Roster;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$logger = new Logger('xmpp');
$logger->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));
$infos = [
    'host'       => 'xmpp.org.uk',
    'send-alias' => 'findsome987',
    'username'   => 'findsome987',
    'password'   => 'exp9007',
];
$hostname       = 'xmpp.org.uk';
$port           = 5222;
$connectionType = 'tcp';
$address        = "$connectionType://$hostname:$port";

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
$client->send(new Message);

$client->disconnect();
