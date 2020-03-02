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

    'constraints' => [

        'article.text.content' => [
            'style' => 'rich'
        ],

        'article.relationOne.author' => [
            'type' => 'category', 
            'reverse' => 'relationMany.articles'
        ]

        /*
        'article' => [
            'text.content' => [
                'style' => 'rich'
            ],

            'relationOne.author' => [
                'type' => 'category', 
                'reverse' => 'relationMany.articles'
            ]
        ]*/
        
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


];
