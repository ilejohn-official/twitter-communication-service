<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CommunicationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('channel.provider', function ($app) {
            $channel = $this->determineChannel();

            switch ($channel) {
                case 'twitter':
                    return new TwitterChannelProvider();

                default:
                    throw new \Exception("Unsupported channel: $channel");
            }
        });
    }

    protected function determineChannel()
    {
        // Update logic to use other channels in future
        return 'twitter';
    }
}
