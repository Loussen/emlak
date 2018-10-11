<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "announces_share".
 *
 * @property integer $id
 * @property integer $announce_id
 * @property integer $create_time
 */
class AnnouncesShare extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'announces_share';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['announce_id', 'create_time'], 'required'],
            [['announce_id', 'create_time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'announce_id' => 'Elanın kodu',
            'create_time' => 'Tarix',
        ];
    }
}
