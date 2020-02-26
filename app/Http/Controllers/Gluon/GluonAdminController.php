<?php

namespace App\Http\Controllers\Gluon;

use Illuminate\Http\Request;
use Gluon;
use GluonConfig;

class GluonAdminController extends \App\Http\Controllers\Controller
{

    //@todo call sub controller pour aside
    public function list($entityType) {
        $entityTypeList = GluonConfig::getEntityTypeList();
        $entityDefinition = GluonConfig::getDefinition($entityType);
        $entityList = Gluon::getList($entityType);

        return view('gluon.admin.list', [
            'entityType' => $entityType,
            'entityList' => $entityList,
            'firstEntity' => isset($entityList[0]) ? $entityList[0] : null,
            'entityDefinition' => $entityDefinition,

            'entityTypeList' => $entityTypeList
            //'pagination' => $pagination
        ]);
    }

    public function get($id) {
        $entity = Gluon::getOne($id);
        $entityDefinition = GluonConfig::getDefinition($entity->type);

        return view('gluon.admin.get', [
            'entityType' => $entity->type,
            'entityDefinition' => $entityDefinition,
            'entity' => $entity,
        ]);
    }
}
