<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "announces_edited".
 *
 * @property integer $id
 * @property integer $message_status
 * @property integer $time
 * @property integer $ann_id
 * @property integer $sms_status
 * @property string $sms_id
 * @property integer $charge
 * @property string $error_text
 * @property string $mobile
 */
class SmsAnn extends \yii\db\ActiveRecord
{
    public static $titleName='Sms məlumatları';

    public static function tableName()
    {
        return 'sms_ann';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_status'], 'required'],
            [['message_status', 'time', 'ann_id', 'sms_status','charge'], 'integer'],
            [['sms_id','error_text','mobile'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message_status' => 'Mesaj status',
            'time' => 'Time',
            'ann_id' => 'Announce ID',
            'sms_status' => 'SMS status',
            'sms_id' => 'SMS ID',
            'charge' => 'Charge',
            'error_text' => 'Error message',
            'mobile' => 'Mobile phone'
        ];
    }
}
