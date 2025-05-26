<?php

declare(strict_types=1);

namespace app\modules\seo\widgets\frontend\seo;

use app\modules\seo\models\Seo;
use app\modules\seo\services\SeoService;
use yii\base\InvalidConfigException;
use yii\base\Widget;

/**
 * Displays SEO.
 *
 * @author Chistyakov Ilya <ichistyakovv@gmail.com>
 */
class SeoWidget extends Widget
{
    public $refId = 0;
    public $section = '';
    public $view;
    public $default = [];
    private $seoService;

    private $title;
    private $description;
    private $keywords;
    private $text;

    public function __construct(SeoService $seoService, $config = [])
    {
        $this->seoService = $seoService;
        parent::__construct($config);
    }

    public function init(): void
    {
        parent::init();

        if (!$this->view) {
            throw new InvalidConfigException('The view is a required parameter');
        }
    }

    public function run()
    {
        $seo = $this->seoService->getSeo($this->refId, $this->section);
        $this->load($seo);

        if ($this->title) {
            $this->view->title = $this->title;
        }

        if ($this->description) {
            $this->view->registerMetaTag([
                'name' => 'description',
                'content' => $this->description,
            ]);
        }

        if ($this->keywords) {
            $this->view->registerMetaTag([
                'name' => 'keywords',
                'content' => $this->keywords,
            ]);
        }

        // return $this->text ? $this->text : '';
        return $this->render('seo_text', [
            'seoText' => $this->text,
        ]);
    }

    private function load($seo): void
    {
        if (!$seo) {
            $this->loadDefault();
        } else {
            $this->loadFromDbOrDefault($seo);
        }
    }

    private function loadFromDbOrDefault($seo): void
    {
        if ($seo->title) {
            $this->title = $seo->title;
        } elseif (isset($this->default['title'])) {
            $this->title = $this->default['title'];
        }

        if ($seo->description) {
            $this->description = $seo->description;
        } elseif (isset($this->default['description'])) {
            $this->description = $this->default['description'];
        }

        if ($seo->keywords) {
            $this->keywords = $seo->keywords;
        } elseif (isset($this->default['keywords'])) {
            $this->keywords = $this->default['keywords'];
        }

        if ($seo->text) {
            $this->text = $seo->text;
        }
    }

    private function loadDefault(): void
    {
        if (isset($this->default['title'])) {
            $this->title = $this->default['title'];
        }

        if (isset($this->default['description'])) {
            $this->description = $this->default['description'];
        }

        if (isset($this->default['keywords'])) {
            $this->keywords = $this->default['keywords'];
        }

        if (isset($this->default['text'])) {
            $this->text = $this->default['text'];
        }
    }
}
