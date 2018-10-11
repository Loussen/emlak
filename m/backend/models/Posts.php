<?php

namespace backend\models;

use Yii;
use backend\components\MyFunctions;

/**
 * This is the model class for table "posts".
 *
 * @property string $id
 * @property integer $category_id
 * @property integer $album_id
 * @property integer $author_id
 * @property string $title_az
 * @property string $title_en
 * @property string $title_ru
 * @property string $short_text_az
 * @property string $short_text_en
 * @property string $short_text_ru
 * @property string $text_az
 * @property string $text_en
 * @property string $text_ru
 * @property string $tags
 * @property integer $view_count
 * @property integer $like_count
 * @property integer $dislike_count
 * @property integer $comment_count
 * @property integer $news_time
 * @property integer $flash_status
 * @property string $slug
 * @property integer $create_time
 * @property integer $status
 */
class Posts extends \yii\db\ActiveRecord
{
    public static $titleName='Yazılar';

    const MAX_IMAGE_WIDTH=900, MAX_IMAGE_HEIGHT=600;
    const THUMB_IMAGE_WIDTH=332, THUMB_IMAGE_HEIGHT=246;

    public $table_name;

    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'title_'.Yii::$app->params["defaultLanguage"]], 'required'],
            [['category_id', 'album_id', 'author_id', 'view_count', 'like_count', 'dislike_count', 'comment_count', 'flash_status', 'status'], 'integer'],
            [MyFunctions::attrForLangs('text'), 'string'],
            [MyFunctions::attrForLangs('short_text'), 'string'],
            [MyFunctions::attrForLangs('title'), 'string', 'max' => 255],
            [['tags', 'slug'], 'string', 'max' => 255],
            [['news_time','create_time' ],'safe'],
            [['image'], 'image']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Kateqoriya',
            'album_id' => 'Albom',
            'author_id' => 'Müəllif',
            'tags' => 'Teqlər',
            'view_count' => 'View Count',
            'like_count' => 'Like Count',
            'dislike_count' => 'Dislike Count',
            'comment_count' => 'Comment Count',
            'news_time' => 'Tarix',
            'flash_status' => 'Flash (Manşet)',
            'image' => 'Şəkil (optimal ölçü: XXX x XXX)',
            'slug' => 'Slug',
            'create_time' => 'Create Time',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->news_time!='')
            {
                if(!is_int(($this->news_time))) $this->news_time=strtotime($this->news_time);
            }
            else $this->news_time=strtotime(date("d-m-Y"));

            if($this->isNewRecord) $this->create_time=time();

            $title='title_'.Yii::$app->params['defaultLanguage'];
            if(empty($this->slug)) $this->slug=MyFunctions::slugGenerator($this->$title);
            return true;
        } else {
            return false;
        }
    }
}
