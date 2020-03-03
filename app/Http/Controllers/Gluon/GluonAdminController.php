<?php

namespace App\Http\Controllers\Gluon;

use Illuminate\Http\Request;
use Gluon;
use GluonConfig;

use DB;

class GluonAdminController extends \App\Http\Controllers\Controller
{

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

    public function edit($entityType, $id) {
        $entity = Gluon::getOne($entityType, $id);
        $entityDefinition = GluonConfig::getDefinition($entity->type);
        $entityConstraints = GluonConfig::getConstraints($entity->type);

        return view('gluon.admin.form', [
            'entityType' => $entity->type,
            'entityDefinition' => $entityDefinition,
            'entityConstraints' => $entityConstraints,
            'entity' => $entity,
        ]);
    }

    public function create($type) {
        $entityDefinition = GluonConfig::getDefinition($type);
        $entity = Gluon::getEmpty($type);

        return view('gluon.admin.form', [
            'entity' => $entity,
            'entityType' => $type,
            'entityDefinition' => $entityDefinition,
        ]);
    }

    /*
        Merge "files" data with "post" data in an unified array.
    */
    protected function getMergedData(Request $request, $key){

        $entityData = $request->request->get($key);
        $entityFileData = $request->files->get($key);

        if (! $entityData && ! $entityFileData){
            return NULL;
        }

        if (! $entityFileData){
            return $entityData;
        }

        foreach ($entityFileData as $parameter => $fileData) {
            if (! isset($entityData[$parameter])) {
                $entityData[$parameter] = $fileData;
            } else {
                $entityData[$parameter] = array_merge($entityData[$parameter], $fileData);
            }
        }

        return $entityData;
    }

    public function handleForm(Request $request) {
        $entityData = $this->getMergedData($request, 'entity');
        
        if (! $entityData) {
            return;
        }

        $entityId = $entityData['id'];
        $entityType = $entityData['type'];

        $result = Gluon::save($entityId, $entityType, $entityData);
        return redirect("admin/edit/$entityType/$entityId");

        
/*

$id = DB::table('users')->insertGetId(
    ['email' => 'john@example.com', 'votes' => 0]
);

*/

    }
}
