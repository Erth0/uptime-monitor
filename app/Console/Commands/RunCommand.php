<?php 

namespace App\Console\Commands;

use GuzzleHttp\Client;
use App\Models\Endpoint;
use App\Scheduler\Kernel;
use App\Tasks\PingEndpoint;
use App\Console\Commands\CanForce;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class RunCommand extends Command
{
    use CanForce;

    public $client;

    public $dispatcher;

    /**
    * Public Method __construct
    *
    * @return void
    */
    public function __construct (Client $client, EventDispatcher $dispatcher)
    {
        $this->client = $client;
        $this->dispatcher = $dispatcher;

        parent::__construct();
    }

    /**
    * Protected Method configure
    *
    * @return void
    */
    protected function configure ()
    {
        $this->setName('run');
        $this->addForceOption();
    }

    /**
    * Protected Method execute
    *
    * @return void
    */
    protected function execute (InputInterface $input, OutputInterface $output)
    {
        $kernel = new Kernel;

        $endpoints = Endpoint::get();

        foreach ($endpoints as $endpoint) {
            $kernel->add(
                new PingEndpoint($endpoint, $this->client, $this->dispatcher)
            )
            ->everyMinutes($this->isForced($input) ? 1 :$endpoint->frequency);

            $kernel->run();
        }

    }

}


?>