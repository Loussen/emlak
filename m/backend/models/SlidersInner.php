<?php

namespace backend\models;

use backend\components\MyFunctions;
use Yii;

class SlidersInner extends \yii\db\ActiveRecord
{
    public static $titleName='Slider';

    public static $sortableConditionStatus=false;    // for $sortableConditionField
    public static $sortableConditionField='parent_id';
    public static $sortableConditionFieldOrder=SORT_ASC;

    public static $sortableStatus=true;     // Sortable enabled and disabled
    public static $sortablePositionOrder=SORT_ASC;

    const MAX_IMAGE_WIDTH=900, MAX_IMAGE_HEIGHT=600;
    const THUMB_IMAGE_WIDTH=175, THUMB_IMAGE_HEIGHT=150;

    public static function tableName()
    {
        return 'sliders_inner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            [['parent_id', 'position', 'create_time', 'status'], 'integer'],
            [MyFunctions::attrForLangs('title'), 'string', 'max' => 255],
            [['image', 'thumb', 'target', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Slider ID',
            'image' => 'Şəkil (optimal ölçü: XXX x XXX)',
            'thumb' => 'Thumb',
            'target' => 'Target',
            'url' => 'Url',
            'position' => 'Position',
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
                $last=self::find()->where($where)->orderBy('position desc')->one();
                if($last==NULL) $this->position=1;
                else $this->position=++$last->position;
            }

            if($this->isNewRecord) $this->create_time=time();

            return true;
        } else {
            return false;
        }
    }
}
