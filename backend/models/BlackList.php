<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "black_list".
 *
 * @property integer $id
 * @property string $mobile
 * @property integer $date
 * @property integer $time
 * @property integer $from_
 * @property string $reason
 */
class BlackList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'black_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile', 'time', 'from_'], 'required'],
            [['date', 'time', 'from_', 'status'], 'integer'],
            [['mobile', 'reason'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mobile' => 'Telefon',
            'date' => 'Tarix',
            'time' => 'Müddət',
            'from_' => 'Kim tərəfindən',
            'reason' => 'Səbəb',
            'status' => 'Status',
        ];
    }
}
