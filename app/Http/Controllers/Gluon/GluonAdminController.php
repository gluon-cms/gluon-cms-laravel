<?php

namespace App\Http\Controllers\Gluon;

use Illuminate\Http\Request;
use Gluon;
use GluonConfig;

class GluonAdminController extends \App\Http\Controllers\Controller
{

    public function list($type) {
        $entities = Gluon::getList($type);
        $entityDescription = GluonConfig::getDescription($type);

        return view('gluon.admin.list', [
            'type' => $type,
            'entities' => $entities,
            'firstEntity' => $entities[0],
            'description' => $entityDescription,
            //'pagination' => $pagination
        ]);
    }

    public function get($id) {
        $entity = Gluon::getOne($id);
        $entityDescription = GluonConfig::getDescription($entity->type);

        return view('gluon.admin.get', [
            'type' => $entity->type,
            'entity' => $entity,
            'description' => $entityDescription
        ]);
    }
}
