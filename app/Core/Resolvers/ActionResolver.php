<?php


namespace App\Core\Resolvers;


use ReflectionMethod;
use App\Core\BaseDto;
use App\Core\DtoValidate;
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
     * @throws \App\Core\Exceptions\ValidationException
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
            if ($param->hasType()) {
                $paramType = $param->getType();
            }
            if ($paramName === 'request' || (isset($paramType) && $paramType->getName() === Request::class)) {
                $invokeParams[] = $this->request;
            }


            if (($parent = $param->getClass()->getParentClass()) !== null && $parent->getName() === BaseDto::class) {
                $invokeParams[] = (new DtoValidate($container, $this->request))->validate($parent->getName());
            }

            if (isset($this->params[$paramName])) {
                $invokeParams[] = $this->params[$paramName];
            } else {
                $invokeParams[] = array_shift($this->params);
            }
        }

        return $reflex->invokeArgs($this->controllerInstance, $invokeParams);
    }
}
