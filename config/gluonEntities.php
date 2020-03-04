<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Gluon based entities
    |--------------------------------------------------------------------------
    |
    | Here you define your CMS entities, how you want to constraint them and how you
    | want to query them.
    |
    */

    'definitions' => [

        'article' => [
            'text.title',
            'text.content',

            'number.score',

            'relationOne.author',
            'relationMany.categories'
        ],

        'artist' => [
            'text.fullname',
            'text.bio',

            'relationMany.articles'
        ],

        'category' => [
            'text.label',
            'relationMany.articles'
        ],

        'webconfig' => [
            'text.label',
            'text.info'
        ],

        'appconfig' => [
            'text.label',
            'text.edition'
        ],
    ],

    'constraints' => [

        

        'article.text.content' => [
            'style' => 'rich'
        ],

        'article.relationOne.author' => [
            'type' => 'artist', 
            'reverse' => 'relationOne.mainArticle'
        ]

    ],

    'settings' => [
        'article' => [
            'css' => 'important'
        ],

        'webconfig' => [
            'css' => 'separated'
        ],
    ],


    'templates' => [
        'article' => [
            'text.title',
            'text.content',
            'number.score',

            'relationOne.author.text.fullname',
            'relationOne.author.text.bio',

            'relationMany.categories.text.label',

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


];
