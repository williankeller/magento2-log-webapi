<?php

namespace Magestat\LogWebapi\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * Get configuration from the admin
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
        return $this->scopeConfig->isSetFlag(
            'magestat_logwebapi/module/enabled',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Directory path to save log file.
     *
     * @param null $storeId
     * @return string
     */
    public function directory($storeId = null)
    {
        return $this->scopeConfig->getValue(
            'magestat_logwebapi/settings/directory',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Attributes to be removed from log.
     *
     * @param null $storeId
     * @return string
     */
    public function filters($storeId = null)
    {
        return $this->scopeConfig->getValue(
            'magestat_logwebapi/settings/filter',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * What kind of format should be created.
     *
     * @param null $storeId
     * @return string
     */
    public function format($storeId = null)
    {
        return $this->scopeConfig->getValue(
            'magestat_logwebapi/settings/format',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Return if should print as pretty format.
     *
     * @param null $storeId
     * @return bool
     */
    public function printing($storeId = null)
    {
        return $this->scopeConfig->getValue(
            'magestat_logwebapi/settings/printing',
            ScopeInterface::SCOPE_STORE,
            $storeId
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
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE, $storeId);
    }
}
