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

    public function edit($id) {
        $entity = Gluon::getOne($id);
        $entityDefinition = GluonConfig::getDefinition($entity->type);

        return view('gluon.admin.form', [
            'entityType' => $entity->type,
            'entityDefinition' => $entityDefinition,
            'entity' => $entity,
        ]);
    }

    public function create($type) {
        $entityDefinition = GluonConfig::getDefinition($type);

        return view('gluon.admin.form', [
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

        $queries = [];

        foreach ($entityData as $parameter => $value) {
            if ($parameter == 'id' || $parameter == 'type') {
                continue;
            }

            list($parameterType, $parameterKey) = explode(".", $parameter);

            if ($parameterType == 'text') {
                //@todo TextParam
                //loop langs.

                $lang='fr';
                DB::update('update gluon_param_text set value = :text where gluon_entity_id = :entityId and `key` = :key and lang_code = :lang', [
                    'text' => $value[$lang],
                    'entityId' => $entityId,
                    'key' => $parameterKey,
                    'lang' => $lang,
                ]);

                $lang='en';
                DB::update('update gluon_param_text set value = :text where gluon_entity_id = :entityId and `key` = :key and lang_code = :lang', [
                    'text' => $value[$lang],
                    'entityId' => $entityId,
                    'key' => $parameterKey,
                    'lang' => $lang,
                ]);
            }

            if ($parameterType == 'number') {

                DB::update('update gluon_param_number set value = :value where gluon_entity_id = :entityId and `key` = :key', [
                    'value' => $value,
                    'entityId' => $entityId,
                    'key' => $parameterKey
                ]);

            }

            if ($parameterType == 'file') {
                //insert and copy
            }

        }

        return redirect("admin/edit/$entityId");
/*
        DB::transaction(function () {
    DB::table('users')->update(['votes' => 1]);

    DB::table('posts')->delete();
});*/

    }
}
