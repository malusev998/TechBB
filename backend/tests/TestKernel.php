<?php


namespace App\Tests;


use App\Core\Kernel;

class TestKernel extends Kernel
{

    protected function boot(): void
    {
    }


    /**
     * @throws \Exception
     */
    public function run()
    {
        return $this->injection();
    }
}
