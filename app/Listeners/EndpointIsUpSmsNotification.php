<?php 

namespace App\Listeners;

use Twilio\Rest\Client;
use Symfony\Component\EventDispatcher\Event;

class EndpointIsUpSmsNotification
{
    protected $sms;

    public function __construct (Client $sms)
    {
        $this->sms = $sms;
    }
    /**
    * Public Method handle
    *
    * @return void
    */
    public function handle (Event $event)
    {
        $this->sms->messages->create(
            '447464816930',
            [
                'from' => '447464816930',
                'body' => "{$event->endpoint->uri} is UP with status code of {$event->endpoint->status->status_code}"
            ]
        );
    }
}


?>