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

namespace Magestat\LogWebapi\Test\Unit;

/**
 * Class ResponseTest
 * @package Magestat\LogWebapi\Test\Unit
 */
class ResponseTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Response object.
     *
     * @var \Magento\Framework\Webapi\Response
     */
    private $_response;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        /** Initialize SUT. */
        $this->_response = new \Magento\Framework\Webapi\Response();
        parent::setUp();
    }

    /**
     * @inheritdoc
     */
    protected function tearDown()
    {
        unset($this->_response);
        parent::tearDown();
    }

    /**
     * Test addMessage, hasMessage, getMessage, and clearMessages methods.
     */
    public function testMessagesCrud()
    {
        /** Test that new object does not contain any messages. */
        $this->assertFalse($this->_response->hasMessages(), 'New object contains messages.');

        /** Test message adding functionality. */
        $this->_response->addMessage(
            'Message text',
            \Magento\Framework\Webapi\Response::HTTP_OK,
            ['key' => 'value'],
            \Magento\Framework\Webapi\Response::MESSAGE_TYPE_SUCCESS
        );
        $this->assertTrue($this->_response->hasMessages(), 'New message is not added correctly.');

        /** Test message getting functionality. */
        $expectedMessage = [
            \Magento\Framework\Webapi\Response::MESSAGE_TYPE_SUCCESS => [
                [
                    'key' => 'value',
                    'message' => 'Message text',
                    'code' => \Magento\Framework\Webapi\Response::HTTP_OK,
                ],
            ],
        ];
        $this->assertEquals($expectedMessage, $this->_response->getMessages(), 'Message is got incorrectly.');

        /** Test message clearing functionality. */
        $this->_response->clearMessages();
        $this->assertFalse($this->_response->hasMessages(), 'Message is not cleared.');
    }
}
