<?php 

namespace App\Tasks;

use GuzzleHttp\Client;
use App\Scheduler\Task;
use App\Scheduler\Kernel;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\EventDispatcher\EventDispatcher;
use App\Events\EndpointIsDown;

class PingEndpoint  extends Task
{
    protected $endpoint;

    protected $client;

    protected $dispatcher;

    /**
    * Public Method __construct
    *
    * @return void
    */
    public function __construct ($endpoint, Client $client, EventDispatcher $dispatcher)
    {
        $this->endpoint = $endpoint;
        $this->client = $client;
        $this->dispatcher = $dispatcher;
    }


    /**
    * Public Method handle
    *
    * @return void
    */
    public function handle ()
    {
        try {
            $response = $this->client->request('GET', $this->endpoint->uri);
        }catch (RequestException $e) {
            $response = $e->getResponse();
        }

        $this->endpoint->statuses()->create([
            'status_code' => $response->getStatusCode()
        ]);

        $this->dispatchEvents();
    }

    /**
    * Protected Method dispatchEvents
    *
    * @return void
    */
    protected function dispatchEvents ()
    {
        if ($this->endpoint->status->isDown()) {
            $this->dispatcher->dispatch(EndpointIsDown::NAME, new EndpointIsDown($this->endpoint));
        }

        if ($this->endpoint->isBackUp()) {
            $this->dispatcher->dispatch(EndpointIsUp::NAME, new EndpointIsUp($this->endpoint));
        }
    }
}


?>