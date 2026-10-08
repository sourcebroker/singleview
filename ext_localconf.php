<?php

declare(strict_types=1);

defined('TYPO3') or die();

call_user_func(static function () {
    $GLOBALS['TYPO3_CONF_VARS']['EXT']['EXTCONF']['singleview']
        = array_replace_recursive(
            [
                // default config
                'hashBaseCustomization' => [
                    'enabled' => true,
                ],
            ],
            $GLOBALS['TYPO3_CONF_VARS']['EXT']['EXTCONF']['singleview'] ?? []
        );
});
