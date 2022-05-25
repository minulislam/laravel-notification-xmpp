<?php

namespace NotificationChannels\Jabber;

use Fabiang\Xmpp\Client;
use Fabiang\Xmpp\Options;
use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;

class JabberServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */

    /*    public function boot()
        {


                    $this->app->when(JabberChannel::class)
                         ->needs(Jabber::class)
                         ->give(function () {
                             $jabberConfig = config('services.jabber');
                             $options      = new Options($jabberConfig['address']);
                             $options->setUsername($jabberConfig['username'])
                             ->setPassword($jabberConfig['password']) ;

                             return new Jabber(
                                 new Client(
                                     $options
                                 )
                             );
                         });


        }*/

    /**
        * Register the application services.
        */
    public function register(): void
    {
        $this->app->bind(Jabber::class, function () {
            $jabberConfig = config('services.jabber');
            $options      = new Options($jabberConfig['address']);
            $logger = $this->app['log'];
            $options->setLogger($logger)
            ->setUsername($jabberConfig['username'])
            ->setPassword($jabberConfig['password']);

            return new Jabber(
                new Client(
                    $options
                )
            );
        });

        Notification::resolved(function (ChannelManager $service) {
            $service->extend('Jabber', function ($app) {
                return $app->make(JabberChannel::class);
            });
        });
    }
}
