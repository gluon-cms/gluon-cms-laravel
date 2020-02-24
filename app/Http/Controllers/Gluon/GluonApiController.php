<?php

namespace App\Http\Controllers\Gluon;

use Illuminate\Http\Request;
use Gluon;

class GluonApiController extends \App\Http\Controllers\Controller
{

    public function get($id) {

        $entity = Gluon::getOne($id);

        return response()->json([
            'entity' => $entity
        ]);
    }

    public function list($type) {
        $entities = Gluon::getList($type);

        return response()->json([
            'list' => $entities
        ]);
    }
}
