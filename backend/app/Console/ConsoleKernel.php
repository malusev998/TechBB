<?php


namespace App\Console;


use App\Core\Kernel;

class ConsoleKernel extends Kernel
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
