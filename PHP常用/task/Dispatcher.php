<?php

class Dispatcher
{

    private $driver;

    public function __construct(QueueDriver $driver)
    {
        $this->driver = $driver;
    }


    public function run(Closure $closure){
        while(true) {
            $message = $this->driver->pop();
            try {
                call_user_func($closure, [intval($message[1])]);
            }catch (Throwable $throwable){
                $this->driver->push($message);
            }
        }
    }
}