<?php


namespace App\Core\Annotations;


/**
 * Class Middleware
 *
 * @Annotation
 * @Target({"METHOD"})
 */
class Middleware
{
    /**
     * @var array
     * @Required
     */
    public array $middleware;
}
