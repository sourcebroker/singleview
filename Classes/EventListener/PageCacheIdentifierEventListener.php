<?php

declare(strict_types=1);

namespace SourceBroker\Singleview\EventListener;

use SourceBroker\Singleview\Service\SingleViewService;
use TYPO3\CMS\Frontend\Event\BeforePageCacheIdentifierIsHashedEvent;

/**
 * Makes the page cache of list view and single view different.
 */
class PageCacheIdentifierEventListener
{
    public function __invoke(BeforePageCacheIdentifierIsHashedEvent $event): void
    {
        if (!($GLOBALS['TYPO3_CONF_VARS']['EXT']['EXTCONF']['singleview']['hashBaseCustomization']['enabled'] ?? true)) {
            return;
        }

        $pageInformation = $event->getRequest()->getAttribute('frontend.page.information');
        if ($pageInformation === null) {
            return;
        }

        $singleView = SingleViewService::getFirstActiveSingleViewConfig($pageInformation->getId(), $event->getRequest());
        if ($singleView === null) {
            return;
        }

        $hashParameters = ['content_from_pid' => $singleView->getSinglePid()];
        $customHashBasePart = $singleView->getHashBase($event->getRequest());
        if ($customHashBasePart) {
            $hashParameters['custom'] = $customHashBasePart;
        }

        $parameters = $event->getPageCacheIdentifierParameters();
        $parameters['singleview'] = $hashParameters;
        $event->setPageCacheIdentifierParameters($parameters);
    }
}
