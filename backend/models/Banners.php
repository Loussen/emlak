<?php

namespace backend\models;

use backend\components\MyFunctions;
use Yii;

/**
 * This is the model class for table "banners".
 *
 * @property integer $id
 * @property string $title_az
 * @property string $title_en
 * @property string $title_ru
 * @property string $text_az
 * @property string $text_en
 * @property string $text_ru
 * @property integer $position
 * @property integer $status
 */
class Banners extends \yii\db\ActiveRecord
{
    public static $titleName='Bannerlər';

    public static $sortableConditionStatus=false;    // for $sortableConditionField
    public static $sortableConditionField='parent_id';
    public static $sortableConditionFieldOrder=SORT_ASC;

    public static $sortableStatus=false;     // Sortable enabled and disabled
    public static $sortablePositionOrder=SORT_ASC;


    public static function tableName()
    {
        return 'banners';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_'.Yii::$app->params["defaultLanguage"], 'status'], 'required'],
            [MyFunctions::attrForLangs('text'), 'string'],
            [['position', 'status', 'save_mode'], 'integer'],
            [MyFunctions::attrForLangs('title'), 'string', 'max' => 255],
        ];
    }

    public static function getBanners()
    {
        $returnModels = self::find()->select(['text_'.Yii::$app->params["defaultLanguage"],'position'])->orderBy(['position'=>SORT_ASC])->asArray()->all();
        return $returnModels;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'position' => 'Position',
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
            return true;
        } else {
            return false;
        }
    }
}
