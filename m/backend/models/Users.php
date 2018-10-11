<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $login
 * @property string $name
 * @property string $image
 * @property string $thumb
 * @property string $mobile
 * @property string $address
 * @property string $text
 * @property integer $newsletter
 * @property integer $package_announce
 * @property integer $package_foward
 * @property integer $package_search
 * @property integer $premium
 * @property integer $announce_count
 * @property integer $create_time
 * @property integer $status
 */
class Users extends \yii\db\ActiveRecord
{
    public static $titleName="İstifadəçilər";

    const MAX_IMAGE_WIDTH=900, MAX_IMAGE_HEIGHT=600;
    const THUMB_IMAGE_WIDTH=160, THUMB_IMAGE_HEIGHT=160;

    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['text'], 'string'],
            [['newsletter', 'package_announce', 'package_foward', 'package_search', 'announce_count', 'create_time', 'status', 'premium'], 'integer'],
            [['email', 'login', 'name'], 'string', 'max' => 50],
            [['password', 'image', 'thumb', 'mobile', 'address'], 'string', 'max' => 255],
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
            'password' => 'Password',
            'login' => 'Login',
            'name' => 'Name',
            'image' => 'Image',
            'thumb' => 'Thumb',
            'mobile' => 'Mobile',
            'address' => 'Address',
            'text' => 'Text',
            'newsletter' => 'Newsletter',
            'package_announce' => 'Elan paket sayı',
            'package_foward' => 'İrəli çəkmə paket sayı',
            'package_search' => 'Axtarışda irəli çəkmə',
            'premium' => 'Profilin əmlakçılar bölməsində (gün)',
            'announce_count' => 'Announce Count',
            'create_time' => 'Create Time',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->isNewRecord) $this->create_time=time();
            return true;
        } else {
            return false;
        }
    }
}
