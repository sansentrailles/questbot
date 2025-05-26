<?php

declare(strict_types=1);

namespace app\custom\behaviors;

use stdClass;
use yii\db\BaseActiveRecord;

/**
 * JSONConverterBehavior converts data to JSON and vice versa.
 *
 * ```php
 * return [
 *     ...
 *     [
 *         'class' => 'app\helpers\JSONConverterBehavior',
 *         'attributes' => [
 *              'fields'
 *          ], // attributes used to store data as JSON data
 *     ],
 * ];
 * ```
 *
 * @property \yii\base\Model $owner
 * @author Chistyakov Ilya <ichistyakovv@gmail.com>
 */
class JSONConverterBehavior extends \yii\base\Behavior
{
    /**
     * @property array the attributes that will be saved as JSON data
     */
    public $attributes = [];

    /**
     * {@inheritdoc}
     */
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
            BaseActiveRecord::EVENT_AFTER_FIND => 'afterFind',
        ];
    }

    /**
     * Event handler for beforeSave.
     * @param \yii\base\ModelEvent $event
     */
    public function beforeSave($event): void
    {
        foreach ($this->attributes as $attribute) {
            if (!$this->owner->{$attribute} || (!\is_array($this->owner->{$attribute}) && !\is_object($this->owner->{$attribute}))) {
                $this->owner->{$attribute} = new stdClass();
            }

            $this->owner->{$attribute} = json_encode($this->owner->{$attribute});
        }
    }

    /**
     * Event handler for afterFind.
     * @param \yii\base\ModelEvent $event
     */
    public function afterFind($event): void
    {
        foreach ($this->attributes as $attribute) {
            $this->owner->{$attribute} = $this->owner->{$attribute} !== '' ? json_decode($this->owner->{$attribute}, true) : [];
        }
    }
}
