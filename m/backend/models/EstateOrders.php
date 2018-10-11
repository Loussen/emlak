<?php

namespace backend\models;
use Yii;

/**
 * This is the model class for table "estate_orders".
 *
 * @property integer $id
 * @property integer $type
 * @property string $title
 * @property string $text
 * @property string $name
 * @property string $phone
 * @property integer $create_time
 * @property integer $status
 */
class EstateOrders extends \yii\db\ActiveRecord
{
    public static $titleName='Əmlak sifarişləri';

    public static $sortableConditionStatus=false;    // for $sortableConditionField
    public static $sortableConditionField='parent_id';
    public static $sortableConditionFieldOrder=SORT_DESC;

    public static $sortableStatus=true;     // Sortable enabled and disabled
    public static $sortablePositionOrder=SORT_DESC;


    public static function tableName()
    {
        return 'estate_orders';
    }

    public static function getType($type='all')
    {
        $array = [1 => 'Əmlak alıram', 2 => 'İcarəyə axtarıram'];
        if(is_numeric($type))
            return $array[$type];
        else
            return $array;
    }

    public function rules()
    {
        return [
            [['type', 'title', 'text','name','phone'], 'required'],
            [['type', 'create_time', 'status', 'position'], 'integer'],
            [['text'], 'string'],
            [['title', 'name', 'phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'title' => 'Title',
            'text' => 'Text',
            'name' => 'Name',
            'phone' => 'Phone',
            'create_time' => 'Create Time',
            'status' => 'Status',
            'position' => 'Sıralama',
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
