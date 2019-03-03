<?php
namespace NotificationChannels\Jabber;

use Fabiang\Xmpp\Options;
use Illuminate\Support\ServiceProvider;
use Fabiang\Xmpp\Client as JabberClient;

class JabberServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(JabberChannel::class)
             ->needs(Jabber::class)
             ->give(function () {
                 return new Jabber(
                     config('services.jabber')

                 );
             });
  /*      $this->app->when(JabberChannel::class)
             ->needs(JabberClient::class)
             ->give(function () {
                 $jabberConfig = config('services.jabber');
                 $options      = (new Options(
                     $jabberConfig['address']
                 ))
                     ->setUsername($jabberConfig['username'])
                     ->setPassword($jabberConfig['password']);

                 return $options;
                 $client = new JabberClient($options);

                 $client->connect();

             });*/
    }

    /**
     * Register the application services.
     */
    public function register() {
        //
    }
}
