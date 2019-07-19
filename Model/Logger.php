<?php

/**
 * Log Webapi: Module provides log in file for all transactions in Web API.
 * Copyright (C) 2018-2019 Magestat
 *
 * This file included in Magestat/LogWebapi is licensed under OSL 3.0
 *
 * http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * Please see LICENSE.txt for the full text of the OSL 3.0 license
 */

namespace Magestat\LogWebapi\Model;

use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\HTTP\PhpEnvironment\Request as HttpRequest;

use Magestat\LogWebapi\Api\LoggerInterface;
use Magestat\LogWebapi\Api\Handler\LogFileInterface;
use Magestat\LogWebapi\Helper\Data as Helper;

/**
 * Class Logger
 */
class Logger implements LoggerInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var Request
     */
    private $header;

    /**
     * @var LogFileInterface
     */
    private $file;

    /**
     * @var Data
     */
    private $helper;

    /**
     * Logger constructor.
     * @param SerializerInterface $serializer
     * @param HttpRequest $header
     * @param LogFileInterface $file
     * @param Helper $helper
     */
    public function __construct(
        SerializerInterface $serializer,
        HttpRequest $header,
        LogFileInterface $file,
        Helper $helper
    ) {
        $this->serializer = $serializer;
        $this->header = $header;
        $this->file = $file;
        $this->helper = $helper;
    }

    /**
     * @inheritdoc
     */
    public function isEnable()
    {
        if ($this->helper->isActive() && !empty($this->helper->directory())) {
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function write($content)
    {
        // Build contend data.
        $data = [
            'REQUEST:' => [
                'method'  => $this->header->getMethod(),
                'uri'     => $this->header->getRequestUri(),
                'headers' => (array) $this->header->getHeaders()->toArray(),
                'body'    => (array) $this->unserialize($this->header->getContent())
            ],
            'RESPONSE:' => $content,
        ];
        $filtered = $this->filterContent($data);
        // Update content variable globally.
        $this->file->write($this->buildContent($filtered));

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function filterContent($array)
    {
        if (!$this->helper->filters()) {
            return $array;
        }
        // Retrieve filterable keys.
        $needleKey = \explode(self::SEPARATOR, $this->helper->filters());

        foreach ($array as $key => $value) {
            if (\in_array($key, $needleKey)) {
                unset($array[$key]);
            }
            if (\is_array($value)) {
                $array[$key] = $this->filterContent($value);
            }
        }
        return $array;
    }

    /**
     * @inheritdoc
     */
    public function buildContent($data)
    {
        $content = $this->serializer->serialize($data);

        // Should print content using JSON pretty print format?
        if ($this->helper->printing()) {
            $content = json_encode($data, JSON_PRETTY_PRINT);
        }
        return (string) PHP_EOL . date(self::LOG_DATE_FORMAT) . ' ' . $content;
    }

    /**
     * @param string $content
     * @return array|string|null
     */
    private function unserialize($content)
    {
        if (!empty($content)) {
            return $this->serializer->unserialize($content);
        }
        return $content;
    }
}
