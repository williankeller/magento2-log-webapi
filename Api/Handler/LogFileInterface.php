<?php

/**
 * Log Webapi: Module provides log in file for all transactions in Web API.
 * Copyright (C) Magestat
 *
 * This file included in Magestat/LogWebapi is licensed under OSL 3.0
 *
 * http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * Please see LICENSE.txt for the full text of the OSL 3.0 license
 */

namespace Magestat\LogWebapi\Api\Handler;

/**
 * Interface LogFileInterface
 * @api
 */
interface LogFileInterface
{
    /**
     * Define path permission that will be created.
     *
     * @var int
     */
    const PERMISSION = 0775;

    /**
     * Define file extension.
     *
     * @var string
     */
    const FILE_EXT = '.log';

    /**
     * Define a default file name.
     *
     * @var string
     */
    const FILE_NAME = 'webapi';

    /**
     * Define a date format to file name.
     *
     * @var string
     */
    const FILE_FORMAT = 'Y-m-d';

    /**
     * Build log content to a file.
     *
     * @param $content string
     * @return void
     * @throws LocalizedException
     */
    public function write($content);

    /**
     * Create directory to build log file.
     *
     * @return string $directory
     */
    public function createDirectory();

    /**
     * Return file type name with extension.
     *
     * @return string
     */
    public function createFileName();

    /**
     * @return string
     */
    public function buildFileName();
}
