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

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * @package Magestat\LogWebapi\Helper
 */
class Data extends AbstractHelper
{
    /**
     * Check if module is active.
     *
     * @param null $storeId
     * @return bool
     */
    public function isActive($storeId = null)
    {
        return (bool) $this->getConfig('magestat_logwebapi/module/enabled', $storeId);
    }

    /**
     * Directory path to save log file.
     *
     * @param null $storeId
     * @return string
     */
    public function directory($storeId = null)
    {
        return $this->getConfig('magestat_logwebapi/settings/directory', $storeId);
    }

    /**
     * Attributes to be removed from log.
     *
     * @param null $storeId
     * @return string
     */
    public function filters($storeId = null)
    {
        return $this->getConfig('magestat_logwebapi/settings/filter', $storeId);
    }

    /**
     * What kind of format should be created.
     *
     * @param null $storeId
     * @return string
     */
    public function format($storeId = null)
    {
        return $this->getConfig('magestat_logwebapi/settings/format', $storeId);
    }

    /**
     * Return if should print as pretty format.
     *
     * @param null $storeId
     * @return bool
     */
    public function printing($storeId = null)
    {
        return (bool) $this->getConfig('magestat_logwebapi/settings/printing', $storeId);
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
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE, $storeId);
    }
}
