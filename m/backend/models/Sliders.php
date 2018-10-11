<?php

namespace backend\models;

use backend\components\MyFunctions;
use Yii;

/**
 * This is the model class for table "sliders".
 *
 * @property integer $id
 * @property string $title_az
 * @property string $title_en
 * @property string $title_ru
 * @property string $text_az
 * @property string $text_en
 * @property string $text_ru
 * @property string $table_name
 * @property integer $create_time
 * @property integer $status
 */
class Sliders extends \yii\db\ActiveRecord
{
    public static $titleName='Slider';

    public static $sortableConditionStatus=false;    // for $sortableConditionField
    public static $sortableConditionField='parent_id';
    public static $sortableConditionFieldOrder=SORT_ASC;

    public static $sortableStatus=false;     // Sortable enabled and disabled
    public static $sortablePositionOrder=SORT_ASC;


    public static function tableName()
    {
        return 'sliders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_'.Yii::$app->params["defaultLanguage"],'status'], 'required'],
            [MyFunctions::attrForLangs('text'), 'string'],
            [['create_time', 'status', 'save_mode'], 'integer'],
            [MyFunctions::attrForLangs('title'), 'string', 'max' => 255],
            [['table_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'table_name' => 'Table Name',
            'table_id' => 'Table Id',
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
            return true;
        } else {
            return false;
        }
    }
}
