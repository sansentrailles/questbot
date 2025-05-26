<?php

declare(strict_types=1);

namespace app\custom\files;

use app\custom\helpers\StorageFileHelper;

class BaseImageFile extends BaseFile
{
    public const WATERMARK_BOTTOM_RIGHT = 'bottom-right';
    public const WATERMARK_BOTTOM_LEFT = 'bottom-left';
    public const WATERMARK_TOP_LEFT = 'top-left';
    public const WATERMARK_TOP_RIGHT = 'top-right';
    public const WATERMARK_CENTER_CENTER = 'center-center';
    private $width = 100;
    private $height = 100;
    private $quality = 100;

    public function __construct($bucket)
    {
        parent::__construct($bucket);
    }

    public function setSize($width = 0, $height = 0)
    {
        $this->width = $width;
        $this->height = $height;

        return $this;
    }

    public function setQualityValue($quality = 100)
    {
        $this->quality = $quality;
        return $this;
    }

    public function watermark($watermark, $position = self::WATERMARK_BOTTOM_RIGHT, array $offset = [0, 0])
    {
        return StorageFileHelper::watermark($this->getBucket(), $watermark, $position, $offset);
    }

    public function thumbnail()
    {
        return StorageFileHelper::thumbnail($this->width, $this->height, $this->quality, $this->getBucket());
    }

    public function optimize()
    {
        return StorageFileHelper::optimize($this->getBucket());
    }

    /**
     * @param array $options[]
     * Optiona params:
     * quality - percent
     * width
     * height
     * reduceRatio
     */
    public function resize($options)
    {
        return StorageFileHelper::resize($options, $this->getBucket());
    }

    public function setQuality($quality)
    {
        return StorageFileHelper::setQuality($quality, $this->getBucket());
    }
}
