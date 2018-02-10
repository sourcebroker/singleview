<?php

namespace SourceBroker\Singleview\Hooks;

use SourceBroker\Singleview\Service\SingleViewService;
use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\CMS\Frontend\Page\PageRepository;

/**
 * Class PagePathLogic
 *
 * @package SourceBroker\Singleview\Hooks
 */
class SingleViewPagePathLogic
{

    /**
     * @return void
     */
    public function init()
    {
        $singleView = SingleViewService::getFirstActiveSingleViewConfig();

        if (empty($singleView)) {
            return;
        }

        $singlePageRecord = $this->getPageRecordById($singleView->getSinglePid());

        if (empty($singlePageRecord)) {
            return;
        }

        $this->getTsfe()->page['content_from_pid'] = $singleView->getSinglePid();
        foreach ($singleView->getFields() as $fieldName) {
            if (isset($singlePageRecord[$fieldName])) {
                $this->getTsfe()->page[$fieldName] = $singlePageRecord[$fieldName];
            }
        }
    }

    /**
     * @param int $id
     *
     * @return array|false|null
     */
    private function getPageRecordById(int $id)
    {
        return $this->getDb()->exec_SELECTgetSingleRow(
            '*',
            'pages',
            'uid = ' . $id . ' ' . $this->getPageRepository()->enableFields('pages')
        );
    }

    /**
     * @return TypoScriptFrontendController
     */
    private function getTsfe(): TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }

    /**
     * @return PageRepository
     */
    private function getPageRepository(): PageRepository
    {
        return $this->getTsfe()->sys_page;
    }

    /**
     * @return DatabaseConnection
     */
    private function getDb(): DatabaseConnection
    {
        return $GLOBALS['TYPO3_DB'];
    }
}