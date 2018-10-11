<?php

namespace backend\models;

use Yii;
use backend\components\MyFunctions;

/**
 * This is the model class for table "countries".
 *
 * @property integer $id
 * @property string $title_az
 * @property string $title_en
 * @property string $title_ru
 * @property string $title_tr
 * @property integer $status
 */
class Regions extends \yii\db\ActiveRecord
{
    public static $titleName='Rayonlar';

    public static $sortableConditionStatus=false;    // for $sortableConditionField
    public static $sortableConditionField='parent_id';
    public static $sortableConditionFieldOrder=SORT_ASC;

    public static $sortableStatus=false;     // Sortable enabled and disabled
    public static $sortablePositionOrder=SORT_ASC;


    public static function tableName()
    {
        return 'regions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_'.Yii::$app->params["defaultLanguage"], 'status'], 'required'],
            [['status'], 'integer'],
            [MyFunctions::attrForLangs('title'), 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_az' => 'Title Az',
            'title_en' => 'Title En',
            'title_ru' => 'Title Ru',
            'title_tr' => 'Title Tr',
            'status' => 'Status',
        ];
    }
}
