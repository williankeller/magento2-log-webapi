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

namespace Magestat\LogWebapi\Api;

interface LoggerInterface
{
    /**
     * Check if module is enabled.
     *
     * @return boolean
     */
    public function isEnable();

    /**
     * Return if module is enable.
     *
     * @return string|false
     */
    public function writer();

    /**
     * 
     * @param type $param
     */
    public function create();
}
