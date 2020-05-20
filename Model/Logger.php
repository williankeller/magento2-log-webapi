<?php

namespace Magestat\LogWebapi\Model;

use Magento\Framework\Exception\ValidatorException;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\HTTP\PhpEnvironment\Request as HttpRequest;
use Magento\Framework\Webapi\Rest\Request\Deserializer\Xml;
use Magestat\LogWebapi\Api\LoggerInterface;
use Magestat\LogWebapi\Api\Handler\LogFileInterface;
use Magestat\LogWebapi\Helper\Data as Helper;

/**
 * Class Logger
 * Get log data and create structure to be saved.
 */
class Logger implements LoggerInterface
{
    const MIME_TYPE_JSON = 'json';
    const MIME_TYPE_XML  = 'xml';

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
     * Parses request content mime type.
     *
     * @return string
     * @throws ValidatorException
     */
    private function parseMimeType()
    {
        $contentMimeType = $this->header->getHeader('Content-Type');

        if (in_array($contentMimeType, ['application/json', 'application/xml'])) {
            return explode('/', $contentMimeType)[1];
        }

        throw new ValidatorException(
            __('Unsupported MIME type provided = %1', $contentMimeType)
        );
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
        try {
            $mimeType = $this->parseMimeType();
        } catch (ValidatorException $e) {
            return $this;
        }

        // Build contend data.
        $data = [
            'REQUEST:' => [
                'method'  => $this->header->getMethod(),
                'uri'     => $this->header->getRequestUri(),
                'headers' => (array) $this->header->getHeaders()->toArray(),
                'body'    => (array) $this->unserialize($this->header->getContent(), $mimeType)
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
            if (\in_array((string) $key, $needleKey)) {
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
     * @param string $mimeType
     *
     * @return array|string|null
     */
    private function unserialize($content, $mimeType = self::MIME_TYPE_JSON)
    {
        if (!empty($content) && $mimeType == self::MIME_TYPE_JSON) {
            return $this->serializer->unserialize($content);
        }

        return $content;
    }
}
