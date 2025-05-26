<?php

declare(strict_types=1);

namespace app\custom\validators;

use app\validators\fake\FakeModel;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\validators\Validator;

/**
 * Validates an array of fields that will be saved in one attribute
 * For each field specified a validators array by field name.
 *
 * ```
 * ['params', 'app\validators\DifferentTypesValidator',
 *    'removeFieldOnError' => false,
 *    'fields' => [
 *        'size' => [
 *            'rules' => [
 *                ['required'], // the order is crucial
 *                ['integer'],
 *            ],
 *        ],
 *        'color' => [
 *            'rules' => [
 *                ['string'],
 *                ['default', 'value' => 'black'],
 *            ],
 *        ],
 *    ],
 * ],
 * ```
 *
 *  @author Chistyakov Ilya <ichistyakovv@gmail.com>
 */
class DifferentTypesValidator extends Validator
{
    public $fields;
    public $allowMessageFromRule = true;
    public $removeFieldOnError = true;

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();

        if (!\is_array($this->fields)) {
            throw new InvalidConfigException('Invalid fields property: the property must be an array.');
        }

        if ($this->message === null) {
            $this->message = Yii::t('yii', '{attribute} is invalid.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validateAttribute($model, $attribute): void
    {
        if (!\is_array($model->{$attribute})) {
            $this->addError($model, $attribute, $this->message, []);
            return;
        }
        // add missed fields to the params array with an empty value
        foreach ($this->fields as $fieldName => $fieldValue) {
            if (!isset($model->{$attribute}[$fieldName])) {
                $model->{$attribute}[$fieldName] = '';
            }
        }

        $filteredValues = [];
        foreach ($model->{$attribute} as $field => $fieldValue) {
            $fakeModel = new FakeModel();
            $fakeModel->{$field} = $fieldValue;
            $validators = $this->getValidators($fakeModel, $field);

            // skip an iteration if given field doesn't exist in validators list
            if (!$validators) {
                continue;
            }

            foreach ($validators as $validator) {
                if (!$validator->skipOnEmpty || !$validator->isEmpty($fieldValue)) {
                    $validator->validateAttribute($fakeModel, $field);
                }
            }

            $filteredValues[$field] = $fakeModel->{$field};
            if ($fakeModel->hasErrors($field)) {
                // remove a field from the valid values array if the field is incorrect
                if ($this->removeFieldOnError) {
                    unset($filteredValues[$field]);
                    $model->clearErrors($attribute);
                    continue;
                }
                // merge all errors in one list
                $validationErrors = $fakeModel->getErrors($field);
                $originalErrors = $model->getErrors($attribute);
                $model->clearErrors($attribute);
                if (!empty($originalErrors)) {
                    $model->addErrors([$attribute => $originalErrors]);
                }
                $fieldErrors = [];
                $fieldErrors[] = [$field => $validationErrors];
                if ($this->allowMessageFromRule) {
                    $model->addErrors([$attribute => $fieldErrors]);
                } else {
                    $this->addError($model, $attribute, $this->message, ['value' => $fieldValue]);
                    return;
                }
            }
        }

        $model->{$attribute} = $filteredValues;
    }

    /**
     * {@inheritdoc}
     */
    private function getValidator($model, $rule)
    {
        if ($rule instanceof Validator) {
            return $rule;
        }
        if (\is_array($rule) && isset($rule[0])) {
            if (!\is_object($model)) {
                $model = new Model();
            }
            return Validator::createValidator($rule[0], $model, $this->attributes, \array_slice($rule, 1));
        }
        throw new InvalidConfigException('Invalid validation rule: a rule must be an array specifying validator type.');
    }

    private function getValidators($model, $field)
    {
        if (!isset($this->fields[$field])) {
            return null;
        }

        if (!isset($this->fields[$field]['rules'])) {
            throw new InvalidConfigException('Invalid validation rules for an attribute ' . $field . ': rules are undefined.');
        }

        if (!\is_array($this->fields[$field]['rules'])) {
            throw new InvalidConfigException('Invalid validation rules for an attribute ' . $field . ': rules must be an array.');
        }

        if (empty($this->fields[$field]['rules'])) {
            throw new InvalidConfigException('Invalid validation rules for an attribute ' . $field . ': there must be at least one rule in a rules array.');
        }

        $validators = [];
        foreach ($this->fields[$field]['rules'] as $rule) {
            $validators[] = $this->getValidator($model, $rule);
        }
        return $validators;
    }
}
