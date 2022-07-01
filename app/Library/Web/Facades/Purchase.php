<?php

namespace App\Library\Web\Facades;

use Illuminate\Support\Facades\Facade;

class Purchase extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'admin';
    }
}
