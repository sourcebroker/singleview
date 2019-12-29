<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Singleview',
    'description' => 'Allows to display single view on different page than list view and still keep urls user and SEO friendly',
    'category' => 'plugin',
    'author' => 'SourceBroker Team',
    'author_email' => 'office@sourcebroker.dev',
    'author_company' => 'SourceBroker',
    'state' => 'stable',
    'internal' => '',
    'uploadFolder' => false,
    'createDirs' => '',
    'clearCacheOnLoad' => true,
    'version' => '1.3.0',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-9.5.999',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
