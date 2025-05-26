<?php

declare(strict_types=1);

namespace app\custom\widgets\backend\coordsPicker;

use yii\base\Widget;

/**
 * Widget allows to use map for finding the places
 * either by clicking on the map or using search by address.
 * The widget automatically converts the point to spherical coordinates.
 *
 * @author Chistyakov Ilya <ichistyakovv@gmail.com>
 */
class CoordsPicker extends Widget
{
    public $model;
    public $form;
    public $cityName = '';
    public $mapHeight = '400px';
    public $mapColumnSize = 6;
    public $attributesColumnSize = 6;
    public $attributes = ['address', 'latitude', 'longitude'];
    public $attributesMap = [
        // attribute => role
        'address' => 'address',
        'latitude' => 'latitude',
        'longitude' => 'longitude',
    ];
    public $buttonText = 'Search by address';
    public $mapProvider = 'yandex';
    public $enableSearch = true;
    public $options = [
        'lang' => 'en',
    ];
    public $zoom = 13;

    public function init(): void
    {
        parent::init();
    }

    public function run()
    {
        $this->registerAsset();
        $options = [
            'form' => $this->form,
            'model' => $this->model,
            'cityName' => $this->cityName,
            'mapHeight' => $this->mapHeight,
            'attributes' => $this->attributes,
            'mapProvider' => $this->mapProvider,
            'attributesMap' => $this->attributesMap,
            'mapColumnSize' => $this->mapColumnSize,
            'attributesColumnSize' => $this->attributesColumnSize,
            'enableSearch' => $this->enableSearch,
            'buttonText' => $this->buttonText,
            'options' => $this->options,
            'zoom' => $this->zoom,
        ];
        return $this->render('map', $options);
    }

    private function registerAsset(): void
    {
        CoordsPickerAsset::register($this->getView());
    }
}
