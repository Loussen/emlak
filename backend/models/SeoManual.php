<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "seo_manual".
 *
 * @property integer $id
 * @property string $title_az
 * @property string $title_en
 * @property string $title_ru
 * @property string $title_tr
 */
class SeoManual extends \yii\db\ActiveRecord
{
    public static $titleName='Seo Kateoqoriyalar';

    public static $sortableConditionStatus=false;    // for $sortableConditionField
    public static $sortableConditionField='parent_id';
    public static $sortableConditionFieldOrder=SORT_ASC;

    public static $sortableStatus=false;     // Sortable enabled and disabled
    public static $sortablePositionOrder=SORT_ASC;
	
	
    public static function tableName()
    {
        return 'seo_manual';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_'], 'required'],
			[['title_'], 'string', 'max' => 255],
        ];
    }
	
	public static function getParentTitle($id,$fieldName)
    {
        $returnModel = self::find()->select($fieldName)->where(['id'=>$id])->asArray()->one();
        if($returnModel[$fieldName]=='') $returnModel[$fieldName]='';
        return $returnModel[$fieldName];
    }

    public static function getParents()
    {
        $returnModels = self::find()->all();
        $array = [0 => 'Ana kateqoriya'] + ArrayHelper::map($returnModels, 'id','title_');
        return $array;
    }
	
	public static function getCategories()
    {
        $returnModels = self::find()->orderBy(['title_'=>SORT_ASC])->all();
        $array = [0 => 'Ana kateqoriya'] + ArrayHelper::map($returnModels, 'id','title_');
        return $array;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_' => 'Title',
        ];
    }
}
