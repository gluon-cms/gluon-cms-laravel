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

        'show' => [
            'text.title',
            'text.header'
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

        'page' => [
            'text.title',
            'text.content',

            'number.score',

            'flag.active',

            'relationOne.author',
            'relationMany.categories'
        ],

        'webconfig' => [
            'text.mode',
            'text.header',

            'flag.showTickets',
            'flag.showRepresentations',

            'flag.active',
            'relationMany.mainMenu',
            'relationMany.footerMenu'
        ],

        'appconfig' => [
            'text.label',
            'text.edition'
        ],
    ],

    'constraints' => [

        

        'page.text.content' => [
            'style' => 'rich'
        ],

        'page.relationOne.author' => [
            'type' => 'artist', 
            'reverse' => 'relationOne.mainArticle'
        ]

    ],

    'settings' => [
        'page' => [
            'css' => 'separated'
        ],

        'webconfig' => [
            'css' => 'separated'
        ],
    ],


    'templates' => [
        'page' => [
            'text.title',
            'text.content',
            'number.score',

            'relationOne.author.text.fullname',
            'relationOne.author.text.bio',

            'relationMany.categories.text.label',

        ],

        'page--detail' => [
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
        ], 


        'webconfig' => [
            'text.mode',
            'text.header',

            'flag.showTickets',
            'flag.showRepresentations',

            'flag.active',
            'relationMany.mainMenu.text.title',
            'relationMany.footerMenu.text.title'
        ],
    ]


];
