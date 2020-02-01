<?php


namespace App\Core;


use Closure;

class Environment
{

    protected string $env = 'production';
    protected ?Closure $customHandler = null;

    public function handle()
    {
        if ($this->customHandler !== null) {
            $this->customHandler->call($this, $this->env);
            return;
        }

        switch ($this->env) {
            case 'production':
                ini_set('display_errors', 0);
                break;
            case 'development':
                ini_set('display_errors', 1);
                break;
            case 'staging':
                ini_set('display_errors', 0);
                break;
        }
    }

    /**
     * @param  string  $env
     *
     * @return Environment
     */
    public function setEnv(string $env): Environment
    {
        $this->env = $env;
        return $this;
    }

    /**
     * @param  \Closure|null  $customHandler
     *
     * @return Environment
     */
    public function setCustomHandler(Closure $customHandler): Environment
    {
        $this->customHandler = $customHandler;
        return $this;
    }

}
