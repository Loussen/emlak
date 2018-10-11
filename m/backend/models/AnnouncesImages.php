<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "announces_images".
 *
 * @property integer $id
 * @property integer $announce_id
 * @property string $image
 * @property string $withlogo
 * @property integer $position
 * @property integer $status
 * @property integer $changed
 * @property integer $create_time
 */
class AnnouncesImages extends \yii\db\ActiveRecord
{
    public static $titleName='Elanın şəkilləri';

    public static $sortableConditionStatus=false;    // for $sortableConditionField
    public static $sortableConditionField='parent_id';
    public static $sortableConditionFieldOrder=SORT_ASC;

    public static $sortableStatus=false;     // Sortable enabled and disabled
    public static $sortablePositionOrder=SORT_ASC;

    const MAX_IMAGE_WIDTH=800, MAX_IMAGE_HEIGHT=600;            // for original photo
    const THUMB_IMAGE_WIDTH=181, THUMB_IMAGE_HEIGHT=132;        // thumb for home page
    const THUMB2_IMAGE_WIDTH=123, THUMB2_IMAGE_HEIGHT=89;       // thumb for announce edit
    const THUMB3_IMAGE_WIDTH=560, THUMB3_IMAGE_HEIGHT=420;       // thumb for view announce


    public static function tableName()
    {
        return 'announces_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['announce_id', 'image', 'position', 'create_time'], 'required'],
            [['announce_id', 'position', 'status', 'changed', 'create_time'], 'integer'],
            [['image', 'withlogo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'announce_id' => 'Announce ID',
            'image' => 'Image',
            'withlogo' => 'Withlogo',
            'position' => 'Position',
            'status' => 'Status',
            'changed' => 'Changed',
            'create_time' => 'Create Time',
        ];
    }
}
