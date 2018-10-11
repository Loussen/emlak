<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "users_equal_emails".
 *
 * @property integer $id
 * @property string $email
 * @property string $equal_id
 */
class UsersEqualEmails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_equal_emails';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'equal_id'], 'required'],
            [['email', 'equal_id'], 'string'],
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
            'equal_id' => 'Equal ID',
        ];
    }
}
