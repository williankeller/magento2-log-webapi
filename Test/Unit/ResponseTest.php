<?php

namespace Magestat\LogWebapi\Test\Unit;

/**
 * Class ResponseTest
 * Tests to the response data.
 */
class ResponseTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Response
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
