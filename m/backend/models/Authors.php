<?php

namespace backend\models;

use Yii;
use backend\components\MyFunctions;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "authors".
 *
 * @property integer $id
 * @property string $name
 * @property string $about_az
 * @property string $about_en
 * @property string $about_ru
 * @property string $image
 * @property integer $post_count
 * @property integer $last_post_time
 * @property string $slug
 * @property integer $create_time
 * @property integer $status
 */
class Authors extends \yii\db\ActiveRecord
{
    public static $titleName='Müəlliflər';

    public static $sortableConditionStatus=false;    // for $sortableConditionField
    public static $sortableConditionField='parent_id';
    public static $sortableConditionFieldOrder=SORT_ASC;

    public static $sortableStatus=true;     // Sortable enabled and disabled
    public static $sortablePositionOrder=SORT_ASC;

    const MAX_IMAGE_WIDTH=900, MAX_IMAGE_HEIGHT=600;
    const THUMB_IMAGE_WIDTH=175, THUMB_IMAGE_HEIGHT=150;

    public static function tableName()
    {
        return 'authors';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [MyFunctions::attrForLangs('about'), 'string'],
            [['post_count', 'last_post_time', 'create_time', 'status'], 'integer'],
            [['name', 'image', 'slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Ad',
            'image' => 'Şəkil (optimal ölçü: XXX x XXX)',
            'post_count' => 'Yazı sayı',
            'last_post_time' => 'Son yazı tarixi',
            'slug' => 'Slug',
            'create_time' => 'Create Time',
            'status' => 'Status',
        ];
    }

    public static function getAuthors()
    {
        $returnModels = self::find()->orderBy(['name'=>SORT_ASC])->all();
        $array = [0 => ''] + ArrayHelper::map($returnModels, 'id','name');
        return $array;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->isNewRecord) $this->create_time=time();

            $title='name';
            if(empty($this->slug)) $this->slug=MyFunctions::slugGenerator($this->$title);
            return true;
        } else {
            return false;
        }
    }
}
