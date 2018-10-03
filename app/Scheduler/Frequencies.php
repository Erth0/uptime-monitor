<?php 

namespace App\Scheduler;

trait Frequencies
{
    protected $expression = '* * * * *';

    /**
    * Run every 10 minutes
    *
    * @return void
    */
    public function everyMinutes ($minutes = 1)
    {
        $this->expression = "*/{$minutes} * * * *";
    }
}

?>