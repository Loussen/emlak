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
class Pages extends \yii\db\ActiveRecord
{
    public static $titleName='Səhifələr';

    public static $sortableConditionStatus=false;    // for $sortableConditionField
    public static $sortableConditionField='parent_id';
    public static $sortableConditionFieldOrder=SORT_DESC;

    public static $sortableStatus=false;     // Sortable enabled and disabled
    public static $sortablePositionOrder=SORT_DESC;

    const MAX_IMAGE_WIDTH=900, MAX_IMAGE_HEIGHT=600;
    const THUMB_IMAGE_WIDTH=130, THUMB_IMAGE_HEIGHT=130;

    public static function tableName()
    {
        return 'pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_'.Yii::$app->params["defaultLanguage"], 'status'], 'required'],
            [['position', 'status', 'save_mode'], 'integer'],
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

            $title='title_'.Yii::$app->params['defaultLanguage'];
            if(empty($this->slug)) $this->slug=MyFunctions::slugGenerator($this->$title);
            return true;
        } else {
            return false;
        }
    }
}
