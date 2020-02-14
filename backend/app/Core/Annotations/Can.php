<?php


namespace App\Core\Annotations;


use Doctrine\Common\Annotations\Annotation\Target;
use Doctrine\Common\Annotations\Annotation\Required;

/**
 * Class Can
 *
 * @package App\Core\Annotations
 * @Annotation
 * @Target({"METHOD", "CLASS"})
 */
class Can
{
    /**
     * @var array
     * @Required()
     */
    public array $permissions = [];
}
