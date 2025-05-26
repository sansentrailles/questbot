<?php

declare(strict_types=1);

namespace app\modules\guide\forms\backend;

use app\modules\guide\models\GuideChapter;
use app\modules\guide\models\traits\GuideChapterAttributeLabelsTrait;
use yii\base\Model;

/**
 * GuideChapterForm is the model behind the guide section form.
 */
class GuideChapterForm extends Model
{
    use GuideChapterAttributeLabelsTrait;

    public $id;
    public $title;
    public $text;
    public $is_visible;

    private $guideChapter;

    public function __construct(GuideChapter $guideChapter = null, $config = [])
    {
        $this->guideChapter = $guideChapter;
        parent::__construct($config);
    }

    public function init(): void
    {
        if (!$this->guideChapter) {
            return;
        }

        $this->id         = $this->guideChapter->id;
        $this->title      = $this->guideChapter->title;
        $this->text       = $this->guideChapter->text;
        $this->is_visible = $this->guideChapter->is_visible;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_visible'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['title', 'text'], 'required'],
            [['text'], 'string'],
        ];
    }

    public function getIsNewRecord()
    {
        if ($this->guideChapter) {
            return false;
        }

        return true;
    }
}
