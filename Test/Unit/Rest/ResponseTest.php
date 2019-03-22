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

namespace Magestat\LogWebapi\Test\Unit\Rest;

use Magento\Framework\Phrase;

/**
 * Class ResponseTest
 * @package Magestat\LogWebapi\Test\Unit\Rest
 */
class ResponseTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Magento\Framework\Webapi\Rest\Response
     */
    private $responseRest;

    /**
     * @var \Magento\Framework\App\State
     */
    private $appStateMock;

    /**
     * @var \Magento\Framework\Webapi\Rest\Response\Renderer\Xml
     */
    private $rendererMock;

    /**
     * @var \Magento\Framework\Webapi\ErrorProcessor
     */
    private $errorProcessorMock;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        /** Mock all objects required for SUT. */
        $this->rendererMock = $this->getMockBuilder(
            \Magento\Framework\Webapi\Rest\Response\Renderer\Json::class
        )->disableOriginalConstructor()->getMock();
        $rendererFactoryMock = $this->getMockBuilder(
            \Magento\Framework\Webapi\Rest\Response\RendererFactory::class
        )->disableOriginalConstructor()->getMock();
        $rendererFactoryMock->expects($this->any())->method('get')->will($this->returnValue($this->rendererMock));
        $this->errorProcessorMock = $this->getMockBuilder(\Magento\Framework\Webapi\ErrorProcessor::class)
            ->disableOriginalConstructor()->getMock();
        $this->appStateMock = $this->createMock(\Magento\Framework\App\State::class);

        /** Init SUP. */
        $this->responseRest = new \Magento\Framework\Webapi\Rest\Response(
            $rendererFactoryMock,
            $this->errorProcessorMock,
            $this->appStateMock
        );
    }

    /**
     * @inheritdoc
     */
    protected function tearDown()
    {
        unset(
            $this->responseRest,
            $this->appStateMock,
            $this->appStateMock,
            $this->rendererMock,
            $this->errorProcessorMock
        );
    }

    /**
     * Test setException method with \Magento\Framework\Webapi\Exception.
     */
    public function testSetWebapiExceptionException()
    {
        /** Init \Magento\Framework\Webapi\Exception */
        $apiException = new \Magento\Framework\Webapi\Exception(
            new Phrase('Exception message.'),
            0,
            \Magento\Framework\Webapi\Exception::HTTP_UNAUTHORIZED
        );
        $this->responseRest->setException($apiException);
        /** Assert that \Magento\Framework\Webapi\Exception was set and presented in the list. */
        $this->assertTrue(
            $this->responseRest->hasExceptionOfType(\Magento\Framework\Webapi\Exception::class),
            'Magento\Framework\Webapi\Exception was not set.'
        );
    }

    /**
     * Test sendResponse method with internal error exception during messages rendering.
     */
    public function testSendResponseRenderMessagesException()
    {
        /** Init logic exception. */
        $logicException = new \LogicException();
        /** Mock error processor to throw \LogicException in maskException method. */
        $this->errorProcessorMock->expects(
            $this->any()
        )->method(
            'maskException'
        )->will(
            $this->throwException($logicException)
        );
        /** Assert that renderException method will be executed once with specified parameters. */
        $this->errorProcessorMock->expects(
            $this->once()
        )->method(
            'renderException'
        )->with(
            $logicException,
            \Magento\Framework\Webapi\Exception::HTTP_INTERNAL_ERROR
        );
        /** Set exception to Rest response to get in to the _renderMessages method. */
        $this->responseRest->setException(new \Magento\Framework\Webapi\Exception(new Phrase('Message.')));
        $this->responseRest->sendResponse();
    }

    /**
     * Test sendResponse method with HTTP Not Acceptable error exception during messages rendering.
     */
    public function testSendResponseRenderMessagesHttpNotAcceptable()
    {
        $exception = new \Magento\Framework\Webapi\Exception(
            new Phrase('Message'),
            0,
            \Magento\Framework\Webapi\Exception::HTTP_NOT_ACCEPTABLE
        );
        /** Mock error processor to throw \LogicException in maskException method. */
        $this->errorProcessorMock->expects(
            $this->any()
        )->method(
            'maskException'
        )->will(
            $this->throwException($exception)
        );
        /** Assert that renderException method will be executed once with specified parameters. */
        $this->errorProcessorMock->expects(
            $this->once()
        )->method(
            'renderException'
        )->with(
            $exception,
            \Magento\Framework\Webapi\Exception::HTTP_NOT_ACCEPTABLE
        );
        /** Set exception to Rest response to get in to the _renderMessages method. */
        $this->responseRest->setException(
            new \Magento\Framework\Webapi\Exception(
                new Phrase('Message.'),
                0,
                \Magento\Framework\Webapi\Exception::HTTP_BAD_REQUEST
            )
        );
        $this->responseRest->sendResponse();
    }

    /**
     * Test sendResponse method with exception rendering.
     */
    public function testSendResponseWithException()
    {
        /** Mock all required objects. */
        $this->rendererMock->expects(
            $this->any()
        )->method(
            'getMimeType'
        )->will(
            $this->returnValue('application/json')
        );
        $this->rendererMock->expects(
            $this->any()
        )->method(
            'render'
        )->will(
            $this->returnCallback([$this, 'callbackForSendResponseTest'], $this->returnArgument(0))
        );
        $exceptionMessage = 'Message';
        $exceptionHttpCode = \Magento\Framework\Webapi\Exception::HTTP_BAD_REQUEST;
        $exception = new \Magento\Framework\Webapi\Exception(new Phrase($exceptionMessage), 0, $exceptionHttpCode);
        $this->errorProcessorMock->expects(
            $this->any()
        )->method(
            'maskException'
        )->will(
            $this->returnValue($exception)
        );

        $this->responseRest->setException($exception);
        /** Start output buffering. */
        ob_start();
        $this->responseRest->sendResponse();
        /** Clear output buffering. */
        ob_end_clean();
        $actualResponse = $this->responseRest->getBody();
        $expectedResult = '{"message":"' .
            $exceptionMessage .
            '"}';
        $this->assertStringStartsWith($expectedResult, $actualResponse, 'Response body is invalid');
    }

    /**
     * Callback for testSendResponseRenderMessages method.
     *
     * @param $data
     * @return string
     */
    public function callbackForSendResponseTest($data)
    {
        return json_encode($data);
    }

    /**
     * Test sendResponse method without any exception
     */
    public function testSendResponseSuccessHandling()
    {
        $this->responseRest->sendResponse();
        $this->assertTrue($this->responseRest->getHttpResponseCode() == \Magento\Framework\Webapi\Response::HTTP_OK);
    }
}