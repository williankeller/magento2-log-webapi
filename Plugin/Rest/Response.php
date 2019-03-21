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

namespace Magestat\LogWebapi\Plugin\Rest;

use Magento\Framework\Webapi\Rest\Response as RestResponse;
use Magestat\LogWebapi\Api\LoggerInterface;

/**
 * Class Response
 * Intercept front controller for WebAPI REST area.
 * @package Magestat\LogWebapi\Plugin\Rest
 */
class Response
{
    /**
     * @var \Magestat\LogWebapi\Api\LoggerInterface
     */
    private $logger;

    /**
     * @var array
     */
    private $currentRequest;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     *
     * @param RestResponse $subject
     * @param array $outputData
     */
    public function beforePrepareResponse(RestResponse $subject, $outputData)
    {
        $this->logger->write($outputData);
    }
}
