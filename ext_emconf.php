<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Singleview',
    'description' => 'Allows to display single view on the same page as list view in order to keep urls user and SEO friendly',
    'category' => 'plugin',
    'author' => 'SourceBroker Team',
    'author_email' => 'office@sourcebroker.net',
    'author_company' => 'SourceBroker',
    'state' => 'stable',
    'internal' => '',
    'uploadFolder' => false,
    'createDirs' => '',
    'clearCacheOnLoad' => true,
    'version' => '1.2.0',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-8.7.999',
            'php' => '7.0-7.2'
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
