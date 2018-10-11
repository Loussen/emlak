<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "password_changer".
 *
 * @property integer $id
 * @property string $email
 * @property string $code
 * @property integer $create_time
 * @property integer $status
 */
class PasswordChanger extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'password_changer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'code', 'create_time'], 'required'],
            [['create_time', 'status'], 'integer'],
            [['email'], 'string', 'max' => 50],
            [['code'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'code' => 'Code',
            'create_time' => 'Create Time',
            'status' => 'Status',
        ];
    }
}
