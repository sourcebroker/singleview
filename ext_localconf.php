<?php

defined('TYPO3_MODE') || die('Access denied.');

$boot = function () {
    $defaultConfiguration = [
        'hashBaseCustomization' => [
            // Turn on/off hash base customization for single page
            'enabled' => (\TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version) < 8005000),
        ],
    ];

    $GLOBALS['TYPO3_CONF_VARS']['EXT']['EXTCONF']['singleview']
        = array_replace_recursive(
        !empty($GLOBALS['TYPO3_CONF_VARS']['EXT']['EXTCONF']['singleview'])
            ? $GLOBALS['TYPO3_CONF_VARS']['EXT']['EXTCONF']['singleview'] : [],
        $defaultConfiguration
    );

    $singleViewConf = $GLOBALS['TYPO3_CONF_VARS']['EXT']['EXTCONF']['singleview'];

    if ($singleViewConf['hashBaseCustomization']['enabled']) {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['createHashBase']['singleview_hashBaseCustomization'] =
            \SourceBroker\Singleview\Hooks\HashBase::class . '->init';
    }

    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['tslib/class.tslib_fe.php']['configArrayPostProc'][] =
        \SourceBroker\Singleview\Hooks\SingleViewPagePathLogic::class . '->init';
};

$boot();
unset($boot);
