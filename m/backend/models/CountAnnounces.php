<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "count_announces".
 *
 * @property integer $id
 * @property string $count_announces
 */
class CountAnnounces extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'count_announces';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['count_announces'], 'required'],
            [['count_announces'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'count_announces' => 'Count Announces',
        ];
    }
}
