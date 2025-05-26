<?php

declare(strict_types=1);

namespace app\modules\seo\forms\backend;

use app\modules\seo\models\City;
use app\modules\seo\models\traits\CityAttributeLabelsTrait;
use yii\base\Model;

class CityForm extends Model
{
    use CityAttributeLabelsTrait;

    public $id;
    public $title;
    public $code;
    public $is_visible;
    public $is_default;
    public $masks;
    public $masks_titles;
    public $masks_forms;

    private $city;

    public function __construct(City $city = null, $config = [])
    {
        $this->city = $city;
        parent::__construct($config);
    }

    public function init(): void
    {
        if (!$this->city) {
            return;
        }

        $this->id         = $this->city->id;
        $this->title      = $this->city->title;
        $this->code       = $this->city->code;
        $this->is_visible = $this->city->is_visible;
        $this->is_default = $this->city->is_default;
        $this->masks      = $this->city->masks ? json_decode($this->city->masks) : [];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_visible', 'is_default'], 'integer'],
            [['title', 'code'], 'string', 'max' => 255],
            [['title', 'code'], 'required', 'message' => 'Заполните поля'],
            [['masks_titles', 'masks_forms'], 'each', 'rule' => ['string']],
            [['masks'], 'safe'],
        ];
    }

    public function isAttributeChanged($attr)
    {
        if ($this->city) {
            return $this->city->isAttributeChanged($attr);
        }

        return false;
    }

    public function getIsNewRecord()
    {
        if ($this->city) {
            return false;
        }

        return true;
    }

    public function getCity()
    {
        if ($this->city === null) {
            $this->city = new City();
        }

        return $this->city;
    }
}
