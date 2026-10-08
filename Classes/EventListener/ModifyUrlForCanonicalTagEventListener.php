<?php

declare(strict_types=1);

namespace SourceBroker\Singleview\EventListener;

use SourceBroker\Singleview\Service\SingleViewService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Utility\CanonicalizationUtility;
use TYPO3\CMS\Seo\Event\ModifyUrlForCanonicalTagEvent;

class ModifyUrlForCanonicalTagEventListener
{
    public function __invoke(ModifyUrlForCanonicalTagEvent $event): void
    {
        $currentPageId = $event->getPage()->getPageId();
        $singleViewConfiguration = SingleViewService::getFirstActiveSingleViewConfig($currentPageId, $event->getRequest());

        if (!$singleViewConfiguration) {
            return;
        }

        $request = $event->getRequest();
        $contentObjectRenderer = GeneralUtility::makeInstance(ContentObjectRenderer::class);
        $contentObjectRenderer->setRequest($request);
        $pageType = $request->getAttribute('routing')->getPageType();

        $url = $contentObjectRenderer->typoLink_URL([
            'parameter' => $singleViewConfiguration->getListPid() . ',' . $pageType,
            'forceAbsoluteUrl' => true,
            'addQueryString' => true,
            'addQueryString.' => [
                'method' => 'GET',
                'exclude' => implode(
                    ',',
                    CanonicalizationUtility::getParamsToExcludeForCanonicalizedUrl(
                        $currentPageId,
                        (array)($GLOBALS['TYPO3_CONF_VARS']['FE']['additionalCanonicalizedUrlParameters'] ?? [])
                    )
                ),
            ],
        ]);

        $event->setUrl($url);
    }
}
