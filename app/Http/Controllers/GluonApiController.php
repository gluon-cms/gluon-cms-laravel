<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gluon;

class GluonApiController extends Controller
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
