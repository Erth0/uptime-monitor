<?php 

namespace App\Console\Commands;

use App\Models\Status;
use App\Models\Endpoint;
use App\Console\Commands\CanForce;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StatusCommand extends Command
{
    use CanForce;

    /**
    * Protected Method configure
    *
    * @return void
    */
    protected function configure ()
    {
        $this->setName('status')
            ->setDescription('Status of all endpoins.');

        $this->addForceOption();
    }

    /**
    * Protected Method execute
    *
    * @return void
    */
    protected function execute (InputInterface $input, OutputInterface $output)
    {

        if ($this->isForced($input)) {
            $this->getApplication()->find('run')->run(
                new ArrayInput([
                    'command' => 'run',
                    '--force' => true
                ]),
                $output
            );
        }

        $endpoints = Endpoint::with('statuses')->orderBy('created_at', 'desc')->get();

        $table = new Table($output);

        $table->setHeaders([
            'ID',
            'URI',
            'Frequency',
            'Last Checked',
            'Status',
            'Response Code'
        ])->setRows($endpoints->map(function($endpoint) {
            return array_merge(
                $endpoint->only(['id', 'uri', 'frequency']),
                $endpoint->status ? $this->getEndpointStatus($endpoint): []
            );
        })->toArray());

            $table->render();

    }

    /**
    * Protected Method getEndpointStatus
    *
    * @return void
    */
    protected function getEndpointStatus (Endpoint $endpoint)
    {
        return [
            'created_at' => $endpoint->status->created_at,
            'status' => $this->formatStatus($endpoint->status),
            'status_code' => $this->formatResponseCode($endpoint->status)
        ];
    }

    /**
    * Protected Method formatStatus
    *
    * @return void
    */
    protected function formatStatus (Status $status)
    {
        if ($status->isDown()) {
            return '<error>Down</error>';
        }

        return '<bg=green;fg=black>Up</>';
    }

    /**
    * Protected Method formatResponseCode
    *
    * @return void
    */
    protected function formatResponseCode (Status $status)
    {
        if ($status->isDown()) {
            return "<error>{$status->status_code}</error>";
        }

        return "<bg=green;fg=black>{$status->status_code}</>";
    }
}


?>