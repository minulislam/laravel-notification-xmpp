<?php
namespace NotificationChannels\Jabber;

use Fabiang\Xmpp\Options;
use Illuminate\Support\ServiceProvider;

class JabberServiceProvider extends ServiceProvider
{

    public function boot()
    {
        /*    $this->app->bind(Jabber::class, function ($app) {
            $config  = $app['config'];
            $options = new Options($config->get('services.jabber.address'));
            $options->setUsername($config->get('services.jabber.username'))
                ->setPassword($config->get('services.jabber.password'));

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
                 $jabberConfig = config('services.jabber');
                 $options      = new Options($jabberConfig['address']);
                 $options->setUsername($jabberConfig['username'])->setPassword($jabberConfig['password']);

                 return new Jabber(
                     new Client(
                         $options
                     )
                 );
             });
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }
}
