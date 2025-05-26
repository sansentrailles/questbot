<?php

declare(strict_types=1);

namespace app\custom\helpers;

class YoutubeHelper
{
    public const URL = 'https://youtube.com';

    public const TYPE_PLAIN = 1;
    public const TYPE_EMBED = 2;
    public const TYPE_SHORT = 3;

    private $url;
    private $videoId;
    private $parts;
    private $query;

    private $linkType;

    public function __construct($url)
    {
        $this->url = $url;
        $this->init();
    }

    public function getVideoId()
    {
        if ($this->linkType === static::TYPE_SHORT) {
            return $this->getIdFromShortlink();
        }

        if ($this->linkType === static::TYPE_PLAIN) {
            return $this->getIdFromLink();
        }

        if ($this->linkType === static::TYPE_EMBED) {
            return $this->getIdFromEmbeddedLink();
        }
    }

    public function getIdFromEmbeddedLink()
    {
        $urlParts = explode('/', $this->parts['path']);
        return end($urlParts);
    }

    public function getIdFromLink()
    {
        return $this->query['v'];
    }

    public function getEmbedLink()
    {
        if ($this->linkType === static::TYPE_EMBED) {
            return $this->url;
        }
        if ($this->linkType === static::TYPE_SHORT) {
            return $this->getEmbedLinkFromShort();
        }
        if ($this->linkType === static::TYPE_PLAIN) {
            return $this->getEmbedLinkFromPlain();
        }
    }

    private function init(): void
    {
        $this->parts = parse_url($this->url);
        if (isset($this->parts['query'])) {
            parse_str($this->parts['query'], $this->query);
        }
        $this->setLinkType();
    }

    private function setLinkType(): void
    {
        if (isset($this->parts['host']) && $this->parts['host'] === 'youtu.be') {
            $this->linkType = static::TYPE_SHORT;
        }

        if ($this->parts['path'] === '/watch') {
            $this->linkType = static::TYPE_PLAIN;
        }

        if (str_contains($this->parts['path'], '/embed')) {
            $this->linkType = static::TYPE_EMBED;
        }
    }

    private function getIdFromShortLink()
    {
        $path = $this->parts['path'];
        return substr($path, 1, mb_strlen($path) - 1);
    }

    private function getEmbedLinkFromShort()
    {
        $url = static::URL . '/embed/' . $this->parts['path'];
        if (isset($this->parts['t'])) {
            $url .= '?start=' . $this->parts['t'];
        }

        return $url;
    }

    private function getEmbedLinkFromPlain()
    {
        $url = static::URL . '/embed/' . $this->query['v'];
        if (isset($this->query['t'])) {
            $url .= '?start=' . $this->query['t'];
        }

        return $url;
    }
}
