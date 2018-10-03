<?php 

namespace App\Scheduler;

class Kernel {
    /**
     * The tasks.
     *
     * @var array
     */
    protected $tasks = [];

    /**
    * Add an event

    * @var Event $event
    * @return void
    */
    public function add (Task $task)
    {
        $this->tasks[] = $task;

        return $task;
    }

    /**
    * Run the sheduled tasks.
    *
    * @return void
    */
    public function run ()
    {
        foreach ($this->getTasks() as $task) {
            if (!$task->isDueToRun()) {
                continue;
            }

            $task->handle();
        }
    }

    /**
    * Get tasks.
    *
    * @return void
    */
    public function getTasks ()
    {
        return $this->tasks;
    }
}

?>