<?php 

namespace App\Console\Commands;

use App\Models\Endpoint;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class RemoveEndpointCommand extends Command
{

    /**
    * Protected Method configure
    *
    * @return void
    */
    protected function configure ()
    {
        $this->setName('endpoint:remove')
            ->addArgument('id', InputArgument::REQUIRED, 'The endpoint ID to remove.');
    }

    /**
    * Protected Method execute
    *
    * @return void
    */
    protected function execute (InputInterface $input, OutputInterface $output)
    {
        $endpoint = Endpoint::find($id = $input->getArgument('id'));

        if (!$endpoint) {
            $output->writeln("<error>Endpoint with Id {$id} does not exists.</error>");
        }else {
            $endpoint->delete();
            $output->writeln("<info>Endpoint with Id {$id} has been deleted.</info>");
        }
    }
}


?>