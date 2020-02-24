<?php

namespace App\Gluon\Bridge;

use Illuminate\Support\Facades\Facade;

class GluonConfigFacade extends Facade {

    protected static function getFacadeAccessor() { 
        return 'gluonConfig'; 
    }

}
