<?php

defined('TYPO3_MODE') || die('Access denied.');

call_user_func(function () {
    $GLOBALS['TYPO3_CONF_VARS']['EXT']['EXTCONF']['singleview']
        = array_replace_recursive(
        !empty($GLOBALS['TYPO3_CONF_VARS']['EXT']['EXTCONF']['singleview'])
            ? $GLOBALS['TYPO3_CONF_VARS']['EXT']['EXTCONF']['singleview'] : [],
        // default config
        [
            'hashBaseCustomization' => [
                'enabled' => true,
            ],
        ]
    );

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['createHashBase']['singleview'] =
        \SourceBroker\Singleview\Hooks\SingleViewPagePathLogic::class . '->init';

    if ($GLOBALS['TYPO3_CONF_VARS']['EXT']['EXTCONF']['singleview']['hashBaseCustomization']['enabled']) {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['createHashBase']['singleview_hashBaseCustomization'] =
            \SourceBroker\Singleview\Hooks\HashBase::class . '->init';
    }
});
