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

use Magestat\LogWebapi\Api\LoggerInterface;
use Magestat\LogWebapi\Helper\Data as Helper;

class Logger implements LoggerInterface
{
    /**
     * @var \Magestat\LogWebapi\Helper\Data
     */
    protected $helper;

    /**
     * @param Helper $helper
     */
    public function __construct(
        Helper $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnable()
    {
        // Check if module is enable.
        return $this->helper->isActive();
    }
    
    /**
     * {@inheritdoc}
     */
    public function writer()
    {
        $directory = $this->helper->directory();

        if (!file_exists(BP . $directory)) {
            mkdir(BP . $directory, 0777, true);
        }
        $writer = new \Zend\Log\Writer\Stream(BP . $directory . 'connextion.log');

        return $writer;
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $writer = $this->writer();
        $logger = new \Zend\Log\Logger();

        $logger->addWriter($writer);

        return $logger;
    }
}
