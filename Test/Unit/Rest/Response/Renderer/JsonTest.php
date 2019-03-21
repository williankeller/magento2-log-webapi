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

namespace Magestat\LogWebapi\Test\Unit\Rest\Response\Renderer;

/**
 * Class JsonTest
 * @package Magestat\LogWebapi\Test\Unit\Rest\Response\Renderer
 */
class JsonTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\Framework\Webapi\Rest\Response\Renderer\Json
     */
    private $_restJsonRenderer;

    /**
     * @var \Magento\Framework\Json\Encoder
     */
    private $encoderMock;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        /** Prepare mocks and objects for SUT constructor. */
        $this->encoderMock = $this->getMockBuilder(\Magento\Framework\Json\Encoder::class)
            ->disableOriginalConstructor()
            ->setMethods(['encode'])
            ->getMock();
        /** Initialize SUT. */
        $this->_restJsonRenderer = new \Magento\Framework\Webapi\Rest\Response\Renderer\Json($this->encoderMock);
        parent::setUp();
    }

    /**
     * @inheritdoc
     */
    protected function tearDown()
    {
        unset($this->encoderMock);
        unset($this->_restJsonRenderer);
        parent::tearDown();
    }

    /**
     * Test render method.
     */
    public function testRender()
    {
        $arrayToRender = ['key' => 'value'];
        /** Assert that jsonEncode method in mocked helper will run once */
        $this->encoderMock->expects($this->once())->method('encode');
        $this->_restJsonRenderer->render($arrayToRender);
    }

    /**
     * Test GetMimeType method.
     */
    public function testGetMimeType()
    {
        $expectedMimeType = 'application/json';
        $this->assertEquals($expectedMimeType, $this->_restJsonRenderer->getMimeType(), 'Unexpected mime type.');
    }
}

