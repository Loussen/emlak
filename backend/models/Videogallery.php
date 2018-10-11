<?php

namespace backend\models;

use Yii;
use backend\components\MyFunctions;

/**
 * This is the model class for table "videogallery".
 *
 * @property integer $id
 * @property string $title_az
 * @property string $title_en
 * @property string $title_ru
 * @property string $text_az
 * @property string $text_en
 * @property string $text_ru
 * @property string $image
 * @property string $thumb
 * @property integer $position
 * @property string $slug
 * @property integer $create_time
 * @property integer $status
 */
class Videogallery extends \yii\db\ActiveRecord
{
    public static $titleName='Videolar';

    public static $sortableConditionStatus=false;    // for $sortableConditionField
    public static $sortableConditionField='parent_id';
    public static $sortableConditionFieldOrder=SORT_ASC;

    public static $sortableStatus=true;     // Sortable enabled and disabled
    public static $sortablePositionOrder=SORT_ASC;

    const MAX_IMAGE_WIDTH=900, MAX_IMAGE_HEIGHT=600;
    const THUMB_IMAGE_WIDTH=175, THUMB_IMAGE_HEIGHT=150;


    public static function tableName()
    {
        return 'videogallery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_'.Yii::$app->params["defaultLanguage"], 'status'], 'required'],
            [MyFunctions::attrForLangs('text'), 'string'],
            [['position', 'create_time', 'status', 'save_mode'], 'integer'],
            [MyFunctions::attrForLangs('title'), 'string', 'max' => 255],
            [['image', 'thumb', 'slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Şəkil (optimal ölçü: XXX x XXX)',
            'thumb' => 'Thumb',
            'position' => 'Position',
            'slug' => 'Slug',
            'create_time' => 'Create Time',
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
            if($this->isNewRecord) $this->create_time=time();
            $title='title_'.Yii::$app->params['defaultLanguage'];
            if(empty($this->slug)) $this->slug=MyFunctions::slugGenerator($this->$title);
            return true;
        } else {
            return false;
        }
    }
}
