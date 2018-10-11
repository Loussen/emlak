<?php

namespace backend\models;

use Yii;
use backend\components\MyFunctions;

/**
 * This is the model class for table "pages".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $title_az
 * @property string $title_en
 * @property string $title_ru
 * @property string $title_tr
 * @property string $short_text_az
 * @property string $short_text_en
 * @property string $short_text_ru
 * @property string $short_text_tr
 * @property string $text_az
 * @property string $text_en
 * @property string $text_ru
 * @property string $text_tr
 * @property string $image
 * @property string $thumb
 * @property integer $position
 * @property string $slug
 * @property integer $status
 */
class Services extends \yii\db\ActiveRecord
{
    public static $titleName='Xidmətlər';

    const MAX_IMAGE_WIDTH=900, MAX_IMAGE_HEIGHT=600;
    const THUMB_IMAGE_WIDTH=130, THUMB_IMAGE_HEIGHT=130;

    public static function tableName()
    {
        return 'services';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_'.Yii::$app->params["defaultLanguage"], 'status'], 'required'],
            [['position', 'status'], 'integer'],
            [MyFunctions::attrForLangs('text'), 'string'],
            [MyFunctions::attrForLangs('short_text'), 'string'],
            [MyFunctions::attrForLangs('title'), 'string', 'max' => 255],
            [['image', 'thumb', 'slug'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
            'thumb' => 'Thumb',
            'position' => 'Position',
            'slug' => 'Slug',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            $title='title_'.Yii::$app->params['defaultLanguage'];
            if(empty($this->slug)) $this->slug=MyFunctions::slugGenerator($this->$title);
            return true;
        } else {
            return false;
        }
    }
}
