<?php

namespace SourceBroker\Singleview\Hooks;

use SourceBroker\Singleview\Service\SingleViewService;

/**
 * Class HashBase
 *
 * @package SourceBroker\Singleview\Hooks
 */
class HashBase
{
    /**
     * @param $params
     *
     * @return void
     */
    public function init(&$params)
    {
        $activeSingleViewConfig = SingleViewService::getFirstActiveSingleViewConfig();

        if (empty($activeSingleViewConfig)) {
            return;
        }

        $params['hashParameters']['singleview'] = ['content_from_pid' => $activeSingleViewConfig->getSinglePid()];

        $customHashBasePart = $activeSingleViewConfig->getHashBase();
        if ($customHashBasePart) {
            $params['hashParameters']['singleview']['custom'] = $customHashBasePart;
        }
    }

}
