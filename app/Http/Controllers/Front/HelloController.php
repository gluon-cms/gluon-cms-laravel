<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Gluon;
use GluonConfig;
use App;

class HelloController extends Controller
{

    public function home($locale) {
        App::setLocale($locale);

        $entityList = Gluon::getList('article');

        return view('front.hello.home', [
            'entityList' => $entityList,
        ]);
    }

    public function detail($locale, $slug, $id) {
        App::setLocale($locale);

        $entity = Gluon::getOne('article', $id);

        return view('front.hello.detail', [
            'entity' => $entity,
        ]);
    }

}
