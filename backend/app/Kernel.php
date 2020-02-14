<?php


namespace App;


use App\Core\Kernel as CoreKernel;

class Kernel extends CoreKernel
{
    public function boot(): void
    {
        $this->router
            ->web()
            ->api();
    }
}
