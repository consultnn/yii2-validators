<?php

namespace consultnn\validators;

use Yii;
use yii\validators\ValidationAsset;

/**
 * @inheritdoc
 */
class BooleanValidator extends \yii\validators\BooleanValidator
{
    /**
     * @var bool Cast value to `boolean` if set `true`
     */
    public $cast = false;

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        if ($this->cast === true) {
            $model->$attribute = (bool) $model->$attribute;

            return null;
        }

        $result = $this->validateValue($model->$attribute);
        if (!empty($result)) {
            $this->addError($model, $attribute, $result[0], $result[1]);
        }
    }
}
