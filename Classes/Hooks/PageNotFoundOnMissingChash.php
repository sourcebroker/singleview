<?php

namespace SourceBroker\Singleview\Hooks;

use SourceBroker\Singleview\Service\SingleViewService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class PageNotFoundOnMissingChash
 * @package SourceBroker\Singleview\Hooks
 */
class PageNotFoundOnMissingChash
{

    /**
     * @return void
     */
    public function init()
    {
        $activeSingleViewConfig = SingleViewService::getFirstActiveSingleViewConfig();

        if (empty($activeSingleViewConfig)) {
            return;
        }

        if (!$this->cHashExistsInUrl() && $activeSingleViewConfig->isThrowPageNotFoundOnMissingChash()) {
            $GLOBALS['TSFE']->pageNotFoundAndExit();
        }
    }

    /**
     * @return bool
     */
    private function cHashExistsInUrl()
    {
        return !empty(GeneralUtility::_GET()['cHash']);
    }
}
