<?php


namespace App\Core\Parser;


use Error;
use App\Core\Contracts\Parser;
use App\Core\Exceptions\ControllerNotFoundException;

class ActionParser implements Parser
{
    protected string $delimiter = '@';

    protected string $namespace = 'App\\Controller\\';

    public function __construct(string $namespace, ?string $delimiter = null)
    {
        $this->namespace = $namespace;
        if ($delimiter !== null) {
            $this->delimiter = $delimiter;
        }
    }

    /**
     * @throws \App\Core\Exceptions\ControllerNotFoundException
     *
     * @param $data
     *
     * @return array
     */
    public function parse($data): array
    {
        if (is_string($data)) {
            [$controller, $action] = explode($this->delimiter, $data);
        } elseif (is_array($data)) {
            [$controller, $action] = $data;
        } else {
            throw new Error('Invalid type for controller and action, only string and arrays are accepted');
        }

        if (class_exists($controller)) {
            return [$controller, $action];
        }

        if (class_exists($this->namespace.$controller)) {
            return [$this->namespace.$controller, $action];
        }

        throw new ControllerNotFoundException();
    }
}
