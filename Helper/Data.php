<?php

/**
 * Log Webapi: Module provides log in file for all transactions in Web API.
 * Copyright (C) 2018 Magestat
 *
 * This file included in Magestat/LogWebapi is licensed under OSL 3.0
 *
 * http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * Please see LICENSE.txt for the full text of the OSL 3.0 license
 */

namespace Magestat\LogWebapi\Helper;

use Magento\Store\Model\ScopeInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Check if module is active.
     *
     * @param null $storeId
     * @return bool
     */
    public function isActive($storeId = null)
    {
        return (bool) $this->getConfig(
            'magestat_logwebapi/module/enabled', $storeId
        );
    }

    /**
     * Check if module is active.
     *
     * @param null $storeId
     * @return bool
     */
    public function directory($storeId = null)
    {
        return $this->getConfig(
            'magestat_logwebapi/settings/directory', $storeId
        );
    }

    /**
     * Check if module is active.
     *
     * @param null $storeId
     * @return bool
     */
    public function format($storeId = null)
    {
        return $this->getConfig(
            'magestat_logwebapi/settings/format', $storeId
        );
    }

    /**
     * Return store configuration value.
     *
     * @param string $path
     * @param int $storeId
     * @return mixed
     */
    public function getConfig($path, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $path, ScopeInterface::SCOPE_STORE, $storeId
        );
    }
}
