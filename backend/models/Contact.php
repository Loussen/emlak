<?php

namespace backend\models;

use backend\components\MyFunctions;
use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property integer $id
 * @property string $text_az
 * @property string $text_en
 * @property string $text_ru
 * @property string $text_tr
 * @property string $footer_az
 * @property string $footer_en
 * @property string $footer_ru
 * @property string $footer_tr
 * @property string $email
 * @property string $facebook
 * @property string $twitter
 * @property string $vkontakte
 * @property string $linkedin
 * @property string $digg
 * @property string $flickr
 * @property string $dribbble
 * @property string $vimeo
 * @property string $myspace
 * @property string $google
 * @property string $youtube
 * @property string $instagram
 * @property string $phone
 * @property string $mobile
 * @property string $skype
 * @property string $fax
 * @property string $google_map
 * @property integer $position
 * @property string $slug
 * @property integer $status
 */
class Contact extends \yii\db\ActiveRecord
{
    public static $titleName='Əlaqə';

    public static $sortableConditionStatus=false;    // for $sortableConditionField
    public static $sortableConditionField='parent_id';
    public static $sortableConditionFieldOrder=SORT_ASC;

    public static $sortableStatus=true;     // Sortable enabled and disabled
    public static $sortablePositionOrder=SORT_ASC;


    public static function tableName()
    {
        return 'contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [MyFunctions::attrForLangs('text'), 'string'],
            [MyFunctions::attrForLangs('footer'), 'string'],
            [MyFunctions::attrForLangs('address'), 'string'],
            [['google_map'], 'string'],
            [['position', 'status', 'save_mode'], 'integer'],
            [MyFunctions::attrForLangs('address'), 'string', 'max' => 255],
            [['email', 'facebook', 'twitter', 'vkontakte', 'linkedin', 'digg', 'flickr', 'dribbble', 'vimeo', 'myspace', 'google', 'youtube', 'instagram', 'phone', 'mobile', 'phone2', 'mobile2', 'skype', 'fax', 'reklam_phone', 'slug'], 'string', 'max' => 255],
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
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'vkontakte' => 'Vkontakte',
            'linkedin' => 'Linkedin',
            'digg' => 'Digg',
            'flickr' => 'Flickr',
            'dribbble' => 'Dribbble',
            'vimeo' => 'Vimeo',
            'myspace' => 'Myspace',
            'google' => 'Google',
            'youtube' => 'Youtube',
            'instagram' => 'Instagram',
            'phone' => 'Phone',
            'mobile' => 'Mobile',
            'phone2' => 'Phone (Yaşayış kompleksi)',
            'mobile2' => 'Mobile (Yaşayış kompleksi)',
            'skype' => 'Skype',
            'fax' => 'Fax',
            'reklam_phone' => 'Reklam Phone',
            'google_map' => 'Google Map',
            'position' => 'Position',
            'slug' => 'Slug',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->isNewRecord && self::$sortableStatus===true)
            {
                $where=[];
                if(self::$sortableConditionStatus===true)
                {
                    $sortableConditionField=self::$sortableConditionField;
                    $where=[$sortableConditionField=>$this->$sortableConditionField];
                }
                if(empty($this->position))
                {
                    $last=self::find()->where($where)->orderBy('position desc')->one();
                    if($last==NULL) $this->position=1;
                    else $this->position=++$last->position;
                }
            }
            return true;
        } else {
            return false;
        }
    }
}
