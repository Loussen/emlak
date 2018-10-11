<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "email_changer".
 *
 * @property integer $id
 * @property string $old_email
 * @property string $new_email
 * @property string $code
 * @property integer $create_time
 * @property integer $step
 * @property integer $status
 */
class EmailChanger extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email_changer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['old_email', 'new_email', 'code', 'code2', 'create_time'], 'required'],
            [['create_time', 'status'], 'integer'],
            [['old_email', 'new_email'], 'string', 'max' => 50],
            [['code','code2'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'old_email' => 'Old Email',
            'new_email' => 'New Email',
            'code' => 'Code',
            'code2' => 'Code2',
            'create_time' => 'Create Time',
            'step' => 'Step',
        ];
    }
}
