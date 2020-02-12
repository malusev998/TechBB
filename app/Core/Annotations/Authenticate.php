<?php


namespace App\Core\Annotations;

/**
 * Class Authenticate
 *
 * @package App\Core\Annotations
 * @Annotation
 */
class Authenticate
{
    /**
     * @var string
     */
    public string $guard = 'default';
}
