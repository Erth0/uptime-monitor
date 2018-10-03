<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;

trait CanForce
{
    /**
    * Public Method addForceOption
    *
    * @return void
    */
    public function addForceOption ()
    {
        
        $this->addOption('force', 'f', InputOption::VALUE_OPTIONAL, 'Force cgecj regardless of frequency', false);
    }

    /**
    * Protected Method isForced
    *
    * @return void
    */
    protected function isForced (InputInterface $input)
    {
        return $input->getOption('force') !== false;
    }
}