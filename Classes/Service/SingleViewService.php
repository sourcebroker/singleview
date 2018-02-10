<?php

namespace SourceBroker\Singleview\Service;

use SourceBroker\Singleview\Domain\Model\SingleViewConfig;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

/**
 * Class SingleViewService
 * @package SourceBroker\Singleview\Service
 */
class SingleViewService
{
    /**
     * @var SingleViewConfig[]
     */
    private static $singleViewConfigs = [];

    /**
     * @param int $listPid
     * @param int $singlePid
     * @param callable|boolean $condition
     * @param string[] $fields
     * @param callable|string $hashBase
     *
     * @return void
     */
    public static function registerConfig($listPid, $singlePid, $condition, $fields = [], $hashBase = null)
    {
        $singleViewConfig = new SingleViewConfig();
        $singleViewConfig->setListPid($listPid);
        $singleViewConfig->setSinglePid($singlePid);
        $singleViewConfig->setCondition($condition);

        if (!empty($fields)) {
            $singleViewConfig->setFields($fields);
        }

        if (!empty($hashBase)) {
            $singleViewConfig->setHashBase($hashBase);
        }

        self::$singleViewConfigs[] = $singleViewConfig;
    }

    /**
     * @return null|SingleViewConfig
     */
    public static function getFirstActiveSingleViewConfig()
    {
        $activeSingleViewConfigs = SingleViewService::getActiveSingleViewConfigs();

        if (empty($activeSingleViewConfigs)) {
            return null;
        }

        return array_shift($activeSingleViewConfigs);
    }

    /**
     * @return SingleViewConfig[]
     */
    private static function getActiveSingleViewConfigs(): array
    {
        return array_filter(
            self::$singleViewConfigs,
            function ($singleViewConfig) {
                /** @var SingleViewConfig $singleViewConfig */
                return self::isCurrentPageId($singleViewConfig->getListPid()) && $singleViewConfig->isConditionMatch();
            }
        );
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    private static function isCurrentPageId(int $id): bool
    {
        return (int)self::getTsfe()->id === $id;
    }

    /**
     * @return TypoScriptFrontendController
     */
    private static function getTsfe(): TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }
}
