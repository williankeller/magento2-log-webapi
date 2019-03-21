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

namespace Magestat\LogWebapi\Model\Handler;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem\Driver\File;

use Magestat\LogWebApi\Api\Handler\LogFileInterface;
use Magestat\LogWebapi\Helper\Data as Helper;

/**
 * Class LogFile
 * @package Magestat\LogWebapi\Model
 */
class LogFile implements LogFileInterface
{
    /**
     * @var \Magento\Framework\Filesystem\Driver\File
     */
    private $file;

    /**
     * @var \Magestat\LogWebapi\Helper\Data
     */
    private $helper;

    /**
     * LogFile constructor.
     * @param File $file
     * @param Helper $helper
     */
    public function __construct(
        File $file,
        Helper $helper
    ) {
        $this->file = $file;
        $this->helper = $helper;
    }

    /**
     * @inheritdoc
     */
    public function write($content)
    {
        $this->file->filePutContents($this->buildFileName(), $content, FILE_APPEND);
    }

    /**
     * @inheritdoc
     */
    public function createDirectory()
    {
        $directory = BP . $this->helper->directory();
        $this->file->createDirectory($directory, self::PERMISSION);

        return $directory;
    }

    /**
     * @inheritdoc
     */
    public function createFileName()
    {
        switch ($this->helper->format()) {
            // Build a log file per day with daily data.
            case 1:
                $filename = date(self::FILE_FORMAT);
                break;
            // Build a unique file with all data there.
            case 2:
                $filename = self::FILE_NAME;
                break;
            // Default.
            default:
                $filename = self::FILE_NAME;
                break;
        }
        return $filename . self::FILE_EXT;
    }

    /**
     * @return string
     */
    public function buildFileName()
    {
        $path = [
            $this->createDirectory(),
            $this->createFileName()
        ];
        return \implode('', $path);
    }
}
