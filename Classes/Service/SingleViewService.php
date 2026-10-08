<?php

declare(strict_types=1);

namespace SourceBroker\Singleview\Service;

use Psr\Http\Message\ServerRequestInterface;
use SourceBroker\Singleview\Domain\Model\SingleViewConfig;

class SingleViewService
{
    /**
     * @var SingleViewConfig[]
     */
    private static array $singleViewConfigs = [];

    /**
     * @param int $listPid
     * @param int $singlePid
     * @param callable|boolean $condition
     * @param string[] $fields
     * @param callable|string|null $hashBase Callable receives current request as first argument.
     */
    public static function registerConfig($listPid, $singlePid, $condition, $fields = [], $hashBase = null): void
    {
        $singleViewConfig = new SingleViewConfig();
        $singleViewConfig->setListPid((int)$listPid);
        $singleViewConfig->setSinglePid((int)$singlePid);
        $singleViewConfig->setCondition($condition);

        if (!empty($fields)) {
            $singleViewConfig->setFields($fields);
        }

        if (!empty($hashBase)) {
            $singleViewConfig->setHashBase($hashBase);
        }

        self::$singleViewConfigs[] = $singleViewConfig;
    }

    public static function getFirstActiveSingleViewConfig(int $currentPageId, ServerRequestInterface $request): ?SingleViewConfig
    {
        foreach (self::$singleViewConfigs as $singleViewConfig) {
            if ($singleViewConfig->getListPid() === $currentPageId && $singleViewConfig->isConditionMatch($request)) {
                return $singleViewConfig;
            }
        }

        return null;
    }
}
