<?php

namespace consultnn\validators;

use Yii;

/**
 * @inheritdoc
 */
class NumberValidator extends \yii\validators\NumberValidator
{
    /**
     * @var bool Cast value to `number` if set `true`
     */
    public $cast = false;

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        if (!is_numeric($value)) {
            $this->addError($model, $attribute, $this->message);
            return;
        }

        if ($this->cast === true) {
            $this->integerOnly ? settype($value, 'integer') : settype($value, 'float');
            $model->$attribute = $value;

            return null;
        }

        $pattern = $this->integerOnly ? $this->integerPattern : $this->numberPattern;
        if (!preg_match($pattern, "$value")) {
            $this->addError($model, $attribute, $this->message);
        }
        if ($this->min !== null && $value < $this->min) {
            $this->addError($model, $attribute, $this->tooSmall, ['min' => $this->min]);
        }
        if ($this->max !== null && $value > $this->max) {
            $this->addError($model, $attribute, $this->tooBig, ['max' => $this->max]);
        }
    }
}
