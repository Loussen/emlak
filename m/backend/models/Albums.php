<?php

namespace backend\models;

use Yii;
use backend\components\MyFunctions;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "albums".
 *
 * @property integer $id
 * @property string $title_az
 * @property string $title_en
 * @property string $title_ru
 * @property string $text_az
 * @property string $text_en
 * @property string $text_ru
 * @property string $image
 * @property string $table_name
 * @property integer $table_id
 * @property integer $position
 * @property string $slug
 * @property integer $create_time
 * @property integer $status
 */
class Albums extends \yii\db\ActiveRecord
{
    public static $titleName='Albomlar';

    public static $sortableConditionStatus=false;    // for $sortableConditionField
    public static $sortableConditionField='parent_id';
    public static $sortableConditionFieldOrder=SORT_ASC;

    public static $sortableStatus=true;     // Sortable enabled and disabled
    public static $sortablePositionOrder=SORT_ASC;

    const MAX_IMAGE_WIDTH=900, MAX_IMAGE_HEIGHT=600;
    const THUMB_IMAGE_WIDTH=175, THUMB_IMAGE_HEIGHT=150;

    public static function tableName()
    {
        return 'albums';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_'.Yii::$app->params["defaultLanguage"], 'status'], 'required'],
            [MyFunctions::attrForLangs('title'), 'string'],
            [['table_id', 'position', 'create_time', 'status', 'save_mode'], 'integer'],
            [['image'], 'image'],
            [MyFunctions::attrForLangs('text'), 'string', 'max' => 255],
            [['table_name', 'slug'], 'string', 'max' => 255],
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
            'table_name' => 'Table Name',
            'table_id' => 'Table ID',
            'position' => 'Sıralama',
            'slug' => 'Slug',
            'create_time' => 'Create Time',
            'status' => 'Status',
        ];
    }

    public static function getAlbums()
    {
        $returnModels = self::find()->orderBy(['title_'.Yii::$app->params["defaultLanguage"]=>SORT_ASC])->all();
        $array = [0 => ''] + ArrayHelper::map($returnModels, 'id','title_'.Yii::$app->params["defaultLanguage"]);
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
            if($this->isNewRecord) $this->create_time=time();

            $title='title_'.Yii::$app->params['defaultLanguage'];
            if(empty($this->slug)) $this->slug=MyFunctions::slugGenerator($this->$title);
            return true;
        } else {
            return false;
        }
    }
}
