<?php


namespace App\Core\Resolvers;


use ReflectionMethod;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Exceptions\IoCContainerException;

class ActionResolver implements Resolver
{
    protected object $controllerInstance;

    protected string $action;

    protected array $params = [];

    protected Request $request;

    public function __construct(?object $controllerInstance, string $action, Request $request, array $params = [])
    {
        $this->controllerInstance = $controllerInstance;
        $this->action = $action;
        $this->request = $request;
        $this->params = $params;
    }


    /**
     * @throws \App\Core\Exceptions\IoCContainerException
     * @throws \ReflectionException
     *
     * @param  \Psr\Container\ContainerInterface  $container
     *
     * @return mixed
     */
    public function resolve(ContainerInterface $container)
    {
        if ($this->controllerInstance === null) {
            throw new IoCContainerException();
        }

        $reflex = new ReflectionMethod($this->controllerInstance, $this->action);

        $params = $reflex->getParameters();

        $invokeParams = [];

        foreach ($params as $param) {
            $paramName = $param->getName();
            if($param->hasType()) {
                $paramType = $param->getType();
            }
            if($paramName === 'request' || (isset($paramType) && $paramType->getName() === Request::class)) {
                $invokeParams[] = $this->request;
            }


            if(isset($this->params[$paramName])) {
                $invokeParams[] = $this->params[$paramName];
            } else {
                $invokeParams[] = array_shift($this->params);
            }
        }
//
//        if(count($params) !== count($invokeParams)) {
//            throw new \RuntimeException('Invalid Number of parameters passed');
//        }

        return $reflex->invokeArgs($this->controllerInstance, $invokeParams);
    }
}
