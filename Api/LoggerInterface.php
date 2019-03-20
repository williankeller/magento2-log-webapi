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

/**
 * Interface LoggerInterface
 * @package Magestat\LogWebapi\Api
 * @api
 */
interface LoggerInterface
{
    /**
     * Define a date format to be write in file log.
     *
     * @var string
     */
    const LOG_DATE_FORMAT = '[Y/m/d H:i:s]';

    /**
     * Separator parameter to be used as filters.
     *
     * @var string
     */
    const SEPARATOR = ',';

    /**
     * Check if module is enabled.
     *
     * @return boolean
     */
    public function isEnable();

    /**
     * Build log structure with request data, response and write it to log file.
     *
     * @param array $response
     * @return $this
     */
    public function write($response);

    /**
     * Method used to remove attributes from a log file.
     *
     * @param array $data
     * @return array
     */
    public function filterContent($data);

    /**
     * Build content to JSON format version and add log date.
     *
     * @param array $data
     * @return string
     */
    public function buildContent($data);
}
