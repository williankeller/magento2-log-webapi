<?php

namespace Magestat\LogWebapi\Plugin\Rest;

use Magento\Framework\Webapi\Rest\Response as RestResponse;
use Magestat\LogWebapi\Api\LoggerInterface;

/**
 * Class Response
 * Interceptor for the front controller for WebAPI REST area.
 */
class Response
{
    /**
     * @var LoggerInterface
     */
    private $logger;

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
     * @see \Magento\Framework\Webapi\Rest\Response::prepareResponse
     */
    // @codingStandardsIgnoreStart
    public function beforePrepareResponse(RestResponse $subject, $outputData)
    {
        // codingStandardsIgnoreEnd
        if ($this->logger->isEnable()) {
            $this->logger->write($outputData);
        }
    }
}
