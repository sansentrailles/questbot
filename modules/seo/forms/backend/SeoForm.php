<?php

declare(strict_types=1);

namespace app\modules\seo\forms\backend;

use app\modules\seo\models\Seo;
use app\modules\seo\models\traits\SeoAttributeLabelsTrait;
use yii\base\Model;

class SeoForm extends Model
{
    use SeoAttributeLabelsTrait;

    public $id;
    public $title;
    public $keywords;
    public $description;
    public $text;
    public $ref_id;
    public $section;

    private $seo;

    public function __construct(Seo $seo = null, $config = [])
    {
        $this->seo = $seo;
        parent::__construct($config);
    }

    public function init(): void
    {
        if (!$this->seo) {
            return;
        }

        $this->id          = $this->seo->id;
        $this->ref_id      = $this->seo->ref_id;
        $this->section     = $this->seo->section;
        $this->title       = $this->seo->title;
        $this->description = $this->seo->description;
        $this->keywords    = $this->seo->keywords;
        $this->text        = $this->seo->text;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ref_id', 'section'], 'required'],
            [['ref_id'], 'integer'],
            [['text'], 'string'],
            [['title', 'keywords', 'description', 'section'], 'string', 'max' => 255],
        ];
    }

    public function isAttributeChanged($attr)
    {
        if ($this->seo) {
            return $this->seo->isAttributeChanged($attr);
        }

        return false;
    }

    public function getIsNewRecord()
    {
        if ($this->seo) {
            return false;
        }

        return true;
    }

    public function getSeo()
    {
        if ($this->seo === null) {
            $this->seo = new Seo();
        }

        return $this->seo;
    }

    public function setIdentifiers($section, $refId): void
    {
        $this->section = $section;
        $this->ref_id = $refId;
    }
}
