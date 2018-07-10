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

use Magento\Webapi\Controller\Rest;
use Magento\Framework\App\RequestInterface;
use Magestat\LogWebapi\Api\LoggerInterface;

/**
 * Intercept front controller for WebAPI REST area.
 */
class Dispatch
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
    ){
        $this->logger = $logger;
    }

    /**
     * 
     * @param Rest $subject
     * @param \Magestat\LogWebapi\Plugin\Rest\callable $proceed
     * @param RequestInterface $request
     * @return type
     */
    public function aroundDispatch(
        Rest $subject, callable $proceed, RequestInterface $request
    ) {
        $this->currentRequest = [
            'method' => $request->getMethod(),
            'uri' => $request->getRequestUri(),
            'headers' => [],
            'request' => json_decode($request->getContent())
        ];

        foreach ($request->getHeaders()->toArray() as $key => $value) {
            $this->currentRequest['headers'][$key] = $value;
        }

        $this->logger->create()->info(json_encode($this->currentRequest));

        return $proceed($request);
    }
}
