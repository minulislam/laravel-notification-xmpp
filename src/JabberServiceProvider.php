<?php

namespace NotificationChannels\Jabber;

// use Fabiang\Xmpp\Client as JabberService;
use Fabiang\Xmpp\Client;
use Fabiang\Xmpp\Options;
use Illuminate\Support\ServiceProvider;

class JabberServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /*

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
         */
        $this->app->when(JabberChannel::class)
              ->needs(Jabber::class)
              ->give(function () {
                  return new Jabber(
                      $this->app->make(Client::class)
                  );
              });
    }

    public function register()
    {
        $this->registerJabberService();
        $this->registerJabber();
    }

    public function provides()
    {
        return ['jabber'];
    }

    protected function registerJabberService()
    {
        $this->app->bind(Client::class, function () {
            $config = $this->app['config']['services.jabber'];
            $logger = $this->app['log'];
            $options = new Options($config['address']);
            $options->setUsername($config['username'])
                   ->setPassword($config['password']);

            return  new Client($options);
        });
    }

    protected function registerJabber()
    {
        $this->app->singleton('jabber', function ($app) {
            return new Jabber($this->app->make(Client::class));
        });
    }
}
