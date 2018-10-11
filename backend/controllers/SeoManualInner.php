<?php

namespace backend\models;

use Yii;
use backend\components\MyFunctions;

/**
 * This is the model class for table "seo_manual_inner".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $link_
 * @property string $title_
 * @property string $description_
 * @property string $keywords_
 * @property string $page_title
 * @property string $text_top
 * @property string $text_bottom
 * @property string $sql_
 * @property string $word_
 * @property integer $status
 */
class SeoManualInner extends \yii\db\ActiveRecord
{
    public static $titleName='Seo Manual';

    public static $sortableConditionStatus=false;    // for $sortableConditionField
    public static $sortableConditionField='parent_id';
    public static $sortableConditionFieldOrder=SORT_ASC;

    public static $sortableStatus=false;     // Sortable enabled and disabled
    public static $sortablePositionOrder=SORT_ASC;
	
	
    public static function tableName()
    {
        return 'seo_manual_inner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_'], 'required'],
            [['parent_id', 'status'], 'integer'],
            [['text_top', 'text_bottom'], 'string'],
            //[['link_', 'title_', 'description_', 'sql_'], 'string', 'max' => 999],
            [['keywords_', 'page_title', 'word_'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'link_' => 'Link',
            'title_' => 'Link',
            'description_' => 'Description',
            'keywords_' => 'Keywords',
            'page_title' => 'Title',
            'text_top' => 'Text Top',
            'text_bottom' => 'Text Bottom',
            'sql_' => 'Sql',
            'word_' => 'Word',
            'status' => 'Status',
        ];
    }
}
