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

            'relationOne.author',
            'relationOne.category'
        ],

        'artist' => [
            'text.fullname',
            'text.bio',

            'relationMany.articles'
        ],

        'category' => [
            'text.label',

            'relationMany.articles'
        ]
    ],


    'templates' => [
        'article' => [
            'text.title',
            'text.content',

            'relationOne.author.text.fullname',
            'relationOne.category.text.label'
        ],

        'article--detail' => [
            'text.title',
            'text.content',

            'relationOne.author.text.fullname',
            'relationOne.author.text.bio',

            'relationOne.category.text.label'
        ],

        'artist' => [
            'text.fullname',
            'text.bio',

            'relationMany.articles.text.title'
        ],

        'category' => [
            'text.label',

            'relationMany.articles.text.title'
        ]
    ]

/*
    'admin' => [
        'article.toMany.associated' => ['article'],
        'article.toOne.author' => ['artist'],

        'representation.toOne.event' => ['event'], //reverse  => event.toMany.representations
        'event.toMany.representations' => ['representation'], //reverse  => representation.toOne.event
    ],
*/

];
