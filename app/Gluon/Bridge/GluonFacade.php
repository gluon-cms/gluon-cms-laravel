<?php

namespace App\Gluon\Bridge;

use Illuminate\Support\Facades\Facade;

class GluonFacade extends Facade {

    protected static function getFacadeAccessor() { 
        return 'gluon'; 
    }

}
