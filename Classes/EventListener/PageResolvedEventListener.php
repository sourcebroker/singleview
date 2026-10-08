<?php

declare(strict_types=1);

namespace SourceBroker\Singleview\EventListener;

use SourceBroker\Singleview\Domain\Model\SingleViewConfig;
use SourceBroker\Singleview\Service\SingleViewService;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Event\AfterPageAndLanguageIsResolvedEvent;

/**
 * Sets "content_from_pid" to the single view page and copies configured fields from single view page
 * to the list view page, when single view is active.
 */
class PageResolvedEventListener
{
    public function __invoke(AfterPageAndLanguageIsResolvedEvent $event): void
    {
        $pageInformation = $event->getPageInformation();
        $singleView = SingleViewService::getFirstActiveSingleViewConfig($pageInformation->getId(), $event->getRequest());
        $singlePageRecord = $singleView ? $this->getPageRecordById($singleView->getSinglePid()) : null;
        if ($singlePageRecord === null) {
            return;
        }

        $pageInformation->setContentFromPid($singleView->getSinglePid());
        $pageRecord = $this->applyFields($pageInformation->getPageRecord(), $singlePageRecord, $singleView->getFields());
        $pageRecord['content_from_pid'] = $singleView->getSinglePid();
        $pageInformation->setPageRecord($pageRecord);
        $pageInformation->setRootLine(
            $this->applyFieldsToRootLine($pageInformation->getRootLine(), $singlePageRecord, $singleView)
        );
        $event->setPageInformation($pageInformation);
    }

    private function applyFieldsToRootLine(array $rootLine, array $singlePageRecord, SingleViewConfig $singleView): array
    {
        foreach ($rootLine as $key => $pageRecord) {
            if ((int)($pageRecord['uid'] ?? 0) === $singleView->getListPid()) {
                $rootLine[$key] = $this->applyFields($pageRecord, $singlePageRecord, $singleView->getFields());
                break;
            }
        }

        return $rootLine;
    }

    private function applyFields(array $targetRecord, array $singlePageRecord, array $fields): array
    {
        foreach ($fields as $fieldName) {
            $targetRecord[$fieldName] = $singlePageRecord[$fieldName] ?? $targetRecord[$fieldName] ?? null;
        }

        return $targetRecord;
    }

    private function getPageRecordById(int $id): ?array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        $row = $queryBuilder->select('*')
            ->from('pages')
            ->where($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($id, Connection::PARAM_INT)))
            ->executeQuery()
            ->fetchAssociative();

        return $row ?: null;
    }
}
