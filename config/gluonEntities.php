<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Gluon based entities
    |--------------------------------------------------------------------------
    |
    | Here you define your CMS entities, how you want to build them and how you
    | want to query them.
    |
    */

    'definitions' => [

        'article' => [
            'text.title',
            'text.content',

            //'toMany.associated',
            //'toOne.author'
        ],

        'artist' => [
            'text.fullname',
            'text.bio'
        ],

        'place' => [
            'text.label',
            'text.description',

            //'geo.location'
        ],

        'event' => [
            'text.title',

            //'toMany.representations'
        ],

        'representation' => [
            //'date.startDate'
            //'date.endDate'

            //'toOne.event'
        ],

        'genre' => [
            'text.label',
        ],

        'category' => [
            'text.label',
        ]
    ],


/*
    'admin' => [
        'article.toMany.associated' => ['article'],
        'article.toOne.author' => ['artist'],

        'representation.toOne.event' => ['event'], //reverse  => event.toMany.representations
        'event.toMany.representations' => ['representation'], //reverse  => representation.toOne.event
    ],
*/
/*

    'templates' => [
        'article--light' => [
            'text.title',
            'text.content',

            'related.associated.title',
            'related.author.fullname'
        ]
    ],*/
];
