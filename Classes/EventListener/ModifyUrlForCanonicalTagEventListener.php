<?php
declare(strict_types=1);

namespace SourceBroker\Singleview\EventListener;

use SourceBroker\Singleview\Service\SingleViewService;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\CMS\Frontend\Utility\CanonicalizationUtility;
use TYPO3\CMS\Seo\Event\ModifyUrlForCanonicalTagEvent;

class ModifyUrlForCanonicalTagEventListener
{
    /**
     * @var TypoScriptFrontendController
     */
    protected $typoScriptFrontendController;

    public function __construct(
        TypoScriptFrontendController $typoScriptFrontendController
    ) {
        $this->typoScriptFrontendController = $typoScriptFrontendController;
    }

    public function __invoke(ModifyUrlForCanonicalTagEvent $event)
    {
        $singleViewConfiguration = SingleViewService::getFirstActiveSingleViewConfig();

        if (!$singleViewConfiguration) {
            return;
        }

        $url = $this->typoScriptFrontendController->cObj->typoLink_URL([
            'parameter' => $singleViewConfiguration->getListPid() . ',' . $this->typoScriptFrontendController->type,
            'forceAbsoluteUrl' => true,
            'addQueryString' => true,
            'addQueryString.' => [
                'method' => 'GET',
                'exclude' => implode(
                    ',',
                    CanonicalizationUtility::getParamsToExcludeForCanonicalizedUrl(
                        (int)$this->typoScriptFrontendController->id,
                        (array)$GLOBALS['TYPO3_CONF_VARS']['FE']['additionalCanonicalizedUrlParameters']
                    )
                )
            ]
        ]);

        $event->setUrl($url);
    }
}
