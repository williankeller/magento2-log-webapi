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

namespace Magestat\LogWebapi\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\HTTP\PhpEnvironment\Request as RequestHeader;
use Magestat\LogWebapi\Api\LoggerInterface;
use Magestat\LogWebapi\Helper\Data as Helper;

class Logger implements LoggerInterface
{
    /**
     * @var \Magestat\LogWebapi\Helper\Data
     */
    protected $helper;

    /**
     * @var array $content
     */
    protected $content = [];

    /**
     * @param Helper $helper
     */
    public function __construct(
        RequestHeader $header,
        Helper $helper
    ) {
        $this->helper = $helper;
        $this->header = $header;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnable()
    {
        if ($this->helper->isActive() && !empty($this->helper->directory())) {
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function builder($response)
    {
        // Build contend data.
        $data = [
            'REQUEST:' => [
                'method'  => $this->header->getMethod(),
                'uri'     => $this->header->getRequestUri(),
                'headers' => (array) $this->header->getHeaders()->toArray(),
                'body'    => (array) json_decode($this->header->getContent())
            ],
            'RESPONSE:' => $response,
        ];
        $filtered = $this->filterData($data);

        // Update content variable globally.
        $this->content = $this->toContent($filtered);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function filterData($array)
    {
        if (!$this->helper->filters()) {
            return $array;
        }
        // Retrieve filtrable keys.
        $needleKey = explode(self::SEPARATOR, $this->helper->filters());

        foreach ($array as $key => $value) {
            if (in_array($key, $needleKey)) {
                unset($array[$key]);
            }
            if (is_array($value)) {
                $array[$key] = $this->filterData($value);
            }
        }
        return $array;
    }

    /**
     * {@inheritdoc}
     */
    public function toContent($data)
    {
        $content = json_encode($data);

        if (!$this->helper->printing()) {
            // Json pertty print format.
            $content = json_encode($data, JSON_PRETTY_PRINT);
        }
        return (string) PHP_EOL . date(self::LOG_DATE_FORMAT) . ' ' . $content;
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        try {
            file_put_contents($this->directory(), $this->content, FILE_APPEND);
        }
        catch (Exception $exception) {
            throw new LocalizedException(
                __('Unable to write to LogAPI file.'), $exception
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function directory()
    {
        try {
            $folder = BP . $this->helper->directory();

            if (!file_exists($folder)) {
                mkdir($folder, self::PERMISSION, true);
            }
            return $folder . $this->fileType();
        }
        catch (Exception $exception) {
            throw new LocalizedException(
                __('Unable to create LogAPI directory.'), $exception
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function fileType()
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
}
