<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "currency".
 *
 * @property integer $id
 * @property double $usd
 * @property string $date
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usd', 'date'], 'required'],
            [['usd'], 'number'],
            [['date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usd' => 'Usd',
            'date' => 'Date',
        ];
    }
}
