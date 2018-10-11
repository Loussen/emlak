<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "uye".
 *
 * @property integer $id
 * @property integer $c_id
 * @property integer $y_id
 * @property string $name
 */
class Uye extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'uye';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['c_id', 'y_id', 'name'], 'required'],
            [['c_id', 'y_id'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'c_id' => 'C ID',
            'y_id' => 'Y ID',
            'name' => 'Name',
        ];
    }
}
