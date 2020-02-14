<?php


namespace App\Core\Resolvers;


use Throwable;
use ReflectionClass;
use ReflectionMethod;
use App\Core\BaseDto;
use App\Core\DtoValidate;
use App\Core\Http\Pipeline;
use App\Core\Annotations\Can;
use App\Core\Contracts\AuthGuard;
use App\Core\Annotations\Middleware;
use Psr\Container\ContainerInterface;
use App\Core\Annotations\Authenticate;
use App\Core\Contracts\PermissionResolver;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Exceptions\IoCContainerException;
use App\Core\Exceptions\UnauthorizedException;
use App\Core\Exceptions\UnauthenticatedException;
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
     * @throws \App\Core\Exceptions\UnauthenticatedException
     * @throws \App\Core\Exceptions\ValidationException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \ReflectionException
     * @throws \App\Core\Exceptions\UnauthorizedException
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

        $reflectionMethod = new ReflectionMethod($this->controllerInstance, $this->action);

        $pipeline = new Pipeline();

        $this->handleAnnotations(
            new ReflectionClass($this->controllerInstance),
            $reflectionMethod,
            $container,
            $pipeline
        );

        $params = $reflectionMethod->getParameters();

        $invokeParams = [];

        foreach ($params as $param) {
            $paramName = $param->getName();
            if ($param->hasType()) {
                $paramType = $param->getType();
            }

            if ($paramName === 'request' || (isset($paramType) && $paramType->getName() === Request::class)) {
                $invokeParams[] = $this->request;
            }


            if (($class = $param->getClass()) && ($parent = $class->getParentClass()) && $parent->getName() ===
                                                                                         BaseDto::class) {
                $invokeParams[] = (new DtoValidate($container, $this->request))->validate($paramType);
            }

            if (isset($this->params[$paramName])) {
                $invokeParams[] = $this->params[$paramName];
            }
        }
        return $pipeline->handle(
            $this->request,
            function () use ($invokeParams, $reflectionMethod) {
                return $reflectionMethod->invokeArgs($this->controllerInstance, $invokeParams);
            }
        );
    }

    /**
     * @throws \App\Core\Exceptions\UnauthenticatedException
     * @throws \Doctrine\Common\Annotations\AnnotationException
     * @throws \App\Core\Exceptions\UnauthorizedException
     *
     * @param  \Psr\Container\ContainerInterface  $container
     * @param  \App\Core\Http\Pipeline  $pipeline
     * @param  \ReflectionClass  $reflectionClass
     * @param  \ReflectionMethod  $reflectionMethod
     */
    protected function handleAnnotations(
        ReflectionClass $reflectionClass,
        ReflectionMethod $reflectionMethod,
        ContainerInterface $container,
        Pipeline $pipeline
    ): void {
        $reader = new AnnotationReader();

        $this->handleClassAnnotations($reader, $reflectionClass, $container, $pipeline);
        $this->handleMethodAnnotations($reader, $reflectionMethod, $container, $pipeline);
    }

    /**
     * @throws \App\Core\Exceptions\UnauthenticatedException
     * @throws \App\Core\Exceptions\UnauthorizedException
     *
     * @param  \ReflectionClass  $reflex
     * @param  \Psr\Container\ContainerInterface  $container
     * @param  \App\Core\Http\Pipeline  $pipeline
     * @param  \Doctrine\Common\Annotations\AnnotationReader  $reader
     */
    protected function handleClassAnnotations(
        AnnotationReader $reader,
        ReflectionClass $reflex,
        ContainerInterface $container,
        Pipeline $pipeline
    ): void {
        $annotations = $reader->getClassAnnotations($reflex);
        $this->handleSharedAnnotations(
            $container,
            $reader->getClassAnnotation(
                $reflex,
                Authenticate::class
            ),
            $reader->getClassAnnotation(
                $reflex,
                Can::class
            ),
            $annotations,
            $pipeline
        );
    }

    /**
     * @throws \App\Core\Exceptions\UnauthenticatedException
     * @throws \App\Core\Exceptions\UnauthorizedException
     *
     * @param  \ReflectionMethod  $reflectionMethod
     * @param  \Psr\Container\ContainerInterface  $container
     * @param  \App\Core\Http\Pipeline  $pipeline
     * @param  \Doctrine\Common\Annotations\AnnotationReader  $reader
     */
    protected function handleMethodAnnotations(
        AnnotationReader $reader,
        ReflectionMethod $reflectionMethod,
        ContainerInterface $container,
        Pipeline $pipeline
    ): void {
        $annotations = $reader->getMethodAnnotations($reflectionMethod);
        $this->handleSharedAnnotations(
            $container,
            $reader->getMethodAnnotation(
                $reflectionMethod,
                Authenticate::class
            ),
            $reader->getMethodAnnotation(
                $reflectionMethod,
                Can::class
            ),
            $annotations,
            $pipeline
        );
    }

    /**
     * @throws \App\Core\Exceptions\UnauthenticatedException
     * @throws \App\Core\Exceptions\UnauthorizedException
     *
     * @param  \App\Core\Annotations\Authenticate|null  $authenticate
     * @param  \App\Core\Annotations\Can|null  $can
     * @param  array|null  $annotations
     * @param  \App\Core\Http\Pipeline  $pipeline
     * @param  \Psr\Container\ContainerInterface  $container
     */
    private function handleSharedAnnotations(
        ContainerInterface $container,
        ?Authenticate $authenticate,
        ?Can $can,
        ?array $annotations,
        Pipeline $pipeline
    ): void {
        // TODO: Optimize annotation parsing

        if ($authenticate) {
            $this->authenticate(
                $authenticate,
                $container
            );
            if ($can) {
                $this->authorize($can, $container);
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

    /**
     * @throws \App\Core\Exceptions\UnauthenticatedException
     *
     * @param  \Psr\Container\ContainerInterface  $container
     * @param  \App\Core\Annotations\Authenticate|null  $authenticate
     */
    private function authenticate(Authenticate $authenticate, ContainerInterface $container): void
    {
        if (($auth = $container->get($authenticate->guard)) && $auth instanceof AuthGuard) {
            $request = $auth->authenticate($this->request);

            if ($request !== null) {
                $this->request = $request;
            } else {
                throw new UnauthenticatedException();
            }
        }
    }


    /**
     * @throws \App\Core\Exceptions\UnauthorizedException
     *
     * @param  \Psr\Container\ContainerInterface  $container
     * @param  \App\Core\Annotations\Can  $can
     */
    private function authorize(Can $can, ContainerInterface $container): void
    {
        try {
            $resolver = $container->get(PermissionResolver::class);
        } catch (Throwable $e) {
            return;
        }

        if (!$resolver->resolve($this->request, $can->permissions ?? [])) {
            throw new UnauthorizedException();
        }
    }

}
