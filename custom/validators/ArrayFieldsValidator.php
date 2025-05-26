<?php

declare(strict_types=1);

namespace app\custom\validators;

use app\custom\validators\fake\FakeModel;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\validators\Validator;

/**
 * Validates an array of fields that will be saved in one attribute
 * For each field specified a validator by field name.
 *
 * ```
 * ['worktime', 'app\custom\validators\ArrayFieldsValidator',
 *      'fields' => [
 *          'day' => ['rule' => ['string']],
 *          'time' => ['rule' => ['string']],
 *      ],
 *  ],
 * ```
 *
 *  @author Chistyakov Ilya <ichistyakovv@gmail.com>
 */
class ArrayFieldsValidator extends Validator
{
    public $fields;
    public $allowMessageFromRule = true;
    public $removeFieldOnError = true;
    private $validators = [];

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

        $filteredValues = [];
        foreach ($model->{$attribute} as $k => $fields) {
            foreach ($fields as $field => $fieldValue) {
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

                $filteredValues[$k][$field] = $fakeModel->{$field};
                if ($fakeModel->hasErrors($field)) {
                    // remove a field from the valid values array if the field is incorrect
                    if ($this->removeFieldOnError) {
                        unset($filteredValues[$k][$field]);
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
                    $fieldErrors[] = [$k => [$field => $validationErrors]];
                    if ($this->allowMessageFromRule) {
                        $model->addErrors([$attribute => $fieldErrors]);
                    } else {
                        $this->addError($model, $attribute, $this->message, ['value' => $fieldValue]);
                        return;
                    }
                }
            }
        }
        $model->{$attribute} = $filteredValues;
    }

    /**
     * {@inheritdoc}
     */
    private function getValidator($model, $rule, $field)
    {
        if (isset($this->validators[$field])) {
            return $this->validators[$field];
        }

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
            $validators[] = $this->getValidator($model, $rule, $field);
        }
        return $validators;
    }
}
