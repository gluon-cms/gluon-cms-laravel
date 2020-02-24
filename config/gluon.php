<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Entities descriptions
    |--------------------------------------------------------------------------
    |
    | Here you define your CMS entities
    |
    */

    'entities' => [
        'article' => [
            'text.title',
            'text.content',

            'related.associated (article[])',
            'related.author (artist)'
        ],

        'artist' => [
            'text.fullname',
            'text.bio'
        ]
    ],

    'templates' => [
        'article--light' => [
            'text.title',
            'text.content',

            'related.associated.title',
            'related.author.fullname'
        ]
    ],


    //'admin?'

    //1 seul obj ?
];
