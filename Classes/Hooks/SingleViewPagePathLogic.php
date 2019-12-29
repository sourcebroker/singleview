<?php

namespace SourceBroker\Singleview\Hooks;

use SourceBroker\Singleview\Service\SingleViewService;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Class SingleViewPagePathLogic
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
     * @return array|false
     */
    private function getPageRecordById($id)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        $row = $queryBuilder->select('*')
            ->from('pages')
            ->where($queryBuilder->expr()->eq('uid',
                $queryBuilder->createNamedParameter($id, \PDO::PARAM_INT)))
            ->execute()
            ->fetch();
        return $row ?? [];
    }

    /**
     * @return TypoScriptFrontendController
     */
    private function getTsfe() : TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
