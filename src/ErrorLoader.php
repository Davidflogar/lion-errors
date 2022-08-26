<?php

namespace Lion\LionErrors;

class ErrorLoader
{
    /**
     * Represents the current state of work, such as dev o prod.
     * 
     * @var string
     */
    private $env;

    /**
     * Constructor
     */
    public function __construct($env = "dev")
    {
        $this->env = $env;
    }

    /**
     * Registers the pretty handler.
     *
     * @return \Whoops\Run
     */
    public function register(callable $error_function = null)
    {
        if($this->env == "dev")
        {
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            $whoops->register();
        }
        else if($this->env = "prod")
        {
            if(!is_null($error_function))
            {
                set_exception_handler($error_function);
                set_error_handler($error_function);

                return;
            }

            set_exception_handler(function(){ echo file_get_contents(__DIR__ . "/Assets/server_error.html"); });
            set_error_handler(function(){ echo file_get_contents(__DIR__ . "/Assets/server_error.html"); });
        }
    }

}

?>