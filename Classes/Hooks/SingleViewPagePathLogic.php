<?php

namespace SourceBroker\Singleview\Hooks;

use SourceBroker\Singleview\Service\SingleViewService;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class SingleViewPagePathLogic
{

    public function init()
    {
        $singleView = SingleViewService::getFirstActiveSingleViewConfig();
        if ($singleView === null) {
            return;
        }

        $tsfe = $this->getTsfe();
        $singlePid = $singleView->getSinglePid();
        $listPid = $singleView->getListPid();

        $singlePageRecord = $this->getPageRecordById($singlePid);
        if ($singlePageRecord == null) {
            return;
        }

        $tsfe->page['content_from_pid'] = $singlePid;

        foreach ($singleView->getFields() as $fieldName) {
            $tsfe->page[$fieldName] = $singlePageRecord[$fieldName] ?? $tsfe->page[$fieldName];
            foreach ($tsfe->tmpl->rootLine as &$pageRecord) {
                if ($pageRecord['uid'] === $listPid) {
                    $pageRecord[$fieldName] = $singlePageRecord[$fieldName] ?? $pageRecord[$fieldName];
                    break;
                }
            }
        }
    }

    private function getPageRecordById($id): ?array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        $row = $queryBuilder->select('*')
            ->from('pages')
            ->where($queryBuilder->expr()->eq('uid',
                $queryBuilder->createNamedParameter($id, \PDO::PARAM_INT)))
            ->execute()
            ->fetch();
        return $row ?? null;
    }

    private function getTsfe(): TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
