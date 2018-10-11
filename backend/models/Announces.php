<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "announces".
 *
 * @property integer $id
 * @property string $email
 * @property string $mobile
 * @property string $name
 * @property double $price
 * @property string $cover
 * @property integer $room_count
 * @property integer $rent_type
 * @property integer $property_type
 * @property integer $announce_type
 * @property integer $country
 * @property integer $city
 * @property integer $region
 * @property integer $settlement
 * @property integer $metro
 * @property string $mark
 * @property string $address
 * @property string $google_map
 * @property integer $floor_count
 * @property integer $current_floor
 * @property double $space
 * @property integer $repair
 * @property integer $document
 * @property string $text
 * @property integer $view_count
 * @property integer $announcer
 * @property integer $status
 * @property integer $insert_type
 * @property integer $urgently
 * @property integer $sort_search
 * @property integer $sort_foward
 * @property integer $sort_package
 * @property integer $sort_premium
 * @property integer $announce_date
 * @property integer $visitors_count
 * @property integer $create_time
 * @property string $sms_status
 * @property string $panarama
 * @property string $archive_view
 */
class Announces extends \yii\db\ActiveRecord
{
    public static $titleName='Elanlar';
    public static $titleNameSearch='Elan axtarışı';

    public static $sortableConditionStatus=false;    // for $sortableConditionField
    public static $sortableConditionField='parent_id';
    public static $sortableConditionFieldOrder=SORT_ASC;

    public static $sortableStatus=false;     // Sortable enabled and disabled
    public static $sortablePositionOrder=SORT_ASC;

    const MAX_IMAGE_WIDTH=800, MAX_IMAGE_HEIGHT=600;            // for original photo
    const THUMB_IMAGE_WIDTH=181, THUMB_IMAGE_HEIGHT=132;        // thumb for cover
    const THUMB2_IMAGE_WIDTH=108, THUMB2_IMAGE_HEIGHT=108;       // thumb for announce edit
    const THUMB3_IMAGE_WIDTH=560, THUMB3_IMAGE_HEIGHT=420;       // thumb for view announce


    public static function tableName()
    {
        return 'announces';
    }

    /**
     * @inheritdoc
     */
    public function rules(){
        return [
            [['email', 'mobile', 'name', 'price', 'room_count', 'rent_type', 'property_type', 'announce_type', 'country', 'address', 'google_map', 'floor_count', 'space', 'document', 'text', 'view_count', 'announcer', 'insert_type'], 'required'],
            [['price', 'space'], 'number'],
            [['room_count', 'rent_type', 'property_type', 'announce_type', 'country', 'city', 'region', 'settlement', 'metro', 'floor_count', 'current_floor', 'repair', 'document', 'view_count', 'announcer', 'status', 'insert_type', 'urgently', 'sort_search', 'sort_foward', 'sort_package', 'sort_premium', 'announce_date', 'visitors_count', 'create_time', 'archive_view'], 'integer'],
            [['text','panarama','sms_status'], 'string'],
            [['email', 'mobile', 'cover', 'mark', 'address','panarama'], 'string', 'max' => 255],
            [['name', 'google_map'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(){
        return [
            'id' => 'ID',
            'email' => 'Email',
            'mobile' => 'Telefon',
            'name' => 'Ad',
            'price' => 'Qiymət',
            'cover' => 'Əsas şəkil',
            'room_count' => 'Otaq sayı',
            'rent_type' => 'İcarə müddəti',
            'property_type' => 'Əmlakın növü',
            'announce_type' => 'Elanın növü',
            'country' => 'Ölkə',
            'city' => 'Şəhər',
            'region' => 'Region',
            'settlement' => 'Qəsəbə',
            'metro' => 'Metro',
            'mark' => 'Nişangah',
            'address' => 'Ünvan',
            'google_map' => 'Xəritədə ünvanı',
            'floor_count' => 'Mərtəbə sayı',
            'current_floor' => 'Yerləşdiyi mərtəbə',
            'space' => 'Sahəsi',
            'repair' => 'Təmir səviyyəsi',
            'document' => 'Sənədin tipi',
            'text' => 'Məlumat',
            'view_count' => 'Baxış sayı',
            'announcer' => 'Elanı verən',
            'status' => 'Status',
            'insert_type' => 'Insert Type',
            'urgently' => 'Urgently',
            'sort_search' => 'Sort Search',
            'sort_foward' => 'Sort Foward',
            'sort_package' => 'Sort Package',
            'sort_premium' => 'Sort Premium',
            'announce_date' => 'Tarix',
            'visitors_count' => 'Baxış sayı',
            'create_time' => 'Create Time',
            'panarama' => 'Panarama (360)',
            'sms_status' => 'SMS status',
            'archive_view' => 'Arxiv view'
        ];
    }
}
