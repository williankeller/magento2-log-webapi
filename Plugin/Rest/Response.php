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

use Magestat\LogWebapi\Api\LoggerInterface;

/**
 * Intercept front controller for WebAPI REST area.
 */
class Response
{
    /**
     * @var \Magestat\LogWebapi\Api\LoggerInterface
     */
    protected $logger;

    /**
     * @var array
     */
    protected $currentRequest;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    public function afterSendResponse(
        \Magento\Framework\Webapi\Rest\Response $subject, $result
    ) {
        $this->logger->create()->info('teste 2');
        
        return $result;
    }
}
