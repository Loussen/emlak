<?php

namespace backend\models;

use backend\components\MyFunctions;
use Yii;

/**
 * This is the model class for table "apartments".
 *
 * @property string $id
 * @property integer $album_id
 * @property string $title_az
 * @property string $title_en
 * @property string $title_ru
 * @property string $title_tr
 * @property string $short_text_az
 * @property string $short_text_en
 * @property string $short_text_ru
 * @property string $short_text_tr
 * @property string $about_project_az
 * @property string $about_project_en
 * @property string $about_project_ru
 * @property string $about_project_tr
 * @property string $about_company_az
 * @property string $about_company_en
 * @property string $about_company_ru
 * @property string $about_company_tr
 * @property string $google_map
 * @property string $price
 * @property string $address
 * @property integer $position
 * @property string $email
 * @property string $mobile
 * @property string $image
 * @property string $thumb
 * @property string $slug
 * @property integer $status
 */
class Apartments extends \yii\db\ActiveRecord
{
    public static $titleName='Yaşayış kompleksləri';

    public static $sortableConditionStatus=false;    // for $sortableConditionField
    public static $sortableConditionField='parent_id';
    public static $sortableConditionFieldOrder=SORT_ASC;

    public static $sortableStatus=true;     // Sortable enabled and disabled
    public static $sortablePositionOrder=SORT_DESC;

    const MAX_IMAGE_WIDTH=900, MAX_IMAGE_HEIGHT=600;
    const THUMB_IMAGE_WIDTH=310, THUMB_IMAGE_HEIGHT=330;

    public static function tableName()
    {
        return 'apartments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_'.Yii::$app->params["defaultLanguage"], 'short_text_'.Yii::$app->params["defaultLanguage"], 'email', 'mobile', 'status','google_map'], 'required'],
            [['album_id', 'status','position','album_id2','view_count'], 'integer'],
            [MyFunctions::attrForLangs('title'), 'string'],
            [MyFunctions::attrForLangs('short_text'), 'string'],
            [MyFunctions::attrForLangs('about_project'), 'string'],
            [MyFunctions::attrForLangs('about_company'), 'string'],
            [MyFunctions::attrForLangs('address'), 'string'],
            [['price','google_map'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'album_id' => 'Albom ID',
            'album_id2' => 'Plan şəkilləri',
            'title_az' => 'Ad (Az)',
            'title_en' => 'Ad (En)',
            'title_ru' => 'Ad (Ru)',
            'title_tr' => 'Ad (Tr)',
            'short_text_az' => 'Qısa informasiya (Az)',
            'short_text_en' => 'Qısa informasiya (En)',
            'short_text_ru' => 'Qısa informasiya (Ru)',
            'short_text_tr' => 'Qısa informasiya (Tr)',
            'about_project_az' => 'Layihə haqqında (Az)',
            'about_project_en' => 'Layihə haqqında (En)',
            'about_project_ru' => 'Layihə haqqında (Ru)',
            'about_project_tr' => 'Layihə haqqında (Tr)',
            'about_company_az' => 'Şirkət haqqında (Az)',
            'about_company_en' => 'Şirkət haqqında (En)',
            'about_company_ru' => 'Şirkət haqqında (Ru)',
            'about_company_tr' => 'Şirkət haqqında (Tr)',
            'address_az' => 'Ünvan (Az)',
            'address_en' => 'Ünvan (En)',
            'address_ru' => 'Ünvan (Ru)',
            'address_tr' => 'Ünvan (Tr)',
            'google_map' => 'Xəritə kordinantları',
            'price' => 'Qiymət',
            'email' => 'Email',
            'mobile' => 'Telefon',
            'image' => 'Şəkil',
            'thumb' => 'Thumb',
            'logo' => 'Logo',
            'slug' => 'Slug',
            'position' => 'Sıra',
            'status' => 'Status',
            'view_count' => 'Baxış sayı',
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
				$this->view_count=0;
            }

            $title='title_'.Yii::$app->params['defaultLanguage'];
            if(empty($this->slug)) $this->slug=MyFunctions::slugGenerator($this->$title);
            return true;
        } else {
            return false;
        }
    }
}
