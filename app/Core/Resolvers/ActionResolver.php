<?php


namespace App\Core\Resolvers;


use ReflectionMethod;
use App\Core\BaseDto;
use App\Core\DtoValidate;
use App\Core\Http\Pipeline;
use App\Core\Contracts\AuthGuard;
use App\Core\Annotations\Middleware;
use Psr\Container\ContainerInterface;
use App\Core\Annotations\Authenticate;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Exceptions\IoCContainerException;
use App\Core\Exceptions\UnauthorizedException;
use Doctrine\Common\Annotations\AnnotationReader;

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
     * @throws \App\Core\Exceptions\UnauthorizedException
     * @throws \App\Core\Exceptions\ValidationException
     * @throws \Doctrine\Common\Annotations\AnnotationException
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

        $pipeline = new Pipeline();

        $this->handleAnnotations($reflex, $container, $pipeline);

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


            if (($parent = $param->getClass()->getParentClass()) && $parent->getName() === BaseDto::class) {
                $invokeParams[] = (new DtoValidate($container, $this->request))->validate($paramType);
            }

            if (isset($this->params[$paramName])) {
                $invokeParams[] = $this->params[$paramName];
            }
        }
        return $pipeline->handle(
            $this->request,
            function () use ($invokeParams, $reflex) {
                return $reflex->invokeArgs($this->controllerInstance, $invokeParams);
            }
        );
    }

    /**
     * @throws \App\Core\Exceptions\UnauthorizedException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     *
     * @param  \App\Core\Http\Pipeline  $pipeline
     * @param  \ReflectionMethod  $reflectionMethod
     * @param  \Psr\Container\ContainerInterface  $container
     */
    protected function handleAnnotations(
        ReflectionMethod $reflectionMethod,
        ContainerInterface $container,
        Pipeline $pipeline
    ): void {
        $annotationsReader = new AnnotationReader();
        $annotations = $annotationsReader->getMethodAnnotations($reflectionMethod);
        /** @var Authenticate|null $authAnnotation */
        $authAnnotation = $annotationsReader->getMethodAnnotation($reflectionMethod, Authenticate::class);

        if ($authAnnotation && ($auth = $container->get($authAnnotation->guard)) && $auth instanceof AuthGuard) {
            $request = $auth->authenticate($this->request);

            if ($request !== null) {
                $this->request = $request;
            } else {
                throw new UnauthorizedException();
            }
        }

        foreach ($annotations as $annotation) {
            if ($annotation instanceof Middleware) {
                foreach ($annotation->middleware as $m) {
                    $pipeline->addMiddleware($container->get($m));
                }
            }
        }
    }

}
