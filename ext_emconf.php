<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Singleview',
    'description' => 'Allows to display single view on different page than list view and still keep urls user and SEO friendly',
    'category' => 'plugin',
    'author' => 'SourceBroker Team',
    'author_email' => 'office@sourcebroker.net',
    'author_company' => 'SourceBroker',
    'state' => 'stable',
    'internal' => '',
    'uploadFolder' => false,
    'createDirs' => '',
    'clearCacheOnLoad' => true,
    'version' => '1.2.2',
    'constraints' => [
        'depends' => [
            'typo3' => '7.6.0-8.7.999',
            'php' => '5.6-7.2'
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
