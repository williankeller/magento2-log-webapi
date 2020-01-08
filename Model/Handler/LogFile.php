<?php

namespace Magestat\LogWebapi\Model\Handler;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem\Driver\File;
use Magestat\LogWebapi\Api\Handler\LogFileInterface;
use Magestat\LogWebapi\Helper\Data as Helper;

/**
 * Class LogFile
 * Responsible for create the dir, set file name and write the logs.
 */
class LogFile implements LogFileInterface
{
    /**
     * @var File
     */
    private $file;

    /**
     * @var Data
     */
    private $helper;

    /**
     * @param File $file
     * @param Helper $helper
     */
    public function __construct(
        File $file,
        Helper $helper
    ) {
        $this->file = $file;
        $this->helper = $helper;
    }

    /**
     * @inheritdoc
     */
    public function write($content)
    {
        $this->file->filePutContents($this->buildFileName(), $content, FILE_APPEND);
    }

    /**
     * @inheritdoc
     */
    public function createDirectory()
    {
        $directory = BP . $this->helper->directory();
        $this->file->createDirectory($directory, self::PERMISSION);

        return $directory;
    }

    /**
     * @inheritdoc
     */
    public function createFileName()
    {
        switch ($this->helper->format()) {
            // Build a log file per day with daily data.
            case 1:
                $filename = date(self::FILE_FORMAT);
                break;
            // Build a unique file with all data there.
            case 2:
            default:
                $filename = self::FILE_NAME;
                break;
        }
        return $filename . self::FILE_EXT;
    }

    /**
     * @inheritdoc
     */
    public function buildFileName()
    {
        $path = [
            $this->createDirectory(),
            $this->createFileName()
        ];
        return \implode('', $path);
    }
}
