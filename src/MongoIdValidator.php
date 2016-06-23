<?php

namespace consultnn\validators;

use MongoDB\BSON\ObjectID;
use Yii;
use yii\validators\Validator;

/**
 * @inheritdoc
 */
class MongoIdValidator extends Validator
{
    /**
     * @var bool Cast value to `MongoDB\BSON\ObjectID` if set `true`
     */
    public $cast = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = Yii::t('yii', '{attribute} is invalid.');
        }
    }

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        $mongoId = $this->parseMongoId($value);
        if (is_object($mongoId)) {
            if ($this->cast === true) {
                $model->$attribute = $mongoId;
            }
        } else {
            $this->addError($model, $attribute, $this->message, []);
        }
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        return is_object($this->parseMongoId($value)) ? null : [$this->message, []];
    }

    /**
     * @param mixed $value
     * @return \MongoId|null
     */
    private function parseMongoId($value)
    {
        if ($value instanceof ObjectID) {
            return $value;
        }
        try {
            return new ObjectID($value);
        } catch (\Exception $e) {
            return null;
        }
    }
}
