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
            'relationOne.category',
            'relationMany.categories'
        ],

        'artist' => [
            'text.fullname',
            'text.bio',

            'relationMany.articles',
            'relationOne.mainArticle'
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
            'type' => 'artist', 
            'reverse' => 'relationOne.mainArticle'
        ]

    ],


    'templates' => [
        'article' => [
            'text.title',
            'text.content',
            'number.score',

            'relationOne.author.text.fullname',
            'relationOne.author.text.bio',

            'relationOne.category.text.label',
            
            'relationOne.author.relationOne.mainArticle.text.title', 
            'relationOne.author.relationOne.mainArticle.relationOne.author.text.fullname', 
            'relationOne.author.relationOne.mainArticle.relationOne.author.text.bio', 
            
            'relationOne.author.relationOne.mainArticle.relationMany.categories.text.label', 

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
