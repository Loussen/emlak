<?php

namespace backend\models;

use Yii;
use backend\components\MyFunctions;

/**
 * This is the model class for table "albums_inner".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $title_az
 * @property string $title_en
 * @property string $title_ru
 * @property string $image
 * @property integer $position
 * @property integer $create_time
 * @property integer $status
 */
class AlbumsInner extends \yii\db\ActiveRecord
{
    public static $titleName='Albom';

    public static $sortableConditionStatus=false;    // for $sortableConditionField
    public static $sortableConditionField='parent_id';
    public static $sortableConditionFieldOrder=SORT_ASC;

    public static $sortableStatus=true;     // Sortable enabled and disabled
    public static $sortablePositionOrder=SORT_ASC;

    const MAX_IMAGE_WIDTH=900, MAX_IMAGE_HEIGHT=600;
    const THUMB_IMAGE_WIDTH=175, THUMB_IMAGE_HEIGHT=150;

    public static function tableName()
    {
        return 'albums_inner';
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
            [['image'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Albom ID',
            'image' => 'Şəkil (optimal ölçü: XXX x XXX)',
            'position' => 'Sıralama',
            'create_time' => 'Yaranma tarixi',
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
