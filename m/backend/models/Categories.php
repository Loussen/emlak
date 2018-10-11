<?php

namespace backend\models;

use backend\components\MyFunctions;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "categories".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $table_name
 * @property string $title_az
 * @property integer $position
 * @property string $slug
 * @property integer $status
 */
class Categories extends \yii\db\ActiveRecord
{
    public static $titleName='Kateqoriyalar';

    public static $sortableConditionStatus=true;    // for $sortableConditionField
    public static $sortableConditionField='parent_id';
    public static $sortableConditionFieldOrder=SORT_ASC;

    public static $sortableStatus=true;     // Sortable enabled and disabled
    public static $sortablePositionOrder=SORT_ASC;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_'.Yii::$app->params["defaultLanguage"], 'status'], 'required'],
            [['parent_id', 'position', 'status', 'save_mode'], 'integer'],
            [['table_name'], 'string', 'max' => 20],
            [MyFunctions::attrForLangs('title'), 'string', 'max' => 255],
            [['slug'], 'string', 'max' => 255],
            [MyFunctions::attrForLangs('text'), 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Ana kateqoriya',
            'table_name' => 'Table Name',
            'position' => 'Sıralama',
            'slug' => 'Slug',
            'status' => 'Status',
        ];
    }

    /**
     * modelFunctions .. our Functions
     */
    public static function getParentTitle($id,$fieldName)
    {
        $returnModel = self::find()->select($fieldName)->where(['id'=>$id])->asArray()->one();
        if($returnModel[$fieldName]=='') $returnModel[$fieldName]='';
        return $returnModel[$fieldName];
    }

    public static function getParents()
    {
        $returnModels = self::find()->all();
        $array = [0 => 'Ana kateqoriya'] + ArrayHelper::map($returnModels, 'id','title_'.Yii::$app->params["defaultLanguage"]);
        return $array;
    }

    public static function getCategories()
    {
        $returnModels = self::find()->orderBy(['title_'.Yii::$app->params["defaultLanguage"]=>SORT_ASC])->all();
        $array = [0 => 'Ana kateqoriya'] + ArrayHelper::map($returnModels, 'id','title_'.Yii::$app->params["defaultLanguage"]);
        return $array;
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
